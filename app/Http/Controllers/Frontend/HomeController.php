<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Featured Products - ID ke hisaab se sort karo
        $featuredProducts = Product::with('images')
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();
        
        // New Arrivals
        $newArrivals = Product::with('images')
            ->where('is_active', true)
            ->latest()
            ->limit(8)
            ->get();
        
        // Top Rated Products
        $topRated = Product::with('images', 'reviews')
            ->where('is_active', true)
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(6)
            ->get();
        
        // Categories
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->limit(6)
            ->get();
        
        return view('frontend.home', compact(
            'featuredProducts', 
            'newArrivals', 
            'topRated', 
            'categories'
        ));
    }
}