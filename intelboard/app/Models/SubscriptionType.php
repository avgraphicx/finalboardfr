<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionType extends Model
{
    protected $table = 'subscription_types';

    protected $fillable = [
        'name',
        'max_drivers',
        'add_supervisor',
        'custom_invoice',
        'price',
        'stripe_plan_id',
    ];

    protected function casts(): array
    {
        return [
            'add_supervisor' => 'boolean',
            'custom_invoice' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
