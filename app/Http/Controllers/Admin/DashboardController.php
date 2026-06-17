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
        // Basic Stats
        $totalSales = Order::where('order_status', 'delivered')->sum('grand_total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $processingOrders = Order::where('order_status', 'processing')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();
        
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();
        
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count();
        $outOfStock = Product::where('stock_quantity', '<=', 0)->count();
        
        $totalCategories = Category::count();
        
        // Recent Orders
        $recentOrders = Order::with('user')->latest()->limit(10)->get();
        
        // Low Stock Products
        $lowStockItems = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->with('category')
            ->limit(10)
            ->get();
        
        // Sales Chart Data (Last 30 Days)
        $salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->where('order_status', 'delivered')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top Selling Products
        $topProducts = Product::orderBy('sold_count', 'desc')
            ->with('category')
            ->limit(5)
            ->get();
        
        // Recent Users
        $recentUsers = User::latest()->limit(5)->get();
        
        // Monthly Sales (Last 12 Months)
        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('order_status', 'delivered')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        
        // Today's Stats
        $todaySales = Order::whereDate('created_at', today())
            ->where('order_status', 'delivered')
            ->sum('grand_total');
        
        $todayOrders = Order::whereDate('created_at', today())->count();
        
        // Top Customers by spending
        $topCustomers = Customer::with('user')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'pendingOrders', 'processingOrders',
            'deliveredOrders', 'cancelledOrders', 'totalUsers', 'newUsersThisMonth',
            'totalProducts', 'activeProducts', 'inactiveProducts', 'lowStockProducts',
            'outOfStock', 'totalCategories', 'recentOrders', 'lowStockItems',
            'salesData', 'topProducts', 'recentUsers', 'monthlySales',
            'todaySales', 'todayOrders', 'topCustomers'
        ));
    }
}