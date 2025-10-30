<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Services\StatsService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * Display the main dashboard.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        // Accept optional date range and granularity from query params
        $from = $request->query('from');
        $to = $request->query('to');
        $granularity = $request->query('granularity', 'week');

        // Get comprehensive stats using the service
        $stats = $this->statsService->getDashboardStats($user, $from, $to, $granularity);

        return view('pages.dashboards.index', compact('stats', 'from', 'to', 'granularity'));
    }

    /**
     * Refresh stats (returns fresh data)
     */
    public function refreshStats()
    {
        $user = Auth::user();
        $stats = $this->statsService->getDashboardStats($user);

        return response()->json(['success' => true, 'stats' => $stats]);
    }

    /**
     * Debug endpoint to return raw stats and diagnostic data for a given date range.
     * Useful for verifying what the service sees for the current broker.
     */
    public function debugStats(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        $from = $request->query('from');
        $to = $request->query('to');
        $granularity = $request->query('granularity', 'week');

        // get stats
        $stats = $this->statsService->getDashboardStats($user, $from, $to, $granularity);

        // compute driver ids (mirror service logic) — check for broker_id column
        $driverIdsQuery = Driver::query();
        if (Schema::hasColumn('drivers', 'broker_id')) {
            $driverIdsQuery->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhere('broker_id', $user->id);
            });
        } else {
            $driverIdsQuery->where('created_by', $user->id);
        }

        $driverIds = $driverIdsQuery->pluck('id')->toArray();

        // invoice counts for those drivers (with optional date filter)
        $invoiceQuery = \App\Models\Invoice::whereIn('driver_id', $driverIds);
        if ($from && $to) {
            try {
                $fromDt = Carbon::parse($from)->startOfDay();
                $toDt = Carbon::parse($to)->endOfDay();
                // convert to UTC for DB timestamp comparison
                $fromUtc = $fromDt->copy()->setTimezone('UTC')->toDateTimeString();
                $toUtc = $toDt->copy()->setTimezone('UTC')->toDateTimeString();
                $invoiceQuery = $invoiceQuery->whereBetween('created_at', [$fromUtc, $toUtc]);
            } catch (\Exception $e) {
                // ignore parsing error and leave unfiltered
            }
        }

        $invoiceCount = $invoiceQuery->count();
        $invoiceSum = $invoiceQuery->sum('invoice_total');

        // additional diagnostics: min/max created_at for invoices belonging to these drivers
        $allInvoicesQuery = \App\Models\Invoice::whereIn('driver_id', $driverIds);
        $minCreated = $allInvoicesQuery->min('created_at');
        $maxCreated = $allInvoicesQuery->max('created_at');

        // sample first invoice timestamps (helps detect timezone mismatch)
        $sampleInvoice = $allInvoicesQuery->orderBy('created_at', 'asc')->first();
        $sampleCreated = $sampleInvoice ? $sampleInvoice->created_at : null;

        $serverTimezone = date_default_timezone_get();
        $appTimezone = config('app.timezone');

        return response()->json([
            'success' => true,
            'driver_count' => count($driverIds),
            'driver_ids' => $driverIds,
            'invoice_count' => $invoiceCount,
            'invoice_sum' => $invoiceSum,
            'stats' => $stats,
        ]);
    }
}
