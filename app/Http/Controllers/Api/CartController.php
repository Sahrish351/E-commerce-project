<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Get cart
    public function index()
    {
        $cartItems = Cart::with('product.images')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
        });

        return response()->json([
            'success' => true,
            'data' => $cartItems,
            'subtotal' => $subtotal,
            'total_items' => $cartItems->sum('quantity')
        ]);
    }

    // Add to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock'
            ], 400);
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Added to cart',
            'cart_count' => Cart::where('user_id', auth()->id())->sum('quantity')
        ]);
    }

    // Update cart
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated'
        ]);
    }

    // Remove from cart
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed'
        ]);
    }

    // Apply coupon
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->code))
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon'], 400);
        }

        $subtotal = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(function ($item) {
                return $item->quantity * ($item->product->sale_price ?? $item->product->price);
            });

        if ($coupon->minimum_order && $subtotal < $coupon->minimum_order) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order ₹{$coupon->minimum_order} required"
            ], 400);
        }

        if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * $coupon->discount_value) / 100;
        } else {
            $discount = $coupon->discount_value;
        }
        $discount = min($discount, $subtotal);

        return response()->json([
            'success' => true,
            'coupon' => $coupon,
            'discount' => $discount
        ]);
    }
}