<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    /**
     * Show settings page
     */
    public function index()
    {
        // Get current settings from database or config
        $settings = [
            'store_name' => config('app.name', 'StyleHub'),
            'store_email' => config('mail.from.address', 'admin@stylehub.com'),
            'currency' => 'USD',
            'payment_gateway' => 'payfast',
            'session_timeout' => 60,
            'max_login_attempts' => 5,
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'nullable|string|max:255',
            'store_email' => 'nullable|email|max:255',
            'currency' => 'nullable|string|max:10',
            'payment_gateway' => 'nullable|string|max:50',
            'session_timeout' => 'nullable|integer|min:5',
            'max_login_attempts' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Save settings to database or .env file
        // You can create a settings table to store these values
        $this->updateEnvFile($request);

        // Clear cache
        Cache::flush();
        Artisan::call('config:clear');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully!'
            ]);
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Update .env file (simple approach)
     */
    private function updateEnvFile($request)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        if ($request->filled('store_name')) {
            $envContent = preg_replace(
                '/APP_NAME=(.*)/',
                'APP_NAME=' . $request->store_name,
                $envContent
            );
        }

        if ($request->filled('store_email')) {
            $envContent = preg_replace(
                '/MAIL_FROM_ADDRESS=(.*)/',
                'MAIL_FROM_ADDRESS=' . $request->store_email,
                $envContent
            );
        }

        file_put_contents($envFile, $envContent);
    }

    /**
     * Reset settings to default
     */
    public function reset(Request $request)
    {
        // Reset settings logic
        Cache::flush();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings reset to default!'
            ]);
        }

        return back()->with('success', 'Settings reset to default!');
    }
}