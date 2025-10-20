<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;

class PdfPaymentParser
{
    /**
     * Parse Intelcom driver payment PDF and extract data.
     */
    public function parse($file): array
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $this->normalize($pdf->getText());

            if (empty($text)) {
                return $this->fail('Could not extract text from PDF.');
            }

            // --- Extraction ---
            $driverId = $this->extractDriverId($text);
            $weekNumber = $this->extractWeekNumber($text);
            $totalInvoice = $this->extractTotalInvoice($text);
            $totalParcels = $this->extractTotalParcels($text);
            $parcelRowsCount = $this->extractParcelRowsCount($text);

            if (!$driverId) return $this->fail('Could not extract Driver ID.');
            if (!$weekNumber) return $this->fail('Could not extract Week Number.');
            if ($totalInvoice === 0.0) return $this->fail('Could not extract Total Invoice.');

            // --- Optional debug logging ---
            if (config('app.env') !== 'production') {
                Log::debug('Parsed PDF Summary', [
                    'driver_id' => $driverId,
                    'week_number' => $weekNumber,
                    'total_invoice' => $totalInvoice,
                    'total_parcels' => $totalParcels,
                    'parcel_rows_count' => $parcelRowsCount,
                ]);
            }

            return [
                'success' => true,
                'driver_id' => $driverId,
                'week_number' => $weekNumber,
                'total_invoice' => $totalInvoice,
                'total_parcels' => $totalParcels,
                'parcel_rows_count' => $parcelRowsCount,
            ];

        } catch (\Exception $e) {
            Log::error('PDF parsing error', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);
            return $this->fail('Error parsing PDF: ' . $e->getMessage());
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
     * Extract Week Number (WW from YYYY-WW). Prioritize the "Week reference" label.
     *
     * Strategy:
     * 1. Look for explicit "Week reference" (or "Week ref") label and capture YYYY-WW.
     * 2. Fallback: collect all YYYY-WW patterns and pick best candidate:
     *    - prefer week-part in 1..53 and >12 (less likely a month)
     *    - otherwise prefer the match appearing near the top (first/last heuristics)
     */
    private function extractWeekNumber(string $text): ?int
    {
        // 1) Try to find explicit "Week reference:" (common label in the invoices)
        if (preg_match('/Week\s*(?:reference|ref)?\s*[:\-]?\s*(\d{4})-(\d{2})/i', $text, $m)) {
            $week = (int)$m[2];
            if ($week >= 1 && $week <= 53) {
                return $week;
            }
        }

        // 2) Another possible label form: "Week reference" followed by newline and the value
        if (preg_match('/Week\s*(?:reference|ref)?\s*[\:\-]?\s*\n?\s*(\d{4})-(\d{2})/i', $text, $m2)) {
            $week = (int)$m2[2];
            if ($week >= 1 && $week <= 53) {
                return $week;
            }
        }

        // 3) Fallback: find all YYYY-WW occurrences and choose the most likely week
        preg_match_all('/\b(\d{4})-(\d{2})\b/', $text, $allMatches, PREG_SET_ORDER);

        if (empty($allMatches)) {
            return null;
        }

        // If there's only one match, return it (if valid)
        if (count($allMatches) === 1) {
            $week = (int)$allMatches[0][2];
            return ($week >= 1 && $week <= 53) ? $week : null;
        }

        // Prefer any match where the week part is > 12 (unlikely to be a month)
        foreach ($allMatches as $match) {
            $candidateWeek = (int)$match[2];
            if ($candidateWeek >= 1 && $candidateWeek <= 53 && $candidateWeek > 12) {
                return $candidateWeek;
            }
        }

        // If none > 12, prefer a match that appears before the "From:" date
        $fromPos = stripos($text, 'From:');
        if ($fromPos !== false) {
            foreach ($allMatches as $match) {
                $matchPos = stripos($text, $match[0]);
                if ($matchPos !== false && $matchPos < $fromPos) {
                    $candidateWeek = (int)$match[2];
                    if ($candidateWeek >= 1 && $candidateWeek <= 53) {
                        return $candidateWeek;
                    }
                }
            }
        }

        // As a last resort, take the last match that is a valid week
        for ($i = count($allMatches) - 1; $i >= 0; $i--) {
            $candidateWeek = (int)$allMatches[$i][2];
            if ($candidateWeek >= 1 && $candidateWeek <= 53) {
                return $candidateWeek;
            }
        }

        return null;
    }

    /**
     * Extract total invoice amount (Total invoice or Total Invoice)
     */
    private function extractTotalInvoice(string $text): float
    {
        if (preg_match('/Total\s+invoice\s*\$?\s*([\d,]+\.?\d*)/i', $text, $m)) {
            return (float) str_replace(',', '', $m[1]);
        }

        // fallback to other variants
        if (preg_match('/Total\s+Invoice\s*\$?\s*([\d,]+\.?\d*)/i', $text, $m2)) {
            return (float) str_replace(',', '', $m2[1]);
        }

        return 0.0;
    }

    /**
     * Extract total parcels value from the "Total" row in transaction summary.
     */
    private function extractTotalParcels(string $text): int
    {
        if (preg_match('/Total\s+\d+\s+(\d+)/i', $text, $m)) {
            return (int)$m[1];
        }

        // fallback: try to find line "Total" followed by number in same block
        if (preg_match('/Transaction\s+summary(.*?)(?:Fuel\s+Surcharge|Manual\s+Fees|Total\s+Cancellation|Total\s+invoice)/is', $text, $mblock)) {
            $block = $mblock[1];
            if (preg_match('/Total\s+[^\n]*?(\d{2,})/i', $block, $m2)) {
                return (int)$m2[1];
            }
        }

        return 0;
    }

    /**
     * Extract how many transaction summary rows have parcels > 0.
     */
    private function extractParcelRowsCount(string $text): int
    {
        // Capture everything between "Transaction summary" and "Fuel Surcharge" or similar section headers.
        if (!preg_match(
            '/Transaction\s+summary(.*?)(?:Fuel\s+Surcharge|Manual\s+Fees|Total\s+Cancellation|Total\s+invoice)/is',
            $text,
            $m
        )) {
            return 0;
        }

        $summary = trim($m[1]);
        $lines = preg_split('/\n+/', $summary);
        $count = 0;

        foreach ($lines as $line) {
            $line = trim(preg_replace('/\s+/', ' ', $line));

            // Match "YYYY-MM-DD stopQty parcelQty ..."
            if (preg_match('/^(\d{4}-\d{2}-\d{2})\s+\d+\s+(\d+)/', $line, $matches)) {
                $parcelQty = (int)$matches[2];
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

    private function fail(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
