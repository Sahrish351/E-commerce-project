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
            'Joggers',
            'Casual Shoes',
            'Sports Shoes',
            'Watches', 
            'Earbuds', 
            'Sunglasses', 
            'Mobile Accessories', 
            'Power Banks', 
            'Chargers'
        ];
        
        $categories = Category::where('is_active', true)
            ->whereIn('name', $categoryNames)
            ->with('children')
            ->get()
            ->sortBy(function($category) use ($categoryNames) {
                return array_search($category->name, $categoryNames);
            })
            ->values();
        
        // ========================================
        // 1. FLASH SALES - Har category se 1 product
        // ========================================
        $featuredProducts = collect();
        $categories->each(function($category) use (&$featuredProducts) {
            $products = Product::with('images', 'category')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->inRandomOrder()
                ->limit(1)  // ← 1 product per category
                ->get();
            $featuredProducts = $featuredProducts->merge($products);
        });
        $featuredProducts = $featuredProducts->shuffle()->take(8);  // ← 8 products
        
        // Flash Sales ke product IDs store karein
        $flashProductIds = $featuredProducts->pluck('id')->toArray();
        
        // ========================================
        // 2. BEST SELLING - Flash Sales se different
        // ========================================
        $topRated = collect();
        $categories->each(function($category) use (&$topRated, $flashProductIds) {
            $product = Product::with('images', 'reviews', 'category')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->whereNotIn('id', $flashProductIds)
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->first();
            
            if ($product) {
                $topRated->push($product);
            }
        });
        
        $topRated = $topRated->shuffle()->take(4);
        $bestSellingFinalIds = $topRated->pluck('id')->toArray();
        
        // ========================================
        // 3. EXPLORE OUR PRODUCTS - Flash Sales aur Best Selling se different
        // ========================================
        $excludeIds = array_merge($flashProductIds, $bestSellingFinalIds);
        
        $newArrivals = collect();
        $categories->each(function($category) use (&$newArrivals, $excludeIds) {
            $product = Product::with('images', 'category')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->first();
            
            if ($product) {
                $newArrivals->push($product);
            }
        });

        if ($newArrivals->count() < 8) {
            $remaining = 8 - $newArrivals->count();
            $extraProducts = Product::with('images', 'category')
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->whereNotIn('id', $excludeIds)
                ->whereNotIn('id', $newArrivals->pluck('id')->toArray())
                ->inRandomOrder()
                ->limit($remaining)
                ->get();
            $newArrivals = $newArrivals->merge($extraProducts);
        }

        $newArrivals = $newArrivals->shuffle()->take(8);
        
        return view('frontend.home', compact(
            'featuredProducts', 
            'newArrivals', 
            'topRated', 
            'categories'
        ));
    }
}