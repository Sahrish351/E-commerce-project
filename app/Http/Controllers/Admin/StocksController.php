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
     
        $totalProducts = Product::count();

      
        $lowStock = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->count();

     
        $outOfStock = Product::where('stock_quantity', '<=', 0)->count();

      
        $totalItems = Product::sum('stock_quantity');

        
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

   
    public function lowStock()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 5)
            ->with('category')
            ->get();

        return response()->json($products);
    }

    
    public function outOfStock()
    {
        $products = Product::where('stock_quantity', '<=', 0)
            ->with('category')
            ->get();

        return response()->json($products);
    }
}