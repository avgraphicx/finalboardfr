<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'amount',
        'date',
        'week',
        'for',
        'note',
        'broker_id',
    ];

    /**
     * Get the broker that owns the expense.
     */
    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }
}
