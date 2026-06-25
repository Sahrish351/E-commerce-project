<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // ✅ FIX: Redirect based on role
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}