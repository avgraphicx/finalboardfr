<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Global helper to access the authenticated user with full relations.
 *
 * Usage:
 * currentUser()->company_name
 * currentUser()->subscription->subscriptionType->max_drivers
 * currentUser()->subscription->ends_at
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

        // Always eager load subscription and subscriptionType relationships
        return $user->load([
            'subscription.subscriptionType',
        ]);
    }
}
