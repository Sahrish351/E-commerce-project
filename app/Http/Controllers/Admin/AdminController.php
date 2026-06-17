<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Apply auth and admin middleware to all admin routes
        $this->middleware(['auth', 'admin']);
    }
    
    /**
     * Check if user is admin
     */
    protected function isAdmin()
    {
        return Auth::user() && Auth::user()->role === 'admin';
    }
    
    /**
     * Redirect if not admin
     */
    protected function redirectIfNotAdmin()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Admin only area.');
        }
    }
}