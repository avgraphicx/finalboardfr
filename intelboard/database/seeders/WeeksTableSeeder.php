<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeeksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('weeks')->truncate();

        // Generate weeks for years 2025 through 2027
        for ($year = 2025; $year <= 2027; $year++) {
            // Determine last ISO week number for the year
            $lastWeek = Carbon::create($year, 12, 28)->isoWeek();

            for ($week = 1; $week <= $lastWeek; $week++) {
                // Start of week (Monday)
                $start = Carbon::now()
                    ->setISODate($year, $week, 1) // 1 = Monday
                    ->toDateString();

                // End of week (Sunday)
                $end = Carbon::now()
                    ->setISODate($year, $week, 1)
                    ->addDays(6)
                    ->toDateString();

                DB::table('weeks')->insert([
                    'week'     => sprintf('%04d-%02d', $year, $week),
                    'startday' => $start,
                    'endday'   => $end,
                ]);
            }
        }
    }
}
