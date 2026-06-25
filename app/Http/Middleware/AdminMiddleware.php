<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first!');
        }

        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied! Admin only.');
        }

        return $next($request);
    }
}