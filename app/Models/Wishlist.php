<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
    ];

    // ============ RELATIONSHIPS ============

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // ============ SCOPES ============

    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    // ============ HELPERS ============

    public function isInWishlist(User $user, Product $product, ?ProductVariant $variant = null): bool
    {
        return static::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('variant_id', $variant?->id)
            ->exists();
    }
}
