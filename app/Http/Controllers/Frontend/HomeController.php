<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // SPECIFIC ORDER - Is sequence mein categories show hon
        $categoryNames = [
            'Shoes', 
            'Watches', 
            'Earbuds', 
            'Sunglasses', 
            'Mobile Accessories', 
            'Power Banks', 
            'Chargers',
            'Electronics'
        ];
        
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->whereIn('name', $categoryNames)
            ->with('children')
            ->get()
            ->sortBy(function($category) use ($categoryNames) {
                return array_search($category->name, $categoryNames);
            })
            ->values();
        
        // Flash Sales - Get 2 products from each category for variety
        $featuredProducts = collect();
        $categories->each(function($category) use (&$featuredProducts) {
            $products = Product::with('images', 'category')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->inRandomOrder()
                ->limit(2)
                ->get();
            $featuredProducts = $featuredProducts->merge($products);
        });
        $featuredProducts = $featuredProducts->shuffle()->take(12);
        
        // New Arrivals - Latest 8 products
        $newArrivals = Product::with('images', 'category')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->limit(8)
            ->get();
        
        // Best Selling - Top rated products
        $topRated = Product::with('images', 'reviews', 'category')
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(4)
            ->get();
        
        return view('frontend.home', compact(
            'featuredProducts', 
            'newArrivals', 
            'topRated', 
            'categories'
        ));
    }
}