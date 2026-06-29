<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Wishlist Page
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.images')
            ->get();
        
        return view('client.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add to Wishlist
     */
    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
        
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist!'
            ]);
        }
        
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!'
        ]);
    }

    /**
     * Remove from Wishlist
     */
    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist!'
        ]);
    }
}