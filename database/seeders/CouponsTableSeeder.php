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
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'minimum_order' => 500,
            'usage_limit' => 100,
            'expires_at' => now()->addDays(30),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE100',
            'discount_type' => 'fixed',
            'discount_value' => 100,
            'minimum_order' => 1000,
            'usage_limit' => 50,
            'expires_at' => now()->addDays(15),
            'is_active' => true,
        ]);
    }
}