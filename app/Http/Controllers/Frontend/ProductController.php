<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($slug)
    {
        
        $product = Product::with('category', 'images', 'reviews.user')
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Check if user has reviewed
        $userReview = null;
        if (Auth::check()) {
            $userReview = Review::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();
        }
        
        // Rating distribution
        $ratingDistribution = [
            5 => $product->reviews()->where('rating', 5)->count(),
            4 => $product->reviews()->where('rating', 4)->count(),
            3 => $product->reviews()->where('rating', 3)->count(),
            2 => $product->reviews()->where('rating', 2)->count(),
            1 => $product->reviews()->where('rating', 1)->count(),
        ];
        
        // Related products - SAME CATEGORY
        $relatedProducts = Product::with('images')
        ->where('category_id', $product->category_id)  
        ->where('id', '!=', $product->id)
        ->limit(4)
        ->get();
        
        return view('frontend.products.show', compact(
            'product', 
            'userReview', 
            'ratingDistribution',
            'relatedProducts'
        ));
    }
    
    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);
        
        $product = Product::findOrFail($id);
        
        $review = Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => true,
            ]
        );
        
        return back()->with('success', 'Review submitted successfully!');
    }
}