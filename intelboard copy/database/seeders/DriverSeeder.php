<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $driverIds = [
            'V4434', 'V0923', 'V4000', 'V7797',
            'W0316', 'W2203', 'W3313', 'W3450', 'V8155',
        ];

        $firstNames = ['Ismail', 'Alex', 'Sophie', 'Marc', 'Julie', 'Noah', 'Emma', 'Lucas', 'Olivia', 'Liam', 'Chloe'];
        $lastNames = ['Tremblay', 'Gagnon', 'Roy', 'Cote', 'Bouchard', 'Belanger', 'Morin', 'Lavoie', 'Fortin', 'Gauthier'];

        foreach ($driverIds as $code) {
            // Skip if driver_id already exists
            if (DB::table('drivers')->where('driver_id', $code)->exists()) {
                continue;
            }

            $first = $firstNames[array_rand($firstNames)];
            $last = $lastNames[array_rand($lastNames)];
            $fullName = "$first $last";

            // Random phone number (438123XXXX)
            $phone = '438123' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            // Québec driver’s license (1 letter + 4 digits + YYYYMMDD + 2 digits)
            $license = strtoupper(Str::random(1))
                . random_int(1000, 9999)
                . date('Ymd', strtotime('-' . random_int(20, 50) . ' years'))
                . random_int(10, 99);

            // Canadian SIN (9 digits, no dashes)
            $ssn = str_pad(random_int(100000000, 999999999), 9, '0', STR_PAD_LEFT);

            DB::table('drivers')->insert([
                'full_name' => $fullName,
                'phone_number' => $phone,
                'driver_id' => $code,
                'license_number' => $license,
                'ssn' => $ssn,
                'default_percentage' => 25.00,
                'default_rental_price' => 60.00,
                'added_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
