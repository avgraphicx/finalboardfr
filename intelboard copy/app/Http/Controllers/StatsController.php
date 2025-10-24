<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StatsService;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
    // Auth is enforced via route middleware
        $this->statsService = $statsService;
    }

    /**
     * Show dashboard stats.
     */
    public function index()
    {
        $user = Auth::user();

        // Safety check — ensure broker exists
        if (!$user || !$user->broker) {
            return redirect()->route('login')->with('error', 'Broker not found or unauthorized.');
        }

        $broker = $user->broker;
        $stats = $this->statsService->getDashboardStats($broker);

        return view('pages.dashboards.index', compact('stats'));
    }
}
