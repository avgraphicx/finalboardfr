<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'week_number',
        'warehouse',
        'total_invoice',
        'total_parcels',
        'parcel_rows_count',
        'vehicule_rental_price',
        'broker_percentage',
        'broker_van_cut',
        'broker_pay_cut',
        'bonus',
        'cash_advance',
        'final_amount',
        'pdf_path',
        'paid',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_invoice' => 'decimal:2',
            'vehicule_rental_price' => 'decimal:2',
            'broker_percentage' => 'decimal:2',
            'broker_van_cut' => 'decimal:2',
            'broker_pay_cut' => 'decimal:2',
            'bonus' => 'decimal:2',
            'cash_advance' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'paid' => 'boolean',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Get the driver associated with this payment.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
