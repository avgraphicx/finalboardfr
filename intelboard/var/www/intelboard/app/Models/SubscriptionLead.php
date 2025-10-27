<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionLead extends Model
{
    protected $fillable = [
        'subscription_type_id',
        'plan_slug',
        'plan_name',
        'plan_price',
        'name',
        'email',
        'company',
        'phone',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'plan_price' => 'decimal:2',
        ];
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class);
    }
}
