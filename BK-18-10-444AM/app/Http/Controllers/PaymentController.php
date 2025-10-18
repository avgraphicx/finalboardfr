<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Smalot\PdfParser\Parser;

class PaymentController extends Controller
{
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
            // Parse PDF file
            $pdfData = $this->parsePdfFile($request->file('pdf_path'));

            if (!$pdfData['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $pdfData['message']
                ], 422);
            }

            // Extract driver_id from the parsed data
            $driverId = $pdfData['driver_id'];
            $weekNumber = $pdfData['week_number'];
            $totalInvoice = $pdfData['total_invoice'];

            // Find driver by driver_id
            $driver = Driver::where('driver_id', $driverId)->first();

            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => "Driver with ID '{$driverId}' not found in database."
                ], 404);
            }

            // Create payment record
            $payment = Payment::create([
                'driver_id' => $driver->id,
                'week_number' => $weekNumber,
                'total_invoice' => $totalInvoice,
                'parcel_rows_count' => $pdfData['parcel_rows_count'] ?? 0,
                'vehicule_rental_price' => $pdfData['vehicule_rental_price'] ?? null,
                'broker_percentage' => $pdfData['broker_percentage'] ?? null,
                'bonus' => $pdfData['bonus'] ?? 0,
                'cash_advance' => $pdfData['cash_advance'] ?? 0,
                'final_amount' => $totalInvoice,
                'pdf_path' => $this->storePdfFile($request->file('pdf_path')),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment created successfully from PDF!',
                'data' => $pdfData
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error processing payment PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Parse PDF file and extract required data
     */
    private function parsePdfFile($file)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());

            // Get all pages
            $pages = $pdf->getPages();
            if (empty($pages)) {
                return [
                    'success' => false,
                    'message' => 'PDF file has no pages'
                ];
            }

            // Extract text from all pages (join them together)
            $text = '';
            foreach ($pages as $page) {
                $pageText = $page->getText();
                if ($pageText) {
                    $text .= $pageText . "\n";
                }
            }

            if (empty($text)) {
                return [
                    'success' => false,
                    'message' => 'Could not extract text from PDF'
                ];
            }

            // Extract Driver ID
            $driverId = $this->extractDriverId($text);
            if (!$driverId) {
                return [
                    'success' => false,
                    'message' => 'Could not extract Driver ID from PDF. Expected format: "Driver: C0LDDDD"'
                ];
            }

            // Extract Week Number
            $weekNumber = $this->extractWeekNumber($text);
            if (!$weekNumber) {
                return [
                    'success' => false,
                    'message' => 'Could not extract Week Number from PDF'
                ];
            }

            // Extract Total Invoice
            $totalInvoice = $this->extractTotalInvoice($text);
            if ($totalInvoice === false) {
                return [
                    'success' => false,
                    'message' => 'Could not extract Total Invoice from PDF'
                ];
            }

            return [
                'success' => true,
                'driver_id' => $driverId,
                'week_number' => $weekNumber,
                'total_invoice' => $totalInvoice,
            ];

        } catch (\Exception $e) {
            \Log::error('PDF parsing error', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'message' => 'Error parsing PDF: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Extract Driver ID from PDF text
     * Pattern: C0 followed by a letter and 4 digits (e.g., C0U9622 -> U9622)
     */
    private function extractDriverId($text)
    {
        if (preg_match('/C0([A-Z]\d{4})/i', $text, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Extract Week Number from PDF text
     * Format: YYYY-WW -> extracts WW
     */
    private function extractWeekNumber($text)
    {
        // First, find the Driver ID line
        if (preg_match('/C0([A-Z]\d{4})/i', $text, $driverMatches)) {
            // Get the position of the driver ID match
            $driverPos = strpos($text, $driverMatches[0]);

            // Look for week number after the driver ID position
            $afterDriver = substr($text, $driverPos);

            // Find YYYY-WW pattern after driver ID
            if (preg_match('/(\d{4})-(\d{2})/i', $afterDriver, $matches)) {
                $weekNum = (int)$matches[2];
                if ($weekNum > 0 && $weekNum <= 53) {
                    return $weekNum;
                }
            }
        }

        return null;
    }

    /**
     * Extract Total Invoice from PDF text
     */
    private function extractTotalInvoice($text)
    {
        if (preg_match('/[Tt]otal\s+[Ii]nvoice\s*\$?\s*([\d,]+\.?\d*)/i', $text, $matches)) {
            return (float)str_replace(',', '', $matches[1]);
        }

        return false;
    }

    /**
     * Store PDF file in storage
     */
    private function storePdfFile($file)
    {
        $path = $file->store('payments', 'public');
        return $path;
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('driver');
        return view('pages.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $drivers = Driver::where('added_by', Auth::id())->get();
        return view('pages.payments.edit', compact('payment', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $this->validatePayment($request, $payment->id);
        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate payment data
     */
    private function validatePayment(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'driver_id' => ['required', 'exists:drivers,id'],
            'week_number' => ['required', 'integer', 'min:1', 'max:53'],
            'total_invoice' => ['required', 'numeric', 'min:0'],
            'parcel_rows_count' => ['nullable', 'integer', 'min:0'],
            'vehicule_rental_price' => ['nullable', 'numeric', 'min:0'],
            'broker_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'cash_advance' => ['nullable', 'numeric', 'min:0'],
            'final_amount' => ['required', 'numeric', 'min:0'],
            'pdf_path' => ['nullable', 'string'],
        ]);
    }
}
