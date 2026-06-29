<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // ===== ORDER STATS =====
        $orderStats = [
            'total' => Order::where('user_id', $userId)->count(),
            'pending' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'processing' => Order::where('user_id', $userId)->where('status', 'processing')->count(),
            'shipped' => Order::where('user_id', $userId)->where('status', 'shipped')->count(),
            'delivered' => Order::where('user_id', $userId)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('user_id', $userId)->where('status', 'cancelled')->count(),
        ];

        // ===== RECENT ORDERS (last 5) =====
        $recentOrders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ===== DAILY ORDERS =====
        $dailyOrders = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $startOfWeek = Carbon::now()->startOfWeek();
        
        foreach ($days as $index => $day) {
            $date = $startOfWeek->copy()->addDays($index);
            $count = Order::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
            $dailyOrders[$day] = $count;
        }

        // ===== WEEKLY ORDERS =====
        $weeklyOrders = [];
        for ($i = 1; $i <= 4; $i++) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $count = Order::where('user_id', $userId)
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $weeklyOrders[$i] = $count;
        }

        // ===== MONTHLY ORDERS =====
        $monthlyOrders = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($months as $index => $month) {
            $monthNum = $index + 1;
            $count = Order::where('user_id', $userId)
                ->whereMonth('created_at', $monthNum)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $monthlyOrders[$month] = $count;
        }

        // ===== YEARLY ORDERS =====
        $yearlyOrders = [];
        for ($i = 0; $i < 5; $i++) {
            $year = Carbon::now()->year - $i;
            $count = Order::where('user_id', $userId)
                ->whereYear('created_at', $year)
                ->count();
            $yearlyOrders[$year] = $count;
        }

        // ===== WISHLIST COUNT =====
        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return view('client.dashboard', compact(
            'user',
            'orderStats',
            'recentOrders',
            'dailyOrders',
            'weeklyOrders',
            'monthlyOrders',
            'yearlyOrders',
            'wishlistCount'
        ));
    }
}