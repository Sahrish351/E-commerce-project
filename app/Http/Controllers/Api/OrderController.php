<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_phone' => 'required|string',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart empty'], 400);
        }

        DB::beginTransaction();

        try {
            $subtotal = $cartItems->sum(function ($item) {
                $price = $item->product->sale_price ?? $item->product->price;
                return $item->quantity * $price;
            });

            $shipping = $subtotal > 500 ? 0 : 50;
            $tax = $subtotal * 0.05;
            $grandTotal = $subtotal + $shipping + $tax;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'SH-' . strtoupper(uniqid()) . '-' . date('Ymd'),
                'subtotal' => $subtotal,
                'shipping_charge' => $shipping,
                'tax_amount' => $tax,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_name' => auth()->user()->name,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
            ]);

            foreach ($cartItems as $item) {
                $price = $item->product->sale_price ?? $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'subtotal' => $item->quantity * $price,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            $customer = Customer::where('user_id', auth()->id())->first();
            if ($customer) {
                $customer->increment('total_spent', $grandTotal);
                $customer->addLoyaltyPoints(floor($grandTotal / 100) * 10);
            }

            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel this order'
            ], 400);
        }

        DB::beginTransaction();

        try {
            foreach ($order->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
                $item->product->decrement('sold_count', $item->quantity);
            }

            $order->update(['order_status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel'
            ], 500);
        }
    }

    public function track(Request $request)
    {
        $request->validate(['order_number' => 'required|string']);

        $order = Order::where('order_number', $request->order_number)->firstOrFail();

        $statusSteps = [
            'pending' => ['label' => 'Order Placed', 'completed' => true],
            'processing' => ['label' => 'Processing', 'completed' => in_array($order->order_status, ['processing', 'shipped', 'delivered'])],
            'shipped' => ['label' => 'Shipped', 'completed' => in_array($order->order_status, ['shipped', 'delivered'])],
            'delivered' => ['label' => 'Delivered', 'completed' => $order->order_status === 'delivered'],
        ];

        return response()->json([
            'success' => true,
            'order' => $order,
            'tracking' => $statusSteps
        ]);
    }
}