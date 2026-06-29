<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.images')
            ->get();
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    /**
     * ✅ ADD TO WISHLIST - SIMPLE REDIRECT
     */
    public function add($productId)
    {
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'variant_id' => null,
            ]);
            return redirect()->back()->with('success', 'Added to wishlist!');
        } else {
            return redirect()->back()->with('error', 'Already in wishlist!');
        }
    }

    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist');
    }

    public function moveToCart($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        // Add to cart logic here
        $wishlist->delete();

        return redirect()->back()->with('success', 'Moved to cart!');
    }

    /**
     * ✅ GET WISHLIST COUNT - FIXED
     */
    public function getWishlistCount()
    {
        try {
            $count = 0;
            if (Auth::check()) {
                $count = Wishlist::where('user_id', Auth::id())->count();
            }
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }
}