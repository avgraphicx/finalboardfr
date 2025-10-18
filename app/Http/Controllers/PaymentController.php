<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfPaymentParser;

class PaymentController extends Controller
{
    protected PdfPaymentParser $parser;

    public function __construct(PdfPaymentParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('driver')->paginate(15);
        return view('pages.payments', compact('payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pdf_path' => ['required', 'file', 'mimes:pdf'],
        ]);

        try {
            // Parse PDF via service
            $pdfData = $this->parser->parse($request->file('pdf_path'));

            if (!$pdfData['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $pdfData['message'],
                ], 422);
            }

            // Extract parsed values
            $driverId = $pdfData['driver_id'];
            $weekNumber = (int)$pdfData['week_number'];
            $totalInvoice = (float)$pdfData['total_invoice'];
            $totalParcels = (int)$pdfData['total_parcels'];
            $parcelRowsCount = (int)$pdfData['parcel_rows_count'];

            // Find driver by driver_id
            $driver = Driver::where('driver_id', $driverId)->first();

            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => "Driver with ID '{$driverId}' not found in database.",
                ], 404);
            }

            // Default driver settings
            $defaultRentalPrice = (float)($driver->default_rental_price ?? 0);
            $defaultPercentage = (float)($driver->default_percentage ?? 0);

            // Calculations
            $brokerVanCut = (float)($parcelRowsCount * $defaultRentalPrice);
            $brokerPayCut = (float)($totalInvoice * ($defaultPercentage / 100));
            $finalAmount = (float)($totalInvoice - $brokerVanCut - $brokerPayCut);

            // Store PDF file
            $storedPdfPath = $request->file('pdf_path')->store('payments', 'public');

            // Create payment record
            $payment = Payment::create([
                'driver_id' => $driver->id,
                'week_number' => $weekNumber,
                'total_invoice' => $totalInvoice,
                'total_parcels' => $totalParcels,
                'parcel_rows_count' => $parcelRowsCount,
                'vehicule_rental_price' => $defaultRentalPrice,
                'broker_percentage' => $defaultPercentage,
                'broker_van_cut' => $brokerVanCut,
                'broker_pay_cut' => $brokerPayCut,
                'bonus' => 0,
                'cash_advance' => 0,
                'final_amount' => $finalAmount,
                'pdf_path' => $storedPdfPath,
            ]);

            // Prepare display data
            $displayData = [
                'driver_id' => $driverId,
                'week_number' => $weekNumber,
                'total_invoice' => $totalInvoice,
                'total_parcels' => $totalParcels,
                'parcel_rows_count' => $parcelRowsCount,
                'vehicule_rental_price' => $defaultRentalPrice,
                'broker_percentage' => $defaultPercentage,
                'broker_van_cut' => $brokerVanCut,
                'broker_pay_cut' => $brokerPayCut,
                'final_amount' => $finalAmount,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Payment data extracted and saved successfully!',
                'data' => $displayData,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_merge(...array_values($e->errors()))),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error processing payment PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing PDF: ' . $e->getMessage(),
            ], 500);
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

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function validatePayment(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'driver_id' => ['required', 'exists:drivers,id'],
            'week_number' => ['required', 'integer', 'min:1', 'max:53'],
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
}
