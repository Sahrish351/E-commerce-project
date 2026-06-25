<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // Settings update logic here
        // You can store settings in database or .env file

        return back()->with('success', 'Settings updated successfully!');
    }
}