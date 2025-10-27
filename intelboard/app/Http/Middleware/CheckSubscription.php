<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $hasCashierSubscription = $user->subscribed('default');
            $hasLegacySubscription = $user->legacySubscription?->isActive();

            if (!$hasCashierSubscription && !$hasLegacySubscription) {
                return redirect()->route('no.subscription');
            }
        }

        return $next($request);
    }
}
