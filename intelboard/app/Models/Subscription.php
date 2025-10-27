<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'broker_id',
        'subscription_type_id',
        'stripe_subscription_id',
        'stripe_status',
        'started_at',
        'ends_at',
        'price_paid',
        'auto_renew',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ends_at' => 'date',
            'price_paid' => 'decimal:2',
            'auto_renew' => 'boolean',
        ];
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'broker_id');
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class);
    }

    public function isActive(): bool
    {
        // Check if subscription has not expired
        if ($this->ends_at && $this->ends_at->isPast()) {
            return false;
        }

        // If stripe_status exists, it must be 'active'
        // If no stripe_status, consider it active if ends_at is in future or null
        if ($this->stripe_status) {
            return $this->stripe_status === 'active';
        }

        // No stripe_status set, check if ends_at is valid
        return !$this->ends_at || $this->ends_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->ends_at->isPast();
    }

    public function daysRemaining(): int
    {
        return now()->diffInDays($this->ends_at, false);
    }
}
