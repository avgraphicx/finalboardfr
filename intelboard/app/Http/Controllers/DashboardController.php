<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use App\Support\TimeFilter;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = TimeFilter::fromRequest($request);

        // Get comprehensive stats using the service
        $stats = $this->statsService->getDashboardStats($user, $filter);

        return view('pages.dashboards.index', [
            'stats' => $stats,
            'timeFilter' => $filter,
        ]);
    }

    /**
     * Refresh stats (returns fresh data)
     */
    public function refreshStats(Request $request)
    {
        $user = Auth::user();
        $filter = TimeFilter::fromRequest($request);
        $stats = $this->statsService->getDashboardStats($user, $filter);

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'filter' => $filter->toArray(),
        ]);
    }
}
