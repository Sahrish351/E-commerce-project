<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ==================== PRODUCTS ====================

    public function index(Request $request)
    {
        $query = Product::with('category', 'images')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low': $query->orderBy('price', 'asc'); break;
            case 'price_high': $query->orderBy('price', 'desc'); break;
            case 'popular': $query->orderBy('sold_count', 'desc'); break;
            default: $query->latest();
        }

        $products = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category', 'images', 'variants', 'reviews.user')
            ->where('is_active', true)
            ->findOrFail($id);

        $product->increment('views_count');

        $related = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $product,
            'related_products' => $related
        ]);
    }

    public function featured()
    {
        $products = Product::with('images')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function newArrivals()
    {
        $products = Product::with('images')
            ->where('is_active', true)
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    // ==================== CATEGORIES ====================

    public function categories()
    {
        $categories = Category::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function categoryProducts($id)
    {
        $category = Category::with('products.images')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'category' => $category,
            'products' => $category->products()->paginate(15)
        ]);
    }

    // ==================== REVIEWS ====================

    public function getReviews($productId)
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->where('is_approved', true)
            ->latest()
            ->paginate(10);

        $rating = Review::where('product_id', $productId)->avg('rating') ?? 0;

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'average_rating' => round($rating, 1),
            'total_reviews' => $reviews->total()
        ]);
    }

    public function addReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        $review = Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Review submitted',
            'data' => $review
        ]);
    }
}