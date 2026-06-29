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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
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

    public function payment(Request $request)
    {
        $billing = session()->get('billing_details');
        
        if (!$billing) {
            return redirect()->route('checkout.index')->with('error', 'Please fill billing details first!');
        }
        
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();
        
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
                $discount = min($discount, $subtotal);
            } else {
                $discount = min($discountValue, $subtotal);
            }
        }
        
        $shipping = $subtotal > 500 ? 0 : 50;
        $tax = ($subtotal - $discount) * 0.05;
        $total = $subtotal - $discount + $shipping + $tax;
        
        return view('frontend.checkout.payment', compact(
            'subtotal', 'discount', 'shipping', 'tax', 'total',
            'billing'
        ));
    }

    public function storeBilling(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'town_city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        
        session()->put('billing_details', [
            'first_name' => $request->first_name,
            'street_address' => $request->street_address,
            'town_city' => $request->town_city,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        
        return redirect()->route('checkout.payment');
    }

    public function placeOrder(Request $request)
{
    // ✅ DYNAMIC VALIDATION - COD ke liye koi extra validation nahi
    $rules = [
        'payment_method' => 'required|in:cod,bank,card',
    ];
    
    if ($request->payment_method === 'bank') {
        $rules['payment_receipt'] = 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120';
    }
    
    if ($request->payment_method === 'card') {
        $rules['card_number'] = 'required|string|max:19';
        $rules['card_expiry'] = 'required|string|max:7';
        $rules['card_cvv'] = 'required|string|max:4';
        $rules['card_name'] = 'required|string|max:255';
    }
    
    $request->validate($rules);
    
    $billing = session()->get('billing_details');
    
    if (!$billing) {
        return redirect()->route('checkout.index')->with('error', 'Please fill billing details first!');
    }
    
    $cart = Cart::where('user_id', Auth::id())->first();
    
    if (!$cart) {
        return back()->with('error', 'Your cart is empty!');
    }
    
    $cartItems = CartItem::where('cart_id', $cart->id)
        ->with('product')
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
        
        // ✅ Upload Receipt (Bank Transfer)
        $receiptPath = null;
        if ($request->payment_method === 'bank' && $request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('payment_receipts', 'public');
        }
        
        // ✅ Card Payment - Masked Info
        $cardLast4 = null;
        $cardType = null;
        if ($request->payment_method === 'card' && $request->filled('card_number')) {
            $cardNumber = preg_replace('/\s+/', '', $request->card_number);
            $cardLast4 = substr($cardNumber, -4);
            $firstDigit = substr($cardNumber, 0, 1);
            if ($firstDigit == '4') $cardType = 'Visa';
            elseif ($firstDigit == '5') $cardType = 'Mastercard';
            elseif ($firstDigit == '3') $cardType = 'Amex';
            else $cardType = 'Card';
        }
        
        // ✅ CREATE ORDER
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'SH-' . strtoupper(uniqid()) . '-' . date('Ymd'),
            'first_name' => $billing['first_name'],
            'email' => $billing['email'],
            'phone' => $billing['phone'],
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'shipping_cost' => $shipping,
            'tax_amount' => $tax,
            'total_amount' => $grandTotal,
            'grand_total' => $grandTotal,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'payment_receipt' => $receiptPath,
            'card_last4' => $cardLast4,
            'card_type' => $cardType,
            'status' => 'pending',
            'shipping_address' => json_encode([
                'address' => $billing['street_address'],
                'city' => $billing['town_city'],
                'phone' => $billing['phone'],
                'name' => $billing['first_name'],
            ]),
            'shipping_name' => $billing['first_name'],
            'shipping_city' => $billing['town_city'],
            'shipping_phone' => $billing['phone'],
            'notes' => $request->notes,
        ]);
        
        // ✅ CREATE ORDER ITEMS
        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $subtotalPrice = $item->quantity * $price;
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => null,
                'product_name' => $item->product->name,
                'sku' => $item->product->sku ?? 'N/A',
                'quantity' => $item->quantity,
                'unit_price' => $price,
                'total_price' => $subtotalPrice,
            ]);
            
            if ($item->product->stock_quantity) {
                $item->product->decrement('stock_quantity', $item->quantity);
            }
            if (isset($item->product->sold_count)) {
                $item->product->increment('sold_count', $item->quantity);
            }
        }
        
        $cart->items()->delete();
        $cart->delete();
        session()->forget('coupon');
        session()->forget('billing_details');
        
        DB::commit();
        
        session()->put('order_number', $order->order_number);
        session()->put('order_id', $order->id);
        
        return redirect()->route('order.confirmation')
            ->with('success', 'Your order has been placed successfully!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}

    public function confirmation()
    {
        $orderId = session()->get('order_id');
        $orderNumber = session()->get('order_number');
        
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'No order found!');
        }
        
        $order = Order::with('items.product')->find($orderId);
        
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found!');
        }
        
        return view('frontend.checkout.confirmation', compact('order', 'orderNumber'));
    }
}