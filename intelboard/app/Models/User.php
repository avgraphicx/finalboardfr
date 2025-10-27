<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable, HasFactory, Notifiable;

    protected $fillable = [
        'google_id',
        'name',
        'full_name',
        'email',
        'password',
        'phone_number',
        'role', // 1=Admin, 2=Broker, 3=Supervisor
        'created_by',
        'joining_date',
        'active',
        'company_name',
        'logo',
        'subscription_tier',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'joining_date' => 'date',
            'active' => 'boolean',
            'role' => 'integer',
        ];
    }

    // === Relationships ===

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function activity(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function preferences(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'created_by');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'broker_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'broker_id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function statsCache(): HasMany
    {
        return $this->hasMany(StatsCache::class, 'broker_id');
    }

    // === Query Scopes ===

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role', 1);
    }

    public function scopeBrokers(Builder $query): Builder
    {
        return $query->where('role', 2);
    }

    public function scopeSupervisors(Builder $query): Builder
    {
        return $query->where('role', 3);
    }

    // === Helpers & Accessors ===

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }

    public function isBroker(): bool
    {
        return $this->role === 2;
    }

    public function isSupervisor(): bool
    {
        return $this->role === 3;
    }

    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            1 => 'Admin',
            2 => 'Broker',
            3 => 'Supervisor',
            default => 'Unknown',
        };
    }

    public function logoUrl(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
