<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_order_value',
        'max_usage',
        'per_user_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_usage' => 'integer',
        'per_user_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    // ============ RELATIONSHIPS ============

    public function orders(): HasMany
    {
        return $this->hasMany(CouponOrder::class);
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            });
    }

    public function scopePercentage($query)
    {
        return $query->where('discount_type', 'percentage');
    }

    public function scopeFixed($query)
    {
        return $query->where('discount_type', 'fixed');
    }

    // ============ HELPERS ============

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->valid_from && $this->valid_from > now()) {
            return false;
        }

        if ($this->valid_until && $this->valid_until < now()) {
            return false;
        }

        return true;
    }

    public function canBeUsed(): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->max_usage && $this->used_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    public function canUserUse(User $user): bool
    {
        if (!$this->canBeUsed()) {
            return false;
        }

        $userUsageCount = $this->orders()
            ->whereHas('order', fn($q) => $q->where('user_id', $user->id))
            ->count();

        return $userUsageCount < $this->per_user_limit;
    }

    public function calculateDiscount(float $orderTotal): float
    {
        if (!$this->canBeUsed()) {
            return 0;
        }

        if ($orderTotal < $this->min_order_value) {
            return 0;
        }

        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = ($orderTotal * $this->discount_value) / 100;
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
        } else {
            $discount = $this->discount_value;
        }

        return (float) $discount;
    }

    public function markAsUsed(): void
    {
        $this->increment('used_count');
    }

    public function getRemainingUsage(): ?int
    {
        if (!$this->max_usage) {
            return null;
        }

        return max(0, $this->max_usage - $this->used_count);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until < now();
    }
}
