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
        
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

      
        $totalOrders = Order::count();

        $totalVisitors = User::count();

        $conversionRate = $totalVisitors > 0 ? round(($totalOrders / $totalVisitors) * 100, 1) : 0;

        
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

       
        $statusData = [
            $pendingOrders,
            $processingOrders,
            $shippedOrders,
            $deliveredOrders,
            $cancelledOrders
        ];

        
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

      
        
        $topProducts = Product::orderBy('sold_count', 'desc')
            ->with('category')
            ->limit(5)
            ->get();

       
        
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
            'statusData'  
        ));
    }
}