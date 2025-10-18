<?php
// Test extraction methods from PaymentController

require_once __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;

$pdfPath = __DIR__ . '/storage/app/public/test_payment.pdf';

$parser = new Parser();
$pdf = $parser->parseFile($pdfPath);
$pages = $pdf->getPages();

$text = '';
foreach ($pages as $page) {
    $pageText = $page->getText();
    if ($pageText) {
        $text .= $pageText . "\n";
    }
}

echo "=== EXTRACTED TEXT ===\n";
echo $text;
echo "\n=== END TEXT ===\n\n";

// Test extractDriverId
function extractDriverId($text)
{
    if (preg_match('/Driver:\s*([A-Za-z0-9]+)\s+([A-Za-z\-]+)/i', $text, $matches)) {
        $rawDriverId = $matches[1];
        $driverId = preg_replace('/^[A-Z0-9]{0,2}([U0-9]+)$/i', '$1', $rawDriverId);
        if ($driverId === $rawDriverId && strlen($rawDriverId) > 2) {
            $driverId = substr($rawDriverId, 2);
        }
        return trim($driverId);
    }
    return null;
}

// Test extractWeekNumber
function extractWeekNumber($text)
{
    if (preg_match('/[Ww]eek\s+[Rr]eference\s*:?\s*\d+-(\d+)/i', $text, $matches)) {
        $weekNum = (int)$matches[1];
        if ($weekNum > 0 && $weekNum <= 53) {
            return $weekNum;
        }
    }
    if (preg_match('/[Ww]eek\s*:?\s*(\d{1,2})/i', $text, $matches)) {
        $weekNum = (int)$matches[1];
        if ($weekNum > 0 && $weekNum <= 53) {
            return $weekNum;
        }
    }
    return null;
}

// Test extractTotalInvoice
function extractTotalInvoice($text)
{
    if (preg_match('/[Tt]otal\s+[Ii]nvoice\s*:?\s*\$?\s*([\d,]+\.?\d*)/i', $text, $matches)) {
        return (float)str_replace(',', '', $matches[1]);
    }
    if (preg_match('/[Tt]otal\s*:?\s*\$?\s*([\d,]+\.?\d*)/i', $text, $matches)) {
        return (float)str_replace(',', '', $matches[1]);
    }
    return null;
}

echo "=== TESTING EXTRACTION METHODS ===\n";

$driverId = extractDriverId($text);
if ($driverId) {
    echo "✓ Driver ID extracted: " . $driverId . "\n";
} else {
    echo "✗ Could not extract Driver ID\n";
}

$weekNumber = extractWeekNumber($text);
if ($weekNumber !== null) {
    echo "✓ Week number extracted: " . $weekNumber . "\n";
} else {
    echo "✗ Could not extract Week Number from PDF\n";
    echo "  Checking for 'Week' in text: " . (strpos($text, 'Week') !== false ? 'FOUND' : 'NOT FOUND') . "\n";
}

$totalInvoice = extractTotalInvoice($text);
if ($totalInvoice !== null) {
    echo "✓ Total Invoice extracted: " . $totalInvoice . "\n";
} else {
    echo "✗ Could not extract Total Invoice\n";
}

echo "\n";
if ($driverId && $weekNumber !== null && $totalInvoice !== null) {
    echo "✓ All extractions successful!\n";
} else {
    echo "✗ Some extractions failed\n";
}
?>
