<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_items',
        'total_price',
        'abandoned_at',
    ];

    protected $casts = [
        'total_items' => 'integer',
        'total_price' => 'decimal:2',
        'abandoned_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->whereNull('abandoned_at');
    }

    public function scopeAbandoned($query)
    {
        return $query->whereNotNull('abandoned_at');
    }

    // ============ HELPERS ============

    public function addItem(Product $product, int $quantity = 1, ?ProductVariant $variant = null): CartItem
    {
        $price = $variant ? $variant->getFinalPrice() : $product->price;

        $cartItem = $this->items()
            ->where('product_id', $product->id)
            ->where('variant_id', $variant?->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = $this->items()->create([
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        $this->updateTotals();
        return $cartItem;
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
        $this->updateTotals();
    }

    public function updateTotals(): void
    {
        $this->total_items = $this->items()->sum('quantity');
        $this->total_price = $this->items()->sum(\DB::raw('quantity * price'));
        $this->save();
    }

    public function isEmpty(): bool
    {
        return $this->total_items == 0;
    }

    public function abandon(): void
    {
        $this->update(['abandoned_at' => now()]);
    }

    public function recover(): void
    {
        $this->update(['abandoned_at' => null]);
    }

    public function clear(): void
    {
        $this->items()->delete();
        $this->updateTotals();
    }
}
