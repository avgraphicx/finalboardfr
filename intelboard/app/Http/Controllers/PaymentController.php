<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\PaymentImportException;
use App\Models\Driver;
use App\Services\PaymentImportService;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentImportService $paymentImportService)
    {}

    // Kept for completeness (index not used if routes point to importForm)
    public function index()
    {
        $payments = Payment::with('driver')->paginate(15);
        return view('pages.payments', compact('payments'));
    }

    public function importForm()
    {
        return view('pages.payments.import');
    }

    public function previewBatch(Request $request)
    {
        $validated = $request->validate([
            'pdfs' => ['required', 'array', 'min:1', 'max:1000'],
            'pdfs.*' => ['file', 'mimes:pdf', 'max:25600'],
        ]);

        $files = $request->file('pdfs', []);
        try {
            $preview = $this->paymentImportService->previewBatch($files);

            return view('pages.payments.preview', [
                'token' => $preview['token'],
                'items' => $preview['items'],
            ]);
        } catch (\Throwable $e) {
            \Log::error('Error previewing payment PDFs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['pdfs' => __('messages.payment_error_processing')])->withInput();
        }
    }

    public function importBatch(Request $request)
    {
        \Log::info('=== importBatch START ===', [
            'all_request' => $request->all(),
            'token' => $request->input('token'),
            'selected_raw' => $request->input('selected'),
        ]);

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'selected' => ['array'],
            'selected.*' => ['string'],
        ]);

        $selected = $validated['selected'] ?? [];

        \Log::info('=== importBatch VALIDATED ===', [
            'token' => $validated['token'],
            'selected' => $selected,
            'selected_count' => count($selected),
        ]);

        try {
            $result = $this->paymentImportService->importBatch($validated['token'], $selected, Auth::id());

            \Log::info('=== importBatch SUCCESS ===', [
                'result' => $result,
            ]);

            return redirect()
                ->route('invoices.index')
                ->with('success', __('messages.success_text', ['count' => $result['saved']]) . ' ' . ($result['failed'] > 0 ? __('messages.partially_saved_text', ['saved' => $result['saved'], 'failed' => $result['failed']]) : ''));
        } catch (PaymentImportException $e) {
            \Log::error('=== importBatch PaymentImportException ===', [
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('payments.importForm')
                ->withErrors(['token' => $e->getMessage()]);
        } catch (\Throwable $e) {
            \Log::error('=== importBatch Throwable Error ===', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('payments.importForm')
                ->withErrors(['token' => __('messages.payment_error_processing')]);
        }
    }

    public function show(Payment $payment)
    {
        $payment->load('driver');
        return view('pages.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $drivers = Driver::where('added_by', Auth::id())->get();
        return view('pages.payments.edit', compact('payment', 'drivers'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $this->validatePayment($request, $payment->id);
        $payment->update($validated);

        return redirect()->route('invoices.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => __('messages.payment_deleted_success'),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.payment_delete_error') . $e->getMessage(),
            ], 500);
        }
    }

    public function markPaid(Payment $payment)
    {
        try {
            $payment->update([
                'paid' => true,
                'paid_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('messages.payment_marked_paid'),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error marking payment as paid', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error marking payment as paid: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function validatePayment(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'driver_id' => ['required', 'exists:drivers,id'],
            'week_number' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'warehouse' => ['nullable', 'string', 'max:32'],
            'total_invoice' => ['required', 'numeric', 'min:0'],
            'total_parcels' => ['nullable', 'integer', 'min:0'],
            'parcel_rows_count' => ['nullable', 'integer', 'min:0'],
            'vehicule_rental_price' => ['nullable', 'numeric', 'min:0'],
            'broker_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'broker_van_cut' => ['nullable', 'numeric', 'min:0'],
            'broker_pay_cut' => ['nullable', 'numeric', 'min:0'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'cash_advance' => ['nullable', 'numeric', 'min:0'],
            'final_amount' => ['required', 'numeric', 'min:0'],
            'pdf_path' => ['nullable', 'string'],
        ]);
    }

    public function markPaidBulk(Request $request)
    {
        $paymentIds = $request->input('payment_ids', []);

        if (empty($paymentIds)) {
            return response()->json(['success' => false, 'message' => 'No payments selected.']);
        }

        \App\Models\Payment::whereIn('id', $paymentIds)->update(['paid' => true]);

        return response()->json([
            'success' => true,
            'message' => count($paymentIds) . ' payments marked as paid successfully.'
        ]);
    }

    public function checkExists(Request $request)
    {
        $driverCode = $request->input('driver_id');
        $week = $request->input('week_number');
        $warehouse = $request->input('warehouse');

        $driver = Driver::where('driver_id', $driverCode)->first();
        if (!$driver) {
            return response()->json(['exists' => false]);
        }

        $query = Payment::where('driver_id', $driver->id)
                         ->where('week_number', $week);

        if ($warehouse !== null) {
            $query->where('warehouse', $warehouse);
        }

        $exists = $query->exists();
        return response()->json(['exists' => $exists]);
    }
}
