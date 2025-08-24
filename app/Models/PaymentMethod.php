<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'type',
        'code',
        'currency',
        'fee_percentage',
        'fee_fixed',
        'is_active',
        'config',
        'logo_url',
    ];

    protected $casts = [
        'config' => 'array',
        'fee_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get payment transactions for this method
     */
    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    /**
     * Scope for active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for mobile money methods
     */
    public function scopeMobileMoney($query)
    {
        return $query->where('type', 'mobile_money');
    }

    /**
     * Scope for card methods
     */
    public function scopeCard($query)
    {
        return $query->where('type', 'card');
    }

    /**
     * Calculate fees for a given amount
     */
    public function calculateFees(int $amount): int
    {
        $percentageFee = ($amount * $this->fee_percentage) / 100;
        return (int) ($percentageFee + $this->fee_fixed);
    }

    /**
     * Get total amount including fees
     */
    public function getTotalAmount(int $amount): int
    {
        return $amount + $this->calculateFees($amount);
    }
}
