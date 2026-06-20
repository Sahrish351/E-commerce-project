<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends AdminController
{
    public function index(Request $request)
    {
        $query = Category::with('parent', 'children');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $categories = $query->latest()->paginate(20);
        $allCategories = Category::all();
        
        return view('admin.categories.index', compact('categories', 'allCategories'));
    }
    
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'sort_order' => 'nullable|integer'
        ]);
        
        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }
    
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);
        
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }
    
    public function destroy(Category $category)
    {
       
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with products!');
        }
        
    
        if ($category->children()->count() > 0) {
            $category->children()->update(['parent_id' => $category->parent_id]);
        }
        
        $category->delete();
        
        return back()->with('success', 'Category deleted successfully!');
    }
    
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Category status updated!');
    }
}