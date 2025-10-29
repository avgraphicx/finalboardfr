<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Global helper to access the authenticated user with full relations.
 *
 * Usage:
 * currentUser()->company_name
 * currentUser()->currentCashierSubscription()?->plan?->max_drivers
 * currentUser()->currentCashierSubscription()?->ends_at
 *
 * @return \App\Models\User|null
 */
if (!function_exists('currentUser')) {
    function currentUser(): ?User
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        // Always eager load subscription relationships for downstream feature checks
        return $user->load([
            'subscriptions.plan',
        ]);
    }
}
