<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority 1: Check session for locale
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // Priority 2: Check authenticated user's preference
        elseif (auth()->check() && auth()->user()->preference) {
            App::setLocale(auth()->user()->preference->language);
        }
        // Priority 3: Fall back to config default
        else {
            App::setLocale(config('app.locale', 'en'));
        }

        return $next($request);
    }
}
