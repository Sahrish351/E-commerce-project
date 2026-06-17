<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'loyalty_points',
        'total_spent',
        'is_premium',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'loyalty_points' => 'integer',
        'total_spent' => 'decimal:2',
        'is_premium' => 'boolean',
    ];

    // ============ RELATIONSHIPS ============

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ============ HELPERS ============

    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
    }

    public function removeLoyaltyPoints(int $points): void
    {
        $this->decrement('loyalty_points', $points);
    }

    public function updateTotalSpent(float $amount): void
    {
        $this->increment('total_spent', $amount);
    }
}
