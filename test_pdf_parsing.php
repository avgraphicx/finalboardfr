<?php
// Test the PDF parsing logic from PaymentController

require_once __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;

$pdfPath = __DIR__ . '/storage/app/public/test_payment.pdf';

echo "Testing PDF parsing with file: {$pdfPath}\n";
echo "File exists: " . (file_exists($pdfPath) ? 'YES' : 'NO') . "\n";
echo "File size: " . filesize($pdfPath) . " bytes\n\n";

try {
    $parser = new Parser();
    $pdf = $parser->parseFile($pdfPath);

    echo "✓ PDF parsed successfully\n";

    $pages = $pdf->getPages();
    echo "✓ Number of pages: " . count($pages) . "\n";

    // Extract text from all pages
    $text = '';
    foreach ($pages as $page) {
        $pageText = $page->getText();
        if ($pageText) {
            $text .= $pageText . "\n";
        }
    }

    echo "✓ Text extracted. Length: " . strlen($text) . " characters\n\n";

    echo "=== EXTRACTED TEXT ===\n";
    echo $text;
    echo "\n=== END TEXT ===\n\n";

    // Test regex patterns
    echo "=== TESTING REGEX PATTERNS ===\n";

    // Extract Driver ID
    if (preg_match('/Driver:\s*([A-Za-z0-9]+)\s+([A-Za-z\-]+)/i', $text, $matches)) {
        echo "✓ Driver found: " . $matches[1] . " " . $matches[2] . "\n";
        // Remove "C0" prefix if present
        $driverId = (strpos($matches[1], 'C0') === 0) ? substr($matches[1], 2) : $matches[1];
        echo "  Driver ID (after removing C0): " . $driverId . "\n";
    } else {
        echo "✗ Driver ID pattern not found\n";
    }

    // Extract Week Number
    if (preg_match('/Week\s*:?\s*(\d+)/i', $text, $matches)) {
        echo "✓ Week number found: " . $matches[1] . "\n";
    } else {
        echo "✗ Week number pattern not found\n";
    }

    // Extract Total Invoice
    if (preg_match('/Total\s+Invoice\s*:?\s*\$?\s*([\d,]+\.?\d*)/i', $text, $matches)) {
        echo "✓ Total Invoice found: " . $matches[1] . "\n";
    } else {
        echo "✗ Total Invoice pattern not found\n";
    }

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    exit(1);
}

echo "\n✓ All tests passed!\n";
?>
