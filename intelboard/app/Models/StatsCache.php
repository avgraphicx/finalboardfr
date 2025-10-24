<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatsCache extends Model
{
    protected $table = 'stats_cache';

    protected $fillable = [
        'broker_id',
        'week_number',
        'year',
        'total_invoices',
        'total_parcels',
        'total_income',
        'total_paid_invoices',
        'total_unpaid_invoices',
        'top_driver_id',
    ];

    protected function casts(): array
    {
        return [
            'total_income' => 'decimal:2',
        ];
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'broker_id');
    }

    public function topDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'top_driver_id');
    }
}
