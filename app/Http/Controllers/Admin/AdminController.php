<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ✅ OPTION 1: Remove constructor completely
    // public function __construct()
    // {
    //     // Empty
    // }

    // ✅ OPTION 2: Keep constructor with correct middleware
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    protected function isAdmin()
    {
        return Auth::user() && Auth::user()->role === 'admin';
    }

    protected function redirectIfNotAdmin()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Admin only area.');
        }
    }
}