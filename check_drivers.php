<?php
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

use App\Models\Driver;

$drivers = Driver::all(['id', 'driver_id', 'full_name'])->toArray();

echo "=== DRIVERS IN DATABASE ===\n";
if (count($drivers) === 0) {
    echo "No drivers found\n";
} else {
    foreach ($drivers as $driver) {
        echo "ID: {$driver['id']}, Driver ID: {$driver['driver_id']}, Name: {$driver['full_name']}\n";
    }
}

// Check if we have the test driver
$testDriver = Driver::where('driver_id', 'U9622')->first();
if (!$testDriver) {
    echo "\n⚠ Test driver U9622 not found. Need to create it.\n";
    echo "Create a driver with driver_id='U9622' to test the payment upload.\n";
} else {
    echo "\n✓ Test driver U9622 found!\n";
}
?>
