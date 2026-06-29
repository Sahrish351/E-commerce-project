<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

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
        return view('client.wishlist.index', compact('wishlistItems'));
    }

    // Same add/remove/moveToCart methods...
}