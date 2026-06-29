<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = Order::where('user_id', Auth::id());
    
    // ✅ Filter by status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
    $orders = $query->orderBy('created_at', 'desc')->paginate(10);
    
    return view('client.orders.index', compact('orders'));
}

    /**
     * Order Details
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);
        
        return view('client.orders.show', compact('order'));
    }

    /**
     * Cancel Order
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($id);
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->route('client.orders')->with('success', 'Order cancelled successfully!');
    }

    /**
     * ✅ Reorder - Add to Cart
     */
    public function reorder($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        // Get or create cart for user
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'total_items' => 0,
                'total_price' => 0,
            ]);
        }
        
        // Add order items to cart
        foreach ($order->items as $item) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($cartItem) {
                $cartItem->increment('quantity', $item->quantity);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                ]);
            }
        }
        
        // Update cart totals
        $this->updateCartTotals($cart->id);
        
        return redirect()->route('cart.index')->with('success', 'Items added to cart successfully!');
    }

    /**
     * Helper: Update Cart Totals
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