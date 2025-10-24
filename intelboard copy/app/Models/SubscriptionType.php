<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionType extends Model
{
    use HasFactory;

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
     * Get all brokers that use this subscription type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brokers()
    {
        return $this->hasMany(Broker::class, 'subscription_type_id');
    }
}
