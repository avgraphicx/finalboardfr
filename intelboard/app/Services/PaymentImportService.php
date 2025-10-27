<?php

namespace App\Services;

use App\DataTransferObjects\PaymentExtraction;
use App\Exceptions\PaymentImportException;
use App\Models\Driver;
use App\Models\Invoice;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentImportService
{
    public function __construct(private readonly PdfPaymentParser $parser)
    {
    }

    /**
     * Parse a PDF and return the extraction data (driver ID, etc.)
     */
    public function parsePdf(UploadedFile $pdf): PaymentExtraction
    {
        return $this->parser->parse($pdf);
    }

    /**
     * Parse and prepare a payment summary without persisting it.
     *
     * @throws PaymentImportException
     */
    public function preview(UploadedFile $pdf): array
    {
        $extraction = $this->parser->parse($pdf);
        $driver = $this->findDriver($extraction->driverId);

        if (!$driver) {
            throw new PaymentImportException(
                __('messages.driver_not_found', ['driver_id' => $extraction->driverId]),
                404,
                $this->missingDriverContext($extraction)
            );
        }

        return $this->composeSnapshot($driver, $extraction);
    }

    /**
     * Persist a payment generated from the provided PDF.
     *
     * @throws PaymentImportException
     */
    public function persist(UploadedFile $pdf): array
    {
        $extraction = $this->parser->parse($pdf);
        $driver = $this->findDriver($extraction->driverId);

        if (!$driver) {
            throw new PaymentImportException(
                __('messages.driver_not_found', ['driver_id' => $extraction->driverId]),
                404,
                $this->missingDriverContext($extraction)
            );
        }

        $weekIdentifier = $extraction->weekIdentifier();
        $this->guardAgainstDuplicate($driver->id, $extraction);

        $snapshot = $this->composeSnapshot($driver, $extraction);
        $storedPdfPath = $pdf->store('payments', 'public');

        // Extract week number from "YYYY-WW" format
        $weekParts = explode('-', $weekIdentifier);
        $weekNum = isset($weekParts[1]) ? (int)$weekParts[1] : (int)$weekIdentifier;

        Invoice::create([
            'driver_id' => $driver->id,
            'week_number' => $weekNum,
            'warehouse_name' => $snapshot['warehouse'],
            'invoice_total' => $snapshot['total_invoice'],
            'total_parcels' => $snapshot['total_parcels'],
            'days_worked' => $snapshot['parcel_rows_count'],
            'vehicle_rental_price' => $snapshot['vehicule_rental_price'],
            'driver_percentage' => $snapshot['broker_percentage'],
            'bonus' => 0,
            'cash_advance' => 0,
            'penalty' => 0,
            'amount_to_pay_driver' => $snapshot['final_amount'],
            'pdf_path' => $storedPdfPath,
        ]);

        return $snapshot;
    }

    /**
     * Preview a batch of PDFs and cache results in session with a token.
     *
     * @param UploadedFile[] $files
     * @return array{token:string,items:array<int,array<string,mixed>>}
     */
    public function previewBatch(array $files): array
    {
        $token = (string)Str::uuid();
        $seenKeys = [];
        $sessionItems = [];
        $responseItems = [];

        $tempBase = 'temp/payment-previews/' . $token;
        Storage::disk('local')->makeDirectory($tempBase);

        foreach ($files as $file) {
            $original = $file->getClientOriginalName();

            try {
                $extraction = $this->parser->parse($file);
                $driver = $this->findDriver($extraction->driverId);

                if (!$driver) {
                    $responseItems[] = [
                        'key' => null,
                        'file_name' => $original,
                        'status' => 'missing_driver',
                        'status_reason' => __('messages.driver_not_found', ['driver_id' => $extraction->driverId]),
                        'driver_id' => $extraction->driverId,
                        'driver_full_name' => null,
                        'week_number' => $extraction->weekIdentifier(),
                        'warehouse' => $extraction->warehouse,
                    ];
                    continue;
                }

                $snapshot = $this->composeSnapshot($driver, $extraction);
                $warehouse = $snapshot['warehouse'] ?? 'NA';
                $key = $snapshot['driver_id'] . '_' . $snapshot['week_number'] . '_' . $warehouse;

                // Save temp file once per input
                $tempName = $this->safeTempName($original);
                $tempPath = $file->storeAs($tempBase, $tempName, 'local');

                $status = 'ok';
                $statusReason = null;

                if (isset($seenKeys[$key])) {
                    $status = 'duplicate_in_batch';
                    $statusReason = __('messages.pay_exists_for_driver');
                } else {
                    $seenKeys[$key] = true;

                    // Check DB duplicate WITH warehouse
                    // Extract week number from "YYYY-WW" format for comparison
                    $weekParts = explode('-', $extraction->weekIdentifier());
                    $weekNum = isset($weekParts[1]) ? (int)$weekParts[1] : (int)$extraction->weekIdentifier();

                    $exists = Invoice::where('driver_id', $driver->id)
                        ->where('week_number', $weekNum)
                        ->where('warehouse_name', $snapshot['warehouse'])
                        ->exists();
                    if ($exists) {
                        $status = 'duplicate_in_db';
                        $statusReason = __('messages.pay_exists_for_driver');
                    }
                }

                $canImport = $status === 'ok';

                $sessionItems[$key] = [
                    'snapshot' => $snapshot,
                    'db_driver_id' => $driver->id,
                    'temp_path' => $tempPath, // relative to local disk
                    'file_original_name' => $original,
                    'can_import' => $canImport,
                ];

                $responseItems[] = array_merge($snapshot, [
                    'key' => $key,
                    'file_name' => $original,
                    'status' => $status,
                    'status_reason' => $statusReason,
                ]);
            } catch (PaymentImportException $e) {
                $responseItems[] = [
                    'key' => null,
                    'file_name' => $original,
                    'status' => 'parse_error',
                    'status_reason' => $e->getMessage(),
                ];
            } catch (\Throwable $e) {
                \Log::error('PDF parsing error in previewBatch', [
                    'file' => $original,
                    'error' => $e->getMessage(),
                    'file_class' => get_class($e),
                    'trace' => $e->getTraceAsString(),
                ]);

                $responseItems[] = [
                    'key' => null,
                    'file_name' => $original,
                    'status' => 'parse_error',
                    'status_reason' => 'Error: ' . $e->getMessage(),
                ];
            }
        }

        // Save to session
        Session::put("payment_previews.$token", [
            'created_at' => now()->toDateTimeString(),
            'items' => $sessionItems,
        ]);

        return [
            'token' => $token,
            'items' => $responseItems,
        ];
    }

    /**
     * Import selected items from a cached preview token.
     *
     * @param string $token
     * @param string[] $selectedKeys
     * @param int $brokerId The ID of the broker (user) performing the import
     * @return array{saved:int,failed:int}
     * @throws PaymentImportException
     */
    public function importBatch(string $token, array $selectedKeys, int $brokerId = null): array
    {
        $cache = Session::get("payment_previews.$token");
        if (!$cache || !isset($cache['items']) || !is_array($cache['items'])) {
            throw new PaymentImportException(__('messages.payment_error_processing'));
        }

        $saved = 0;
        $failed = 0;

        \Log::info('=== importBatch SERVICE START ===', [
            'token' => $token,
            'selected_keys' => $selectedKeys,
            'selected_count' => count($selectedKeys),
        ]);

        foreach ($selectedKeys as $key) {
            \Log::info("=== Processing key: $key ===");

            $entry = $cache['items'][$key] ?? null;

            \Log::info("Entry status", [
                'key' => $key,
                'entry_exists' => $entry !== null,
                'entry_keys' => $entry ? array_keys($entry) : null,
                'can_import' => $entry['can_import'] ?? null,
            ]);

            if (!$entry || empty($entry['can_import'])) {
                \Log::warning("Skipping key $key - entry missing or cannot import", [
                    'entry' => $entry,
                ]);
                $failed++;
                continue;
            }

            $snapshot = $entry['snapshot'];
            $dbDriverId = $entry['db_driver_id'];
            $tempPath = $entry['temp_path'];
            $original = $entry['file_original_name'];

            try {
                // Move file to public disk
                $desiredName = $this->permanentName($key, $original);
                $localFullPath = Storage::disk('local')->path($tempPath);
                $publicPath = 'payments/' . $desiredName;

                // Ensure directory exists
                Storage::disk('public')->makeDirectory('payments');

                $stream = fopen($localFullPath, 'r');
                Storage::disk('public')->put($publicPath, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                // Create invoice
                // Extract week number from "YYYY-WW" format
                $weekParts = explode('-', $snapshot['week_number']);
                $weekNum = isset($weekParts[1]) ? (int)$weekParts[1] : (int)$snapshot['week_number'];

                \Log::info("Creating invoice for key $key", [
                    'driver_id' => $dbDriverId,
                    'week_number_raw' => $snapshot['week_number'],
                    'week_number_extracted' => $weekNum,
                    'warehouse' => $snapshot['warehouse'],
                    'invoice_total' => $snapshot['total_invoice'],
                ]);

                Invoice::create([
                    'broker_id' => $brokerId,
                    'driver_id' => $dbDriverId,
                    'week_number' => $weekNum,
                    'warehouse_name' => $snapshot['warehouse'],
                    'invoice_total' => $snapshot['total_invoice'],
                    'total_parcels' => $snapshot['total_parcels'],
                    'days_worked' => $snapshot['parcel_rows_count'],
                    'vehicle_rental_price' => $snapshot['vehicule_rental_price'],
                    'driver_percentage' => $snapshot['broker_percentage'],
                    'bonus' => 0,
                    'cash_advance' => 0,
                    'penalty' => 0,
                    'amount_to_pay_driver' => $snapshot['final_amount'],
                    'pdf_path' => $publicPath,
                ]);

                \Log::info("Invoice created successfully for key $key");
                $saved++;
            } catch (\Throwable $e) {
                \Log::error('Failed to import payment from batch', [
                    'key' => $key,
                    'error' => $e->getMessage(),
                    'error_class' => get_class($e),
                    'trace' => $e->getTraceAsString(),
                ]);
                $failed++;
            }
        }

        // Cleanup temp files and session cache
        Storage::disk('local')->deleteDirectory('temp/payment-previews/' . $token);
        Session::forget("payment_previews.$token");

        \Log::info('=== importBatch COMPLETE ===', [
            'saved' => $saved,
            'failed' => $failed,
        ]);

        return ['saved' => $saved, 'failed' => $failed];
    }

    private function composeSnapshot(Driver $driver, PaymentExtraction $extraction): array
    {
        $defaultRentalPrice = (float)($driver->default_rental_price ?? 0);
        $defaultPercentage = (float)($driver->default_percentage ?? 0);

        $brokerVanCut = (float)($extraction->parcelRowsCount * $defaultRentalPrice);
        $brokerPayCut = (float)($extraction->totalInvoice * ($defaultPercentage / 100));
        $finalAmount = (float)($extraction->totalInvoice - $brokerVanCut - $brokerPayCut);

        return array_merge(
            $extraction->toArray(),
            [
                'driver_full_name' => $driver->full_name,
                'vehicule_rental_price' => $defaultRentalPrice,
                'broker_percentage' => $defaultPercentage,
                'broker_van_cut' => $brokerVanCut,
                'broker_pay_cut' => $brokerPayCut,
                'final_amount' => $finalAmount,
            ]
        );
    }

    private function guardAgainstDuplicate(int $driverId, PaymentExtraction $extraction): void
    {
        // Extract week number from "YYYY-WW" format
        $weekParts = explode('-', $extraction->weekIdentifier());
        $weekNum = isset($weekParts[1]) ? (int)$weekParts[1] : (int)$extraction->weekIdentifier();

        $exists = Invoice::where('driver_id', $driverId)
            ->where('week_number', $weekNum)
            ->where('warehouse_name', $extraction->warehouse)
            ->exists();

        if ($exists) {
            throw new PaymentImportException(
                __('messages.pay_exists_for_driver'),
                409,
                $this->missingDriverContext($extraction)
            );
        }
    }

    private function findDriver(string $driverId): ?Driver
    {
        return Driver::where('driver_id', $driverId)->first();
    }

    private function missingDriverContext(PaymentExtraction $extraction): array
    {
        return [
            'driver_id' => $extraction->driverId,
            'week_number' => $extraction->weekIdentifier(),
            'warehouse' => $extraction->warehouse,
        ];
    }

    private function safeTempName(string $original): string
    {
        $ext = pathinfo($original, PATHINFO_EXTENSION) ?: 'pdf';
        $base = pathinfo($original, PATHINFO_FILENAME);
        $base = \Illuminate\Support\Str::slug($base);
        return $base . '-' . \Illuminate\Support\Str::random(8) . '.' . strtolower($ext);
    }

    private function permanentName(string $key, string $original): string
    {
        $ext = pathinfo($original, PATHINFO_EXTENSION) ?: 'pdf';
        return $key . '-' . \Illuminate\Support\Str::random(6) . '.' . strtolower($ext);
    }
}
