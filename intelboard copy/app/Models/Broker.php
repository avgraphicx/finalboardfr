<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Broker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'subscription_tier',
        'subscription_type_id',
    ];

    /**
     * A broker belongs to one user (owner).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A broker belongs to one subscription type.
     */
    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    /**
     * A broker can have multiple subscriptions over time.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'broker_id', 'id');
    }

    /**
     * The broker’s current (most recent) subscription.
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'broker_id', 'id')
                    ->latestOfMany('ends_at');
    }

    /**
     * Alias for backward compatibility (same as subscription()).
     */
    public function activeSubscription()
    {
        return $this->subscription();
    }
}
