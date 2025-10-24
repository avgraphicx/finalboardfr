<?php

namespace App\Services;

use App\DataTransferObjects\PaymentExtraction;
use App\Exceptions\PaymentImportException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class PdfPaymentParser
{
    /**
     * Parse Intelcom driver payment PDF and extract data.
     *
     * @throws PaymentImportException
     */
    public function parse(UploadedFile $file): PaymentExtraction
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $this->normalize($pdf->getText());

            if (empty($text)) {
                throw new PaymentImportException('Could not extract text from PDF.');
            }

            $driverId = $this->extractDriverId($text);
            if (!$driverId) {
                throw new PaymentImportException('Could not extract Driver ID.');
            }

            $weekDetails = $this->extractWeekDetails($text);
            if (!$weekDetails) {
                throw new PaymentImportException('Could not extract Week Number.');
            }

            $totalInvoice = $this->extractTotalInvoice($text);
            if ($totalInvoice === null) {
                throw new PaymentImportException('Could not extract Total Invoice.');
            }

            $totalParcels = $this->extractTotalParcels($text);
            $parcelRowsCount = $this->extractParcelRowsCount($text);

            // Warehouse from filename (preferred) or text
            $warehouse = $this->extractWarehouseFromFilename($file) ?? $this->extractWarehouseFromText($text);

            if (config('app.env') !== 'production') {
                Log::debug('Parsed PDF Summary', [
                    'driver_id' => $driverId,
                    'week_number' => $weekDetails['week'],
                    'year' => $weekDetails['year'],
                    'total_invoice' => $totalInvoice,
                    'total_parcels' => $totalParcels,
                    'parcel_rows_count' => $parcelRowsCount,
                    'warehouse' => $warehouse,
                ]);
            }

            return new PaymentExtraction(
                driverId: $driverId,
                weekNumber: $weekDetails['week'],
                year: $weekDetails['year'],
                totalInvoice: $totalInvoice,
                totalParcels: $totalParcels,
                parcelRowsCount: $parcelRowsCount,
                warehouse: $warehouse
            );
        } catch (PaymentImportException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('PDF parsing error', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            throw new PaymentImportException('Error parsing PDF.', 500);
        }
    }

    /**
     * Normalize whitespace and newlines.
     */
    private function normalize(string $text): string
    {
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\r\n|\r|\n/', "\n", $text);
        return trim($text);
    }

    /**
     * Extract driver id like C0U9622 -> returns U9622
     */
    private function extractDriverId(string $text): ?string
    {
        return preg_match('/C0([A-Z]\d{4})/i', $text, $m) ? $m[1] : null;
    }

    /**
     * Extract week number and optional year information.
     *
     * @return array{week:int, year:?int}|null
     */
    private function extractWeekDetails(string $text): ?array
    {
        $patterns = [
            '/Week\s*(?:reference|ref)?\s*[:\-]?\s*(\d{4})-(\d{2})/i',
            '/Week\s*(?:reference|ref)?\s*[\:\-]?\s*\n?\s*(\d{4})-(\d{2})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $week = (int) $match[2];
                if ($week >= 1 && $week <= 53) {
                    return [
                        'year' => (int) $match[1],
                        'week' => $week,
                    ];
                }
            }
        }

        preg_match_all('/\b(\d{4})-(\d{2})\b/', $text, $allMatches, PREG_SET_ORDER);
        if (empty($allMatches)) {
            return null;
        }

        $candidates = array_values(array_filter($allMatches, function ($match) {
            $week = (int) $match[2];
            return $week >= 1 && $week <= 53;
        }));

        if (empty($candidates)) {
            return null;
        }

        foreach ($candidates as $match) {
            if ((int) $match[2] > 12) {
                return [
                    'year' => (int) $match[1],
                    'week' => (int) $match[2],
                ];
            }
        }

        $fromPos = stripos($text, 'From:');
        if ($fromPos !== false) {
            foreach ($candidates as $match) {
                $matchPos = stripos($text, $match[0]);
                if ($matchPos !== false && $matchPos < $fromPos) {
                    return [
                        'year' => (int) $match[1],
                        'week' => (int) $match[2],
                    ];
                }
            }
        }

        $last = end($candidates);

        return [
            'year' => (int) $last[1],
            'week' => (int) $last[2],
        ];
    }

    /**
     * Extract total invoice amount (Total invoice or Total Invoice)
     */
    private function extractTotalInvoice(string $text): ?float
    {
        $patterns = [
            '/Total\s+invoice\s*\$?\s*([\d,]+\.?\d*)/i',
            '/Total\s+Invoice\s*\$?\s*([\d,]+\.?\d*)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                return (float) str_replace(',', '', $match[1]);
            }
        }

        return null;
    }

    /**
     * Extract total parcels value from the "Total" row in transaction summary.
     */
    private function extractTotalParcels(string $text): int
    {
        if (preg_match('/Total\s+\d+\s+(\d+)/i', $text, $match)) {
            return (int) $match[1];
        }

        if (preg_match(
            '/Transaction\s+summary(.*?)(?:Fuel\s+Surcharge|Manual\s+Fees|Total\s+Cancellation|Total\s+invoice)/is',
            $text,
            $blockMatch
        )) {
            $block = $blockMatch[1];
            if (preg_match('/Total\s+[^\n]*?(\d{2,})/i', $block, $match)) {
                return (int) $match[1];
            }
        }

        return 0;
    }

    /**
     * Extract how many transaction summary rows have parcels > 0.
     */
    private function extractParcelRowsCount(string $text): int
    {
        if (!preg_match(
            '/Transaction\s+summary(.*?)(?:Fuel\s+Surcharge|Manual\s+Fees|Total\s+Cancellation|Total\s+invoice)/is',
            $text,
            $match
        )) {
            return 0;
        }

        $summary = trim($match[1]);
        $lines = preg_split('/\n+/', $summary);
        $count = 0;

        foreach ($lines as $line) {
            $line = trim(preg_replace('/\s+/', ' ', $line));

            if (preg_match('/^(\d{4}-\d{2}-\d{2})\s+\d+\s+(\d+)/', $line, $matches)) {
                $parcelQty = (int) $matches[2];
                if ($parcelQty > 20) {
                    $count++;
                }
            }
        }

        if (config('app.env') !== 'production') {
            Log::debug('ParcelRowsCount Debug', [
                'matched_lines' => $count,
                'summary_excerpt' => substr($summary, 0, 300),
            ]);
        }

        return $count;
    }

    /**
     * Extract warehouse from file name (last dash/underscore token).
     * Example: 2025-39-C0V4000-Z0X1231-RIDP.pdf -> RIDP
     */
    private function extractWarehouseFromFilename(UploadedFile $file): ?string
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $parts = preg_split('/[-_]/', strtoupper($name));
        $last = $parts ? trim(end($parts)) : null;

        if ($last && preg_match('/^[A-Z0-9]{3,6}$/', $last)) {
            return $last;
        }

        return null;
    }

    /**
     * Fallback: try to find warehouse in PDF text, like "Warehouse: RIDP"
     */
    private function extractWarehouseFromText(string $text): ?string
    {
        if (preg_match('/Warehouse\s*[:\-]?\s*([A-Z0-9]{3,6})/i', $text, $m)) {
            return strtoupper($m[1]);
        }

        return null;
    }
}
