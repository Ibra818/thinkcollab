<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'formation_id',
        'amount',
        'status',
        'payment_provider_id',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the formation that was purchased
     */
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Get payment transactions for this purchase
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    /**
     * Get the latest payment transaction
     */
    public function latestTransaction(): HasOne
    {
        return $this->hasOne(PaymentTransaction::class)->latest();
    }

    /**
     * Get completed payment transactions
     */
    public function completedTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class)->where('status', 'completed');
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
