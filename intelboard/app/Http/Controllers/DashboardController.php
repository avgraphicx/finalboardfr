<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use App\Support\TimeFilter;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected StatsService $statsService;
    protected SubscriptionService $subscriptionService;

    public function __construct(StatsService $statsService, SubscriptionService $subscriptionService)
    {
        $this->statsService = $statsService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display the main dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $canUseAdvancedFilters = $this->canUseAdvancedFilters($user);
        $filter = $canUseAdvancedFilters
            ? TimeFilter::fromRequest($request)
            : null;

        $stats = $this->statsService->getDashboardStats($user, $filter);
        $viewFilter = $canUseAdvancedFilters ? $filter : TimeFilter::default();

        return view('pages.dashboards.index', [
            'stats' => $stats,
            'timeFilter' => $viewFilter,
            'canUseAdvancedFilters' => $canUseAdvancedFilters,
        ]);
    }

    /**
     * Refresh stats (returns fresh data).
     */
    public function refreshStats(Request $request)
    {
        $user = Auth::user();
        $canUseAdvancedFilters = $this->canUseAdvancedFilters($user);
        $filter = $canUseAdvancedFilters
            ? TimeFilter::fromRequest($request)
            : null;

        $stats = $this->statsService->getDashboardStats($user, $filter);

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'filter' => $stats['time_filter'],
            'can_use_advanced_filters' => $canUseAdvancedFilters,
        ]);
    }

    /**
     * Determine if the current user can access advanced time filters.
     */
    protected function canUseAdvancedFilters($user): bool
    {
        return $this->subscriptionService->hasStatsAccess('advanced', $user);
    }
}
