<?php

namespace App\Http\Controllers;

use App\Models\Driver;
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
    public function index()
    {
        $user = Auth::user();

        // Get comprehensive stats using the service
        $stats = $this->statsService->getDashboardStats($user);

        return view('pages.dashboards.index', compact('stats'));
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
}
