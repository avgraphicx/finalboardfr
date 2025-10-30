<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(SubscriptionService $subscriptionService)
    {
        $user = Auth::user();
        $invoices = Invoice::where('broker_id', $user->id)->with('driver')->paginate(20);
        $drivers = $user->drivers()->where('active', true)->get();
        $features = $subscriptionService->getSubscriptionFeatures($user);
        $maxFiles = $features['max_files'] ?? 0;

        return view('pages.invoices.index', compact('invoices', 'drivers', 'maxFiles'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $drivers = Auth::user()->drivers()->where('active', true)->get();
        return view('pages.invoices.create', compact('drivers'));
    }

    /**
     * Store a newly created invoice.
     * Protected by subscription.limit:custom_invoice middleware in routes.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'week_number' => 'required|integer',
            'warehouse_name' => 'nullable|string',
            'invoice_total' => 'required|numeric|min:0',
            'days_worked' => 'required|integer|min:0',
            'total_parcels' => 'required|integer|min:0',
            'vehicle_rental_price' => 'nullable|numeric|min:0',
            'driver_percentage' => 'required|numeric|min:0|max:100',
            'bonus' => 'nullable|numeric',
            'cash_advance' => 'nullable|numeric|min:0',
            'penalty' => 'nullable|numeric|min:0',
            'pdf_path' => 'nullable|string',
        ]);

        $validated['broker_id'] = Auth::id();

        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice created successfully');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        return view('pages.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(Invoice $invoice)
    {
        $drivers = Auth::user()->drivers()->where('active', true)->get();
        return view('pages.invoices.edit', compact('invoice', 'drivers'));
    }

    /**
     * Update the specified invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_total' => 'sometimes|numeric|min:0',
            'days_worked' => 'sometimes|integer|min:0',
            'total_parcels' => 'sometimes|integer|min:0',
            'vehicle_rental_price' => 'nullable|numeric|min:0',
            'driver_percentage' => 'sometimes|numeric|min:0|max:100',
            'bonus' => 'nullable|numeric',
            'cash_advance' => 'nullable|numeric|min:0',
            'penalty' => 'nullable|numeric|min:0',
            'is_paid' => 'sometimes|boolean',
            'paid_at' => 'nullable|date',
        ]);

        $invoice->update($validated);
        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }

    /**
     * Mark invoice as paid
     */
    public function markPaid(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'is_paid' => true,
            'paid_at' => now()->toDateString(),
        ]);
        $message = __('messages.invoice_marked_paid');

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    /**
     * Mark invoice as unpaid
     */
    public function markUnpaid(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'is_paid' => false,
            'paid_at' => null,
        ]);
        $message = __('messages.invoice_marked_unpaid');

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    /**
     * Bulk mark as paid
     */
    public function markPaidBulk(Request $request)
    {
        $ids = $request->validate(['invoice_ids' => 'required|array|min:1'])['invoice_ids'];
        Invoice::whereIn('id', $ids)->update([
            'is_paid' => true,
            'paid_at' => now()->toDateString(),
        ]);
        return response()->json(['success' => true, 'message' => count($ids) . ' invoices marked as paid']);
    }
}
