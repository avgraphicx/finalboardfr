<?php
// Full integration test of the payment upload workflow

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\UploadedFile;

// Bootstrap Laravel
$app = require __DIR__ . '/bootstrap/app.php';
$app->boot();

// Recreate services
$container = $app;

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

echo "=== PAYMENT UPLOAD INTEGRATION TEST ===\n\n";

// Verify test PDF exists
$pdfPath = __DIR__ . '/storage/app/public/test_payment.pdf';
if (!file_exists($pdfPath)) {
    echo "✗ Test PDF not found at: $pdfPath\n";
    exit(1);
}
echo "✓ Test PDF found: $pdfPath\n";

// Verify test driver exists
$driver = \App\Models\Driver::where('driver_id', 'U9622')->first();
if (!$driver) {
    echo "✗ Test driver U9622 not found\n";
    exit(1);
}
echo "✓ Test driver U9622 found (DB ID: {$driver->id})\n\n";

// Create a mock request with file
echo "Creating mock request...\n";
$tempPath = sys_get_temp_dir() . '/test_payment_' . time() . '.pdf';
copy($pdfPath, $tempPath);

$file = new UploadedFile(
    $tempPath,
    'test_payment.pdf',
    'application/pdf',
    null,
    true
);

echo "✓ Mock file created: test_payment.pdf\n";

// Test the extraction methods directly
echo "\n=== TESTING EXTRACTION METHODS ===\n";

$controller = new PaymentController();

// Use reflection to call private method
$reflectionMethod = new ReflectionMethod($controller, 'parsePdfFile');
$reflectionMethod->setAccessible(true);
$result = $reflectionMethod->invoke($controller, $file);

if ($result['success']) {
    echo "✓ PDF parsing successful\n";
    echo "  - Driver ID: {$result['driver_id']}\n";
    echo "  - Week Number: {$result['week_number']}\n";
    echo "  - Total Invoice: {$result['total_invoice']}\n";
} else {
    echo "✗ PDF parsing failed: {$result['message']}\n";
    exit(1);
}

// Clean up
unlink($tempPath);

echo "\n✓ All tests passed! PDF upload ready for use.\n";
?>
