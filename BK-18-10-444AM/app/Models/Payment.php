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
        'total_invoice',
        'parcel_rows_count',
        'vehicule_rental_price',
        'broker_percentage',
        'bonus',
        'cash_advance',
        'final_amount',
        'pdf_path',
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
            'bonus' => 'decimal:2',
            'cash_advance' => 'decimal:2',
            'final_amount' => 'decimal:2',
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
