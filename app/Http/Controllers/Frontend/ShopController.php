<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')
            ->where('is_active', true);
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Price Range Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Brand Filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        
        // Rating Filter
        if ($request->filled('rating')) {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->select('product_id')
                  ->groupBy('product_id')
                  ->havingRaw('AVG(rating) >= ?', [$request->rating]);
            });
        }
        
        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        // Get all categories for filter sidebar
        $categories = Category::where('is_active', true)->get();
        
        // Get unique brands for filter
        $brands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand');
        
        // Price range for filter
        $maxPrice = Product::where('is_active', true)->max('price') ?? 10000;
        
        return view('frontend.shop.index', compact(
            'products', 
            'categories', 
            'brands', 
            'maxPrice'
        ));
    }
    
    public function show($slug)
    {
        $product = Product::with('category', 'images', 'variants', 'reviews.user')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Increment view count
        $product->increment('views_count');
        
        // Related products (same category)
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        
        // Recently viewed (store in session)
        $recentlyViewed = session()->get('recently_viewed', []);
        if (!in_array($product->id, $recentlyViewed)) {
            array_unshift($recentlyViewed, $product->id);
            $recentlyViewed = array_slice($recentlyViewed, 0, 5);
            session()->put('recently_viewed', $recentlyViewed);
        }
        
        $recentProducts = Product::with('images')
            ->whereIn('id', $recentlyViewed)
            ->where('is_active', true)
            ->get();
        
        return view('frontend.shop.show', compact(
            'product', 
            'relatedProducts', 
            'recentProducts'
        ));
    }
    
    // AJAX quick view
    public function quickView($id)
    {
        $product = Product::with('images', 'variants')->findOrFail($id);
        return response()->json([
            'success' => true,
            'html' => view('frontend.shop.quick-view', compact('product'))->render()
        ]);
    }
}