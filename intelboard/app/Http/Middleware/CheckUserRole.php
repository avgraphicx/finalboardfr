<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  The allowed roles for this route.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Check if the user's role is in the list of allowed roles
        if (!in_array($user->role, $roles)) {
            // Redirect to a default location (e.g., home) or an unauthorized page
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
