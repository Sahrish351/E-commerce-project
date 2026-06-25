<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends AdminController
{
    public function index()
    {
        
        $totalSales = Order::where('status', 'delivered')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();

   
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();
        $lowStockProducts = 0;
        $outOfStock = Product::where('stock_quantity', '<=', 0)->count();

       
        $totalCategories = Category::count();

        
        $recentOrders = Order::with('user')->latest()->limit(10)->get();

        
        $lowStockItems = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->with('category')
            ->limit(10)
            ->get();

      
        $salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->where('status', 'delivered')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = Product::orderBy('sold_count', 'desc')
            ->with('category')
            ->limit(5)
            ->get();

      
        $recentUsers = User::latest()->limit(5)->get();

        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', 'delivered')
            ->sum('total_amount');

        $todayOrders = Order::whereDate('created_at', today())->count();

       
        $topCustomers = Customer::with('user')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

       
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'values' => Order::where('status', 'delivered')
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total')
                ->toArray(),
        ];

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalUsers',
            'newUsersThisMonth',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStock',
            'totalCategories',
            'recentOrders',
            'lowStockItems',
            'salesData',
            'topProducts',
            'recentUsers',
            'monthlySales',
            'todaySales',
            'todayOrders',
            'topCustomers',
            'chartData'
        ));
    }
}