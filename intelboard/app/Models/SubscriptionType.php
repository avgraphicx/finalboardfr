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
        'max_files',
        'add_supervisor',
        'custom_invoice',
        'stats_type',
        'price',
        'stripe_plan_id',
    ];

    protected function casts(): array
    {
        return [
            'add_supervisor' => 'boolean',
            'custom_invoice' => 'boolean',
            'price' => 'decimal:2',
            'max_drivers' => 'integer',
            'max_files' => 'integer',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
