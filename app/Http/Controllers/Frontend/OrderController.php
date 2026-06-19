<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ===== MY ORDERS (ALL) =====
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.index', compact('orders'));
    }

    // ===== ORDER DETAIL =====
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load('items.product.images');
        
        return view('frontend.orders.show', compact('order'));
    }

    // ===== MY RETURNS =====
    public function returns()
    {
        $returns = Order::where('user_id', Auth::id())
            ->where('status', 'refunded')  // ✅ order_status → status, cancelled → refunded
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.returns', compact('returns'));
    }

    // ===== MY CANCELLATIONS =====
    public function cancellations()
    {
        $cancellations = Order::where('user_id', Auth::id())
            ->where('status', 'cancelled')  // ✅ order_status → status
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.cancellations', compact('cancellations'));
    }

    // ===== CANCEL ORDER =====
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        if (!in_array($order->status, ['pending', 'processing'])) {  // ✅ order_status → status
            return back()->with('error', 'This order cannot be cancelled.');
        }
        
        DB::beginTransaction();
        
        try {
            foreach ($order->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
                $item->product->decrement('sold_count', $item->quantity);
            }
            
            $order->update(['status' => 'cancelled']);  // ✅ order_status → status
            
            DB::commit();
            
            return back()->with('success', 'Order cancelled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order.');
        }
    }

    // ===== RETURN REQUEST =====
    public function returnRequest(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($order->status !== 'delivered') {  // ✅ order_status → status
            return back()->with('error', 'Only delivered orders can be returned.');
        }
        
        $order->update(['status' => 'refunded']);  // ✅ order_status → status, return_requested → refunded
        
        return back()->with('success', 'Return request submitted successfully!');
    }

    // ===== REORDER =====
    public function reorder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        foreach ($order->items as $item) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($cart) {
                $cart->increment('quantity', $item->quantity);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Items added to cart!');
    }
}