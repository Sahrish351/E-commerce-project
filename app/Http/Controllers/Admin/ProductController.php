<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends AdminController
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images');
        
      
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
       
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
       
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
       
        if ($request->filled('stock')) {
            if ($request->stock === 'out') {
                $query->where('stock_quantity', 0);
            } elseif ($request->stock === 'low') {
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 5);
            }
        }
        
     
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $products = $query->latest()->paginate(15);
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        DB::beginTransaction();
        
        try {
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock_quantity' => $request->stock_quantity,
                'sku' => $request->sku ?? 'SKU-' . strtoupper(uniqid()),
                'description' => $request->description,
                'short_description' => $request->short_description,
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
            ]);
            
        
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => 'storage/' . $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        
        try {
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock_quantity' => $request->stock_quantity,
                'sku' => $request->sku,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
            ]);
            
            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => 'storage/' . $path,
                        'is_primary' => false,
                        'sort_order' => $product->images()->count()
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

   
    public function show($id)
    {
        $product = Product::with('category', 'images')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        
        try {
            foreach ($product->images as $image) {
                $path = str_replace('storage/', '', $image->image_url);
                Storage::disk('public')->delete($path);
                $image->delete();
            }
            $product->delete();
            
            DB::commit();
            
            return back()->with('success', 'Product deleted successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product!');
        }
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $path = str_replace('storage/', '', $image->image_url);
        Storage::disk('public')->delete($path);
        $image->delete();
        
        return response()->json(['success' => true]);
    }

    public function setPrimaryImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        
        return response()->json(['success' => true]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);
        
        $product->update(['stock_quantity' => $request->stock_quantity]);
        
        return response()->json(['success' => true, 'stock' => $product->stock_quantity]);
    }
}