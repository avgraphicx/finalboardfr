<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'password',
        'joined_date',
        'status',
        'broker_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['broker.subscriptionType', 'broker.subscriptions'];

    /**
     * Each user may own one broker record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function broker()
    {
        return $this->hasOne(Broker::class, 'user_id');
    }

    /**
     * Accessor to retrieve the broker’s company name directly.
     *
     * @return string|null
     */
    public function getCompanyNameAttribute(): ?string
    {
        return $this->broker->company_name ?? null;
    }

    /**
     * Accessor to retrieve the broker’s logo directly.
     *
     * @return string|null
     */
    public function getCompanyLogoAttribute(): ?string
    {
        return $this->broker->logo ?? null;
    }

    /**
     * Accessor to retrieve the subscription type.
     *
     * @return \App\Models\SubscriptionType|null
     */
    public function getSubscriptionTypeAttribute(): ?SubscriptionType
    {
        return $this->broker->subscriptionType ?? null;
    }

    /**
     * Accessor to retrieve all broker subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getSubscriptionsAttribute()
    {
        return $this->broker->subscriptions ?? collect();
    }

    /**
     * Accessor to retrieve active subscription (latest one).
     *
     * @return \App\Models\Subscription|null
     */
    public function getActiveSubscriptionAttribute(): ?Subscription
    {
        return $this->broker?->activeSubscription?->first();
    }
}
