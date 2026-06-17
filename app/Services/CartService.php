<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::with('product')->where('user_id', Auth::id())->get();
        }
        return collect(session()->get('cart', []));
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return collect(session()->get('cart', []))->sum('quantity');
    }

    public function getSubtotal()
    {
        $cartItems = $this->getCart();
        return $cartItems->sum(function ($item) {
            $price = $item->product->sale_price ?? $item->product->price;
            return $item->quantity * $price;
        });
    }
}