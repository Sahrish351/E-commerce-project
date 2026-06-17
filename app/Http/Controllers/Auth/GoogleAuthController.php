<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'Google login failed! Please try again.');
        }

        
        $existingUser = User::where('google_id', $googleUser->id)->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return redirect('/')->with('success', 'Welcome back, ' . $existingUser->name . '!');
        }

       
        $userByEmail = User::where('email', $googleUser->email)->first();

        if ($userByEmail) {
            $userByEmail->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);
            Auth::login($userByEmail);
            return redirect('/')->with('success', 'Google account linked successfully!');
        }

        $newUser = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'password' => Hash::make(Str::random(16)),
            // 'role' => 'user',
        ]);

       
        Customer::create([
            'user_id' => $newUser->id,
            'loyalty_points' => 0,
            'total_spent' => 0,
            'is_premium' => false,
        ]);

        Auth::login($newUser);

        return redirect('/')->with('success', 'Account created successfully with Google!');
    }
}