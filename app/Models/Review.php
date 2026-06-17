<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_item_id',
        'rating',
        'title',
        'comment',
        'is_verified_buy',
        'helpful_count',
        'unhelpful_count',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_buy' => 'boolean',
        'helpful_count' => 'integer',
        'unhelpful_count' => 'integer',
        'is_approved' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    // ============ SCOPES ============

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_buy', true);
    }

    public function scopeHighRated($query, int $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeForProduct($query, Product $product)
    {
        return $query->where('product_id', $product->id);
    }

    // ============ HELPERS ============

    public function approve(): void
    {
        $this->update(['is_approved' => true]);
    }

    public function reject(): void
    {
        $this->delete();
    }

    public function addHelpful(): void
    {
        $this->increment('helpful_count');
    }

    public function addUnhelpful(): void
    {
        $this->increment('unhelpful_count');
    }

    public function getHelpfulPercentage(): float
    {
        $total = $this->helpful_count + $this->unhelpful_count;
        if ($total === 0) {
            return 0;
        }
        return ($this->helpful_count / $total) * 100;
    }

    public function isHelpful(): bool
    {
        return $this->helpful_count > $this->unhelpful_count;
    }

    public function getRatingLabel(): string
    {
        return match($this->rating) {
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent',
            default => 'Unrated',
        };
    }
}
