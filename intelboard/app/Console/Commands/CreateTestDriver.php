<?php

namespace App\Console\Commands;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Console\Command;

class CreateTestDriver extends Command
{
    protected $signature = 'driver:create-test';
    protected $description = 'Create a test driver for PDF upload testing';

    public function handle()
    {
        $testDriver = Driver::where('driver_id', 'U9622')->first();

        if ($testDriver) {
            $this->info('✓ Test driver U9622 already exists!');
            return 0;
        }

        $user = User::first();
        if (!$user) {
            $this->error('No users in database. Cannot create test driver.');
            return 1;
        }

        Driver::create([
            'full_name' => 'John Smith',
            'driver_id' => 'U9622',
            'phone_number' => '555-0001',
            'license_number' => 'DL123456',
            'ssn' => '123-45-6789',
            'added_by' => $user->id,
            'active' => true
        ]);

        $this->info('✓ Created test driver U9622');
        return 0;
    }
}
?>
