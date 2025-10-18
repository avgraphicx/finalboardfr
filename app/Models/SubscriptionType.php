<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscription_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'max_files',
        'add_supervisor',
        'max_drivers',
        'custom_invoice',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'add_supervisor' => 'boolean',
        'custom_invoice' => 'boolean',
    ];

    /**
     * Get all brokers with this subscription type.
     */
    public function brokers(): HasMany
    {
        return $this->hasMany(Broker::class, 'subscription_type_id');
    }
}
