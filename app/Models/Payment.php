<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'currency',
        'transaction_id',
        'status',
        'gateway',
        'gateway_response',
        'paid_at',
        'refund_amount',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'gateway_response' => 'json',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ============ SCOPES ============

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    // ============ HELPERS ============

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function markAsCompleted(string $transactionId = ''): void
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public function processRefund(float $amount): void
    {
        $this->update([
            'status' => 'refunded',
            'refund_amount' => $amount,
            'refunded_at' => now(),
        ]);
    }

    public function getAmountDue(): float
    {
        $refunded = (float) $this->refund_amount;
        return (float) ($this->amount - $refunded);
    }
}
