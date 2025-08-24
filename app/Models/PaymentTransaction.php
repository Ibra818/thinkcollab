<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'purchase_id',
        'payment_method_id',
        'provider_transaction_id',
        'provider_reference',
        'amount',
        'currency',
        'fees',
        'status',
        'phone_number',
        'customer_name',
        'customer_email',
        'provider_response',
        'metadata',
        'failure_reason',
        'paid_at',
        'expires_at',
    ];

    protected $casts = [
        'provider_response' => 'array',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transaction) {
            if (empty($transaction->transaction_id)) {
                $transaction->transaction_id = 'TXN_' . strtoupper(Str::random(12));
            }
        });
    }

    /**
     * Get the purchase that owns the transaction
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the payment method used
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed transactions
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if transaction is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transaction has failed
     */
    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted(array $providerResponse = [])
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
            'provider_response' => array_merge($this->provider_response ?? [], $providerResponse),
        ]);
    }

    /**
     * Mark transaction as failed
     */
    public function markAsFailed(string $reason, array $providerResponse = [])
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
            'provider_response' => array_merge($this->provider_response ?? [], $providerResponse),
        ]);
    }

    /**
     * Get total amount including fees
     */
    public function getTotalAmount(): int
    {
        return $this->amount + $this->fees;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmount(): string
    {
        return number_format($this->amount / 100, 0, ',', ' ') . ' ' . $this->currency;
    }
}
