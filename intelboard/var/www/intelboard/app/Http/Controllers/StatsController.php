<?php

namespace App\Http\Controllers;

use App\Models\StatsCache;
use App\Models\Invoice;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StatsController extends Controller
{
    /**
     * Get dashboard statistics for current week.
     */
    public function index(): View
    {
        $user = Auth::user();
        $weekNumber = now()->weekOfYear;
        $year = now()->year;

        $stats = StatsCache::firstOrCreate(
            [
                'broker_id' => $user->id,
                'week_number' => $weekNumber,
                'year' => $year,
            ],
            $this->calculateWeeklyStats($user->id, $weekNumber, $year)
        );

        $drivers = Driver::where('created_by', $user->id)
            ->withCount('invoices')
            ->get();

        return view('dashboard.index', compact('stats', 'drivers'));
    }

    /**
     * Get detailed driver statistics for current week.
     */
    public function driverStats(): View
    {
        $user = Auth::user();
        $weekNumber = now()->weekOfYear;
        $year = now()->year;

        $drivers = Driver::where('created_by', $user->id)
            ->with(['invoices' => function ($query) use ($weekNumber, $year) {
                $query->where('week_number', $weekNumber)->where('year', $year);
            }])
            ->get()
            ->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'driver_id' => $driver->driver_id,
                    'days_worked' => $driver->invoices->count(),
                    'total_parcels' => $driver->invoices->sum('total_parcels'),
                    'total_invoices' => $driver->invoices->count(),
                    'earnings' => $driver->invoices->sum(function ($invoice) {
                        return $invoice->calculateAmountToPayDriver();
                    }),
                ];
            })
            ->sortByDesc('earnings')
            ->values();

        return view('stats.drivers', compact('drivers'));
    }

    /**
     * Get average metrics for current week.
     */
    public function averageMetrics(): View
    {
        $user = Auth::user();
        $weekNumber = now()->weekOfYear;
        $year = now()->year;

        $invoices = Invoice::where('broker_id', $user->id)
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->get();

        $driverCount = Driver::where('created_by', $user->id)->where('active', true)->count();

        $stats = [
            'avg_parcels_per_invoice' => $invoices->count() > 0 ? round($invoices->sum('total_parcels') / $invoices->count(), 2) : 0,
            'avg_invoice_total' => $invoices->count() > 0 ? round($invoices->sum('invoice_total') / $invoices->count(), 2) : 0,
            'avg_earnings_per_driver' => $driverCount > 0 ? round(
                $invoices->sum(function ($invoice) {
                    return $invoice->calculateAmountToPayDriver();
                }) / $driverCount,
                2
            ) : 0,
            'total_drivers' => $driverCount,
            'total_invoices' => $invoices->count(),
            'total_income' => round($invoices->sum('invoice_total'), 2),
        ];

        return view('stats.averages', compact('stats'));
    }

    /**
     * Get earnings breakdown by broker and week.
     */
    public function earningsByWeek(): View
    {
        $user = Auth::user();
        $weeks = [];

        for ($i = 0; $i < 12; $i++) {
            $date = now()->subWeeks($i);
            $weekNumber = $date->weekOfYear;
            $year = $date->year;

            $stats = StatsCache::where('broker_id', $user->id)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->first();

            if (!$stats) {
                $stats = (object) $this->calculateWeeklyStats($user->id, $weekNumber, $year);
            }

            $weeks[] = [
                'week' => "Week $weekNumber - $year",
                'income' => round($stats->total_income ?? 0, 2),
                'paid_invoices' => $stats->total_paid_invoices ?? 0,
                'unpaid_invoices' => $stats->total_unpaid_invoices ?? 0,
            ];
        }

        return view('stats.earnings-by-week', compact('weeks'));
    }

    /**
     * Calculate weekly statistics.
     */
    private function calculateWeeklyStats(int $brokerId, int $weekNumber, int $year): array
    {
        return [
            'total_invoices' => Invoice::where('broker_id', $brokerId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->count(),
            'total_parcels' => Invoice::where('broker_id', $brokerId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->sum('total_parcels'),
            'total_income' => Invoice::where('broker_id', $brokerId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->sum('invoice_total'),
            'total_paid_invoices' => Invoice::where('broker_id', $brokerId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->where('is_paid', true)
                ->count(),
            'total_unpaid_invoices' => Invoice::where('broker_id', $brokerId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->where('is_paid', false)
                ->count(),
        ];
    }
}
