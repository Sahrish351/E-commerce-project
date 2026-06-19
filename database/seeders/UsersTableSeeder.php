<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@stylehub.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'role' => 'admin',
        ]);

        
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'phone' => '9876543210',
            'role' => 'customer',   
        ]);

        Customer::create([
            'user_id' => $user->id,
            'loyalty_points' => 100,
            'total_spent' => 0,
            'is_premium' => false,
        ]);
    }
}