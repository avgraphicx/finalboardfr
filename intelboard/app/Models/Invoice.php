<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'broker_id',
        'driver_id',
        'week_number',
        'warehouse_name',
        'invoice_total',
        'days_worked',
        'total_parcels',
        'vehicle_rental_price',
        'driver_percentage',
        'bonus',
        'cash_advance',
        'penalty',
        'amount_to_pay_driver',
        'broker_share',
        'enterprise_net',
        'is_paid',
        'pdf_path',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'invoice_total' => 'decimal:2',
            'vehicle_rental_price' => 'decimal:2',
            'driver_percentage' => 'decimal:2',
            'bonus' => 'decimal:2',
            'cash_advance' => 'decimal:2',
            'penalty' => 'decimal:2',
            'amount_to_pay_driver' => 'decimal:2',
            'broker_share' => 'decimal:2',
            'enterprise_net' => 'decimal:2',
            'is_paid' => 'boolean',
            'paid_at' => 'date',
        ];
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'broker_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    // Calculate computed fields dynamically
    public function calculateAmountToPayDriver(): float
    {
        return $this->invoice_total - $this->vehicle_rental_price - $this->bonus + $this->cash_advance - $this->penalty;
    }

    public function calculateBrokerShare(): float
    {
        return ($this->invoice_total * $this->driver_percentage / 100) - $this->bonus - $this->cash_advance + $this->penalty;
    }

    public function calculateEnterpriseNet(): float
    {
        return $this->invoice_total - $this->calculateAmountToPayDriver();
    }

    public function isPaid(): bool
    {
        return $this->is_paid === true;
    }
}
