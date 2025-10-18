<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'subscription_tier',
        'subscription_type_id',
    ];

    /**
     * Get the subscription type that the broker belongs to.
     */
    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    /**
     * Get the user associated with the broker.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all drivers for this broker.
     */
    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }
}
