<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\CashierSeeder::class);

        // Create a test admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'full_name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 1, // Admin
                'active' => true,
            ]
        );

        // Create a test broker user
        User::firstOrCreate(
            ['email' => 'broker@example.com'],
            [
                'name' => 'Broker User',
                'full_name' => 'Test Broker',
                'password' => bcrypt('password'),
                'role' => 2, // Broker
                'phone_number' => '+1234567890',
                'company_name' => 'Test Logistics',
                'active' => true,
            ]
        );

        // Create a test supervisor user
        User::firstOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Supervisor User',
                'full_name' => 'Test Supervisor',
                'password' => bcrypt('password'),
                'role' => 3, // Supervisor
                'active' => true,
            ]
        );
    }
}
