<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $cart = session()->get('cart', []);
            $cartItems = collect($cart)->map(function($item) {
                $product = Product::with('images')->find($item['product_id']);
                return (object)[
                    'id' => $item['product_id'],
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id']
                ];
            });
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
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
        
        return view('frontend.cart.index', compact(
            'cartItems', 
            'subtotal', 
            'discount', 
            'shipping', 
            'tax', 
            'total'
        ));
    }
    
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
     
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
           
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();
            
            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ]);
            }
            
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
         
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
    
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100'
        ]);
        
        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
            $cartItem->update(['quantity' => $request->quantity]);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }
   
    public function remove($id)
    {
        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
            $cartItem->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
  
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
    
   
    if (Auth::check()) {
        $subtotal = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(function($item) {
                return $item->quantity * ($item->product->sale_price ?? $item->product->price);
            });
    } else {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(function($item) {
            return $item['quantity'] * $item['price'];
        });
    }
    
   
    if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
        return back()->with('error', "Minimum order amount of ₹{$coupon->min_order_value} required!");
    }
    
   
    if (Auth::check() && !$coupon->canUserUse(Auth::user())) {
        return back()->with('error', 'You have already used this coupon maximum times!');
    }
    
    session()->put('coupon', $coupon);
    
    return back()->with('success', 'Coupon applied successfully!');
}
    
  
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed!');
    }
    
    public function getCartCount()
    {
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $count = collect($cart)->sum('quantity');
        }
        
        return response()->json(['count' => $count]);
    }
}