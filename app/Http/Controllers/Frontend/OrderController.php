<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('frontend.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load('items.product.images');
        
        // Status steps for tracking
        $statusSteps = [
            'pending' => ['status' => 'pending', 'label' => 'Order Placed', 'icon' => 'fa-clock', 'completed' => true],
            'processing' => ['status' => 'processing', 'label' => 'Processing', 'icon' => 'fa-gear', 'completed' => in_array($order->order_status, ['processing', 'shipped', 'delivered'])],
            'shipped' => ['status' => 'shipped', 'label' => 'Shipped', 'icon' => 'fa-truck', 'completed' => in_array($order->order_status, ['shipped', 'delivered'])],
            'delivered' => ['status' => 'delivered', 'label' => 'Delivered', 'icon' => 'fa-check-circle', 'completed' => $order->order_status === 'delivered'],
        ];
        
        return view('frontend.orders.show', compact('order', 'statusSteps'));
    }
    
    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string'
        ]);
        
        $order = Order::where('order_number', $request->order_number)->firstOrFail();
        
        $statusSteps = [
            'pending' => ['icon' => 'fa-clock', 'label' => 'Order Placed', 'completed' => true],
            'processing' => ['icon' => 'fa-gear', 'label' => 'Processing', 'completed' => in_array($order->order_status, ['processing', 'shipped', 'delivered'])],
            'shipped' => ['icon' => 'fa-truck', 'label' => 'Shipped', 'completed' => in_array($order->order_status, ['shipped', 'delivered'])],
            'delivered' => ['icon' => 'fa-check-circle', 'label' => 'Delivered', 'completed' => $order->order_status === 'delivered'],
        ];
        
        return view('frontend.orders.track', compact('order', 'statusSteps'));
    }
    
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }
        
        DB::beginTransaction();
        
        try {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
                $item->product->decrement('sold_count', $item->quantity);
            }
            
            $order->update(['order_status' => 'cancelled']);
            
            DB::commit();
            
            return back()->with('success', 'Order cancelled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order.');
        }
    }
    
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