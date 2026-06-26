<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        // Total Products
        $totalProducts = Product::count();

        // Low Stock Products (<= 5)
        $lowStock = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->count();

        // Out of Stock Products
        $outOfStock = Product::where('stock_quantity', '<=', 0)->count();

        // Total Items in Stock
        $totalItems = Product::sum('stock_quantity');

        // All Products with Stock Details
        $products = Product::with('category')
            ->orderBy('stock_quantity', 'asc')
            ->paginate(15);

        return view('admin.stocks.index', compact(
            'totalProducts',
            'lowStock',
            'outOfStock',
            'totalItems',
            'products'
        ));
    }

    // Update stock for a product
    public function update(Request $request, $id)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update(['stock_quantity' => $request->stock_quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully!',
            'product' => $product
        ]);
    }

    // Get low stock products (AJAX)
    public function lowStock()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->with('category')
            ->get();

        return response()->json($products);
    }

    // Get out of stock products (AJAX)
    public function outOfStock()
    {
        $products = Product::where('stock_quantity', '<=', 0)
            ->with('category')
            ->get();

        return response()->json($products);
    }
}