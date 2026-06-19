<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'description' => '10% off on first order',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'min_order_value' => 500,        // ✅ SAHI COLUMN
            'max_usage' => 100,              // ✅ SAHI COLUMN
            'per_user_limit' => 1,
            'valid_from' => now(),
            'valid_until' => now()->addDays(30),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE100',
            'description' => 'Save $100 on orders above $1000',
            'discount_type' => 'fixed',
            'discount_value' => 100,
            'min_order_value' => 1000,       // ✅ SAHI COLUMN
            'max_usage' => 50,               // ✅ SAHI COLUMN
            'per_user_limit' => 1,
            'valid_from' => now(),
            'valid_until' => now()->addDays(15),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLAT50',
            'description' => 'Flat $50 discount',
            'discount_type' => 'fixed',
            'discount_value' => 50,
            'min_order_value' => 0,
            'max_usage' => 200,
            'per_user_limit' => 1,
            'valid_from' => now(),
            'valid_until' => now()->addDays(7),
            'is_active' => true,
        ]);
    }
}