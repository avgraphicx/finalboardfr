<?php
use App\Models\Driver;
use App\Models\User;

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
    echo "\n⚠ Test driver U9622 not found.\n";

    // Create one
    $user = User::first();
    if (!$user) {
        echo "No users in database. Cannot create test driver.\n";
    } else {
        Driver::create([
            'full_name' => 'John Smith',
            'driver_id' => 'U9622',
            'phone_number' => '555-0001',
            'license_number' => 'DL123456',
            'ssn' => '123-45-6789',
            'added_by' => $user->id,
            'active' => true
        ]);
        echo "✓ Created test driver U9622\n";
    }
} else {
    echo "\n✓ Test driver U9622 already exists!\n";
}
?>
