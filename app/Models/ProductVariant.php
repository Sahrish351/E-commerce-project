<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price_modifier',
        'stock_quantity',
        'attributes',
        'is_active',
    ];

    protected $casts = [
        'price_modifier' => 'decimal:2',
        'stock_quantity' => 'integer',
        'attributes' => 'json',
        'is_active' => 'boolean',
    ];

    // ============ RELATIONSHIPS ============

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // ============ HELPERS ============

    public function getFinalPrice(): float
    {
        return (float) ($this->product->price + $this->price_modifier);
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function getAttributeString(): string
    {
        if (!$this->attributes) {
            return '';
        }

        return collect($this->attributes)
            ->map(fn($value, $key) => "$key: $value")
            ->join(', ');
    }
}
