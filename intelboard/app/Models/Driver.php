<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    protected $fillable = [
        'driver_id',
        'full_name',
        'ssn',
        'license_number',
        'default_percentage',
        'default_rental_price',
        'active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'default_percentage' => 'decimal:2',
            'default_rental_price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
