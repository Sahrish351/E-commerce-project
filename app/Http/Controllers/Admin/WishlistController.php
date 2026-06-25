<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index(Request $request)
    {
        $query = Wishlist::with(['user', 'product']);

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $wishlistItems = $query->latest()->paginate(15);

        return view('admin.wishlist.index', compact('wishlistItems'));
    }

    public function destroy($id)
    {
        $item = Wishlist::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Wishlist item removed successfully!');
    }
}