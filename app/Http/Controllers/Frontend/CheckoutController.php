<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        // ✅ Get user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        // ✅ Get cart items from cart_items table
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        // Calculate subtotal
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->sale_price ?? $item->product->price;
            return $item->quantity * $price;
        });
        
        // Apply coupon
        $coupon = session()->get('coupon');
        $discount = 0;
        
        if ($coupon) {
            if (is_array($coupon)) {
                $discountType = $coupon['discount_type'] ?? 'percentage';
                $discountValue = $coupon['discount_value'] ?? 0;
            } else {
                $discountType = $coupon->discount_type ?? 'percentage';
                $discountValue = $coupon->discount_value ?? 0;
            }
            
            if ($discountType === 'percentage') {
                $discount = ($subtotal * $discountValue) / 100;
                $discount = min($discount, $subtotal);
            } else {
                $discount = min($discountValue, $subtotal);
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
    
    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:500',
            'apartment' => 'nullable|string|max:255',
            'town_city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:cod,online,bank,card',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // ✅ Get user's cart
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return back()->with('error', 'Your cart is empty!');
        }
        
        // ✅ Get cart items from cart_items
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                $price = $item->product->sale_price ?? $item->product->price;
                return $item->quantity * $price;
            });
            
            $coupon = session()->get('coupon');
            $discount = 0;
            
            if ($coupon) {
                if (is_array($coupon)) {
                    $discountType = $coupon['discount_type'] ?? 'percentage';
                    $discountValue = $coupon['discount_value'] ?? 0;
                } else {
                    $discountType = $coupon->discount_type ?? 'percentage';
                    $discountValue = $coupon->discount_value ?? 0;
                }
                
                if ($discountType === 'percentage') {
                    $discount = ($subtotal * $discountValue) / 100;
                } else {
                    $discount = $discountValue;
                }
                $discount = min($discount, $subtotal);
            }
            
            $shipping = $subtotal > 500 ? 0 : 50;
            $tax = ($subtotal - $discount) * 0.05;
            $grandTotal = $subtotal - $discount + $shipping + $tax;
            
            // ✅ Create order
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
                'shipping_name' => $request->first_name . ' ' . ($request->company_name ?? ''),
                'shipping_address' => $request->street_address,
                'shipping_city' => $request->town_city,
                'shipping_state' => $request->shipping_state ?? '',
                'shipping_postal_code' => $request->shipping_postal_code ?? '',
                'shipping_phone' => $request->phone,
                'notes' => $request->notes,
            ]);
            
            // ✅ Create order items from cart_items
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
                if ($item->product->stock_quantity) {
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
                $item->product->increment('sold_count', $item->quantity);
            }
            
            // Update coupon usage
            if ($coupon && !is_array($coupon)) {
                $coupon->increment('used_count');
                
                // If CouponUsage model exists
                if (class_exists(CouponUsage::class)) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                    ]);
                }
            }
            
            // ✅ Update customer total spent
            $customer = Customer::where('user_id', Auth::id())->first();
            if ($customer) {
                $customer->updateTotalSpent($grandTotal);
                $customer->addLoyaltyPoints(floor($grandTotal / 100) * 10);
            }
            
            // ✅ Clear cart (delete cart and cart_items)
            $cart->items()->delete();
            $cart->delete();
            
            session()->forget('coupon');
            
            DB::commit();
            
            // ✅ STORE ORDER NUMBER IN SESSION FOR CONFIRMATION PAGE
            session()->put('order_number', $order->order_number);
            session()->put('order_id', $order->id);
            
            // ✅ REDIRECT TO CONFIRMATION PAGE
            return redirect()->route('order.confirmation')
                ->with('success', 'Your order has been placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    
    /**
     * ✅ ORDER CONFIRMATION PAGE
     */
    public function confirmation()
    {
        // Get order details from session
        $orderId = session()->get('order_id');
        $orderNumber = session()->get('order_number');
        
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'No order found!');
        }
        
        // Get order with items
        $order = Order::with('items.product')->find($orderId);
        
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found!');
        }
        
        return view('frontend.checkout.confirmation', compact('order', 'orderNumber'));
    }
}