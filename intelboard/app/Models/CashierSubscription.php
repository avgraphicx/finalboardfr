<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscriptionModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashierSubscription extends CashierSubscriptionModel
{
    /**
     * Use a dedicated table to avoid clashing with the legacy subscriptions schema.
     */
    protected $table = 'cashier_subscriptions';

    /**
     * The owning user (billable).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Resolve the legacy subscription type / plan definition via Stripe price.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class, 'stripe_price', 'stripe_plan_id');
    }

    /**
     * Determine if the subscription should be treated as active.
     */
    public function isActive(): bool
    {
        if ($this->ended()) {
            return false;
        }

        return in_array($this->stripe_status, ['active', 'trialing', 'incomplete'], true);
    }

    /**
     * Determine whether the subscription has reached its end date.
     */
    public function ended(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }
}
