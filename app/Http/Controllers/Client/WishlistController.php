<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.images')
            ->get();
        return view('client.wishlist.index', compact('wishlistItems'));
    }

    public function add($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            
            $exists = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
            
            if ($exists) {
                return redirect()->back()->with('error', 'Already in wishlist!');
            }
            
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            
            return redirect()->back()->with('success', 'Added to wishlist!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
        
        return redirect()->back()->with('success', 'Removed from wishlist');
    }

    /**
     * ✅ MOVE TO CART - ADD THIS METHOD
     */
    public function moveToCart($productId)
    {
        try {
            // Check if item exists in wishlist
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            
            if (!$wishlist) {
                return redirect()->back()->with('error', 'Item not found in wishlist!');
            }
            
            // Check if product exists and has stock
            $product = Product::find($productId);
            
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found!');
            }
            
            if (($product->stock_quantity ?? 0) <= 0) {
                return redirect()->back()->with('error', 'Product is out of stock!');
            }
            
            // Get or create cart
            $cart = Cart::where('user_id', Auth::id())->first();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => Auth::id(),
                    'total_items' => 0,
                    'total_price' => 0,
                ]);
            }
            
            // Check if already in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();
            
            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => 1,
                    'price' => $product->sale_price ?? $product->price,
                ]);
            }
            
            // Update cart totals
            $this->updateCartTotals($cart->id);
            
            // Remove from wishlist
            $wishlist->delete();
            
            return redirect()->back()->with('success', 'Moved to cart successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Update cart totals
     */
    private function updateCartTotals($cart_id)
    {
        $cart = Cart::find($cart_id);
        if ($cart) {
            $items = CartItem::where('cart_id', $cart_id)->get();
            $cart->total_items = $items->sum('quantity');
            $cart->total_price = $items->sum(function($item) {
                return $item->price * $item->quantity;
            });
            $cart->save();
        }
    }
}