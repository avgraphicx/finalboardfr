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
                // Calculate each day of the ISO week (Monday = 1)
                $weekStart = Carbon::now()->setISODate($year, $week, 1);
                $monday    = $weekStart->toDateString();
                $tuesday   = $weekStart->copy()->addDays(1)->toDateString();
                $wednesday = $weekStart->copy()->addDays(2)->toDateString();
                $thursday  = $weekStart->copy()->addDays(3)->toDateString();
                $friday    = $weekStart->copy()->addDays(4)->toDateString();
                $saturday  = $weekStart->copy()->addDays(5)->toDateString();
                $sunday    = $weekStart->copy()->addDays(6)->toDateString();

                DB::table('weeks')->insert([
                    'week'      => sprintf('%04d-%02d', $year, $week),
                    'monday'    => $monday,
                    'tuesday'   => $tuesday,
                    'wednesday' => $wednesday,
                    'thursday'  => $thursday,
                    'friday'    => $friday,
                    'saturday'  => $saturday,
                    'sunday'    => $sunday,
                ]);
            }
        }
    }
}
