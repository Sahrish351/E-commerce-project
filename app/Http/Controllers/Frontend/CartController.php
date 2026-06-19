<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        if (Auth::check()) {
            // ✅ Get user's cart
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if ($cart) {
                // ✅ Get cart items with product details
                $cartItems = CartItem::where('cart_id', $cart->id)
                    ->with('product.images')
                    ->get();
            } else {
                $cartItems = collect([]);
            }
        } else {
            // Guest user - session se lein
            $cart = session()->get('cart', []);
            $cartItems = collect($cart)->map(function($item) {
                $product = Product::with('images')->find($item['product_id']);
                return (object)[
                    'id' => $item['product_id'],
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    'cart_id' => null,
                ];
            });
        }
        
        // Calculate subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
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
        
        return view('frontend.cart.index', compact(
            'cartItems', 
            'subtotal', 
            'discount', 
            'shipping', 
            'tax', 
            'total'
        ));
    }
    
    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
        // Check stock
        if ($product->stock_quantity < $quantity) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available!'
                ], 400);
            }
            return back()->with('error', 'Not enough stock available!');
        }
        
        if (Auth::check()) {
            // ✅ Get or create cart for user
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['total_items' => 0, 'total_price' => 0]
            );
            
            // ✅ Check if product exists in cart_items
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();
            
            if ($cartItem) {
                // Update quantity
                $cartItem->increment('quantity', $quantity);
            } else {
                // Add new item
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->sale_price ?? $product->price,
                ]);
            }
            
            // ✅ Update cart totals
            $this->updateCartTotals($cart->id);
            
            // Get cart count
            $cartCount = CartItem::where('cart_id', $cart->id)->sum('quantity');
            
        } else {
            // Guest user - session mein store karein
            $cart = session()->get('cart', []);
            
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $primaryImage = $product->images()->where('is_primary', true)->first();
                $imagePath = $primaryImage ? $primaryImage->image_path : ($product->images()->first()?->image_path ?? 'default.jpg');
                
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'name' => $product->name,
                    'price' => $product->sale_price ?? $product->price,
                    'image' => $imagePath
                ];
            }
            
            session()->put('cart', $cart);
            $cartCount = collect($cart)->sum('quantity');
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100'
        ]);
        
        if (Auth::check()) {
            // ✅ CartItem mein update karein
            $cartItem = CartItem::findOrFail($id);
            $cartItem->update(['quantity' => $request->quantity]);
            
            // Update cart totals
            $this->updateCartTotals($cartItem->cart_id);
            
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }
    
    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        if (Auth::check()) {
            // ✅ CartItem se delete karein
            $cartItem = CartItem::findOrFail($id);
            $cart_id = $cartItem->cart_id;
            $cartItem->delete();
            
            // Update cart totals
            $this->updateCartTotals($cart_id);
            
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
    
    /**
     * Apply coupon
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        
        $coupon = Coupon::where('code', strtoupper($request->code))
            ->valid()
            ->first();
        
        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code!');
        }
        
        if (!$coupon->canBeUsed()) {
            return back()->with('error', 'Coupon usage limit reached!');
        }
        
        // Calculate subtotal
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $subtotal = CartItem::where('cart_id', $cart->id)
                    ->with('product')
                    ->get()
                    ->sum(function($item) {
                        return $item->quantity * ($item->product->sale_price ?? $item->product->price);
                    });
            } else {
                $subtotal = 0;
            }
        } else {
            $cart = session()->get('cart', []);
            $subtotal = collect($cart)->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });
        }
        
        // Check minimum order value
        if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
            return back()->with('error', "Minimum order amount of ₹{$coupon->min_order_value} required!");
        }
        
        // Check user usage limit
        if (Auth::check() && !$coupon->canUserUse(Auth::user())) {
            return back()->with('error', 'You have already used this coupon maximum times!');
        }
        
        session()->put('coupon', $coupon);
        
        return back()->with('success', 'Coupon applied successfully!');
    }
    
    /**
     * Remove coupon
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed!');
    }
    
    /**
     * Get cart count for AJAX
     */
    public function getCartCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $count = $cart ? CartItem::where('cart_id', $cart->id)->sum('quantity') : 0;
        } else {
            $cart = session()->get('cart', []);
            $count = collect($cart)->sum('quantity');
        }
        
        return response()->json(['count' => $count]);
    }
    
    /**
     * Helper: Update cart totals
     */
    private function updateCartTotals($cart_id)
    {
        $cart = Cart::find($cart_id);
        if ($cart) {
            $items = CartItem::where('cart_id', $cart_id)->get();
            $total_items = $items->sum('quantity');
            $total_price = $items->sum(function($item) {
                return $item->price * $item->quantity;
            });
            
            $cart->total_items = $total_items;
            $cart->total_price = $total_price;
            $cart->save();
        }
    }
}