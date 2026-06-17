<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->get();
        
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }
    
    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();
        
        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Added to wishlist!',
                'action' => 'added'
            ]);
        } else {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist!',
                'action' => 'removed'
            ]);
        }
    }
    
    public function remove($id)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->delete();
        
        return back()->with('success', 'Item removed from wishlist!');
    }
    
    public function moveToCart($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->firstOrFail();
        
        // Add to cart
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();
        
        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }
        
        // Remove from wishlist
        $wishlistItem->delete();
        
        return redirect()->route('cart.index')->with('success', 'Moved to cart successfully!');
    }
    
    public function getWishlistCount()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}