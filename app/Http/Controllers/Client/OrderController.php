<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * My Orders Page
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
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
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if ($order->status === 'pending' || $order->status === 'processing') {
            $order->update(['status' => 'cancelled']);
            return back()->with('success', 'Order cancelled successfully!');
        }
        
        return back()->with('error', 'This order cannot be cancelled.');
    }
}