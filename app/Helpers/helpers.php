<?php

// Get product image URL
if (!function_exists('getProductImage')) {
    function getProductImage($product, $size = 'medium')
    {
        if (!$product) {
            return asset('images/no-image.png');
        }
        
        $image = $product->images->where('is_primary', true)->first();
        
        if (!$image) {
            $image = $product->images->first();
        }
        
        if ($image && $image->image_path) {
            // For different sizes (if using image optimization)
            if ($size === 'thumb') {
                return asset('storage/' . str_replace('.', '_thumb.', $image->image_path));
            }
            if ($size === 'small') {
                return asset('storage/' . str_replace('.', '_small.', $image->image_path));
            }
            return asset('storage/' . $image->image_path);
        }
        
        return asset('images/no-image.png');
    }
}

// Get category image URL
if (!function_exists('getCategoryImage')) {
    function getCategoryImage($category)
    {
        if ($category && $category->image_url) {
            return asset('storage/categories/' . $category->image_url);
        }
        return asset('images/no-category.png');
    }
}

// Upload single image
if (!function_exists('uploadImage')) {
    function uploadImage($file, $folder, $oldPath = null)
    {
        // Delete old image if exists
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
        
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store in folder
        $path = $file->storeAs($folder, $filename, 'public');
        
        return $path;
    }
}

// Delete image
if (!function_exists('deleteImage')) {
    function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }
        return false;
    }
}