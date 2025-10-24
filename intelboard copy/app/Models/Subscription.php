<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'broker_id',
        'subscription_id',
        'total_price',
        'created_at',
        'ends_at',
        'updated_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the broker associated with this subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    /**
     * Determine if the subscription is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if (!$this->ends_at) {
            return false;
        }

        return now()->lessThanOrEqualTo($this->ends_at);
    }
}
