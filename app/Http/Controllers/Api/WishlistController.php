<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $wishlist = Wishlist::with('product.images')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $wishlist
        ]);
    }

    public function add($productId)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->delete();
            
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Removed from wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'action' => 'added',
            'message' => 'Added to wishlist'
        ]);
    }

    public function remove($productId)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist'
        ]);
    }

    public function moveToCart($productId)
    {
        $wishlistItem = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->firstOrFail();

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moved to cart'
        ]);
    }

    public function count()
    {
        $count = Wishlist::where('user_id', auth()->id())->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}