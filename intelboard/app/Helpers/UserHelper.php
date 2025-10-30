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

if (!function_exists('subscriptionPriceLabel')) {
    function subscriptionPriceLabel(?string $priceId): ?string
    {
        if (!$priceId) {
            return null;
        }

        $priceCatalog = config('services.stripe.prices', []);

        $planLabels = [
            'bronze' => __('messages.bronze') ?? 'Bronze',
            'gold' => __('messages.gold') ?? 'Gold',
            'diamond' => __('messages.diamond') ?? 'Diamond',
        ];

        $intervalLabels = [
            'monthly' => __('messages.monthly') ?? 'Monthly',
            'quarterly' => __('messages.quarterly') ?? 'Quarterly',
            'semiannually' => __('messages.semiannually') ?? 'Semiannually',
            'yearly' => __('messages.yearly') ?? 'Yearly',
        ];

        foreach ($priceCatalog as $planKey => $intervals) {
            foreach ($intervals as $intervalKey => $configuredPrice) {
                if ($configuredPrice === $priceId) {
                    $planName = $planLabels[$planKey] ?? ucfirst($planKey);
                    $intervalName = $intervalLabels[$intervalKey] ?? ucfirst($intervalKey);
                    return "{$planName} - {$intervalName}";
                }
            }
        }

        return null;
    }
}
