<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        // ============================================
        // STATS CARDS DATA
        // ============================================
        
        // Total Revenue
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

        // Total Orders
        $totalOrders = Order::count();

        // Total Visitors (Users)
        $totalVisitors = User::count();

        // Conversion Rate (orders / visitors * 100)
        $conversionRate = $totalVisitors > 0 ? round(($totalOrders / $totalVisitors) * 100, 1) : 0;

        // ============================================
        // ORDER STATUS COUNTS
        // ============================================
        
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // ============================================
        // ✅ STATUS CHART DATA (FOR PIE CHART)
        // ============================================
        
        // Ye data view mein pass ho raha hai
        $statusData = [
            $pendingOrders,
            $processingOrders,
            $shippedOrders,
            $deliveredOrders,
            $cancelledOrders
        ];

        // ============================================
        // REVENUE CHART DATA (Last 12 Months)
        // ============================================
        
        $monthlyRevenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = [];
        $chartData = [];
        foreach ($monthlyRevenue as $data) {
            $chartLabels[] = date('M', mktime(0, 0, 0, $data->month, 1));
            $chartData[] = (int) $data->total; // Convert to integer for chart
        }

        // ============================================
        // TOP SELLING PRODUCTS
        // ============================================
        
        $topProducts = Product::orderBy('sold_count', 'desc')
            ->with('category')
            ->limit(5)
            ->get();

        // ============================================
        // ✅ COMPACT ALL DATA
        // ============================================
        
        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalVisitors',
            'conversionRate',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'chartLabels',
            'chartData',
            'topProducts',
            'statusData'  // ✅ ADD THIS
        ));
    }
}