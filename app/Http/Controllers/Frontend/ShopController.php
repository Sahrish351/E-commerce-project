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
        // Get all active categories for sidebar
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('sort_order', 'asc')
            ->get();

        // Get selected category (if any)
        $selectedCategory = null;
        if ($request->has('category') && $request->category) {
            $selectedCategory = Category::where('id', $request->category)
                ->orWhere('slug', $request->category)
                ->first();
        }

        // Get products with filters
        $query = Product::where('is_active', true);
        
        // Category filter
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory->id);
        } elseif ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // ✅ DEFAULT 5 PRODUCTS PER PAGE
        $perPage = $request->per_page ?? 5;
        $products = $query->paginate($perPage);

        // Brands for sidebar
        $brands = ['Nokia', 'Lenovo', 'Pocco', 'Samsung', 'Apple', 'Huawei', 'Xiaomi', 'OnePlus'];
        
        return view('frontend.shop.index', compact('products', 'categories', 'selectedCategory', 'brands'));
    }
}