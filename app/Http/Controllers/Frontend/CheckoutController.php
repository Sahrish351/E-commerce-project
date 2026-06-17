<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
        });
        
        $coupon = session()->get('coupon');
        $discount = 0;
        
        if ($coupon) {
            if ($coupon->discount_type === 'percentage') {
                $discount = ($subtotal * $coupon->discount_value) / 100;
                $discount = min($discount, $subtotal);
            } else {
                $discount = min($coupon->discount_value, $subtotal);
            }
        }
        
        $shipping = $subtotal > 500 ? 0 : 50;
        $tax = ($subtotal - $discount) * 0.05;
        $total = $subtotal - $discount + $shipping + $tax;
        
        $user = Auth::user();
        $customer = $user->customer;
        
        return view('frontend.checkout.index', compact(
            'cartItems', 
            'subtotal', 
            'discount', 
            'shipping', 
            'tax', 
            'total',
            'user',
            'customer'
        ));
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }
        
        DB::beginTransaction();
        
        try {
            $subtotal = $cartItems->sum(function($item) {
                $price = $item->product->sale_price ?? $item->product->price;
                return $item->quantity * $price;
            });
            
            $coupon = session()->get('coupon');
            $discount = 0;
            
            if ($coupon) {
                if ($coupon->discount_type === 'percentage') {
                    $discount = ($subtotal * $coupon->discount_value) / 100;
                } else {
                    $discount = $coupon->discount_value;
                }
                $discount = min($discount, $subtotal);
            }
            
            $shipping = $subtotal > 500 ? 0 : 50;
            $tax = ($subtotal - $discount) * 0.05;
            $grandTotal = $subtotal - $discount + $shipping + $tax;
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'SH-' . strtoupper(uniqid()) . '-' . date('Ymd'),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_charge' => $shipping,
                'tax_amount' => $tax,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_name' => Auth::user()->name,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
                'notes' => $request->notes,
            ]);
            
            // Create order items
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
                
                // Update stock
                $item->product->decrement('stock_quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }
            
            // Update coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
                
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                ]);
            }
            
            // Update customer total spent
            $customer = Customer::where('user_id', Auth::id())->first();
            if ($customer) {
                $customer->addToTotalSpent($grandTotal);
                $customer->addLoyaltyPoints(floor($grandTotal / 100) * 10);
            }
            
            // Clear cart
            Cart::where('user_id', Auth::id())->delete();
            session()->forget('coupon');
            
            DB::commit();
            
            // Redirect to payment if online
            if ($request->payment_method === 'online') {
                return redirect()->route('payment.process', $order);
            }
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Your order number is ' . $order->order_number);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}