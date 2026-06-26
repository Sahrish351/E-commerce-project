@extends('admin.layouts.app')

@section('title', 'Edit Product - StyleHub Admin')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        padding: 28px 30px;
    }
    .form-card .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }
    .form-card .form-control,
    .form-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 14px;
        font-size: 14px;
    }
    .form-card .form-control:focus,
    .form-card .form-select:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.08);
    }
    .form-card .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
    .btn-back {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #f5f5f5;
    }
    .btn-submit {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.3);
        color: #fff;
    }
    .image-preview {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .image-preview .preview-item {
        width: 80px;
        height: 80px;
        background: #f5f5f5;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .image-preview .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .image-preview .preview-item .remove-img {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #dc3545;
        color: #fff;
        border: none;
        font-size: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .image-preview .preview-item .remove-img:hover {
        transform: scale(1.1);
    }
    .current-images {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .current-images .img-wrapper {
        width: 90px;
        height: 90px;
        background: #f5f5f5;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        padding: 6px;
    }
    .current-images .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .current-images .img-wrapper .delete-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #dc3545;
        color: #fff;
        border: 2px solid #fff;
        font-size: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .current-images .img-wrapper .delete-btn:hover {
        transform: scale(1.1);
        background: #c0392b;
    }
    .current-images .img-wrapper .primary-badge {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        background: #db4444;
        color: #fff;
        font-size: 9px;
        padding: 1px 10px;
        border-radius: 30px;
        font-weight: 600;
        white-space: nowrap;
    }
    .current-images .img-wrapper .set-primary {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 9px;
        padding: 2px 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .current-images .img-wrapper .set-primary:hover {
        background: #db4444;
    }
</style>


<div class="page-header">
    <div>
        <h4><i class="fas fa-edit me-2" style="color: #db4444;"></i> Edit Product</h4>
        <p>Update product details</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
           
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

         
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" step="0.01" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Sale Price</label>
                    <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price) }}" step="0.01">
                    @error('sale_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

        
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                    @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

       
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

          
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Current Images</label>
                    <div class="current-images">
                        @foreach($product->images as $image)
                            <div class="img-wrapper">
                                <img src="{{ asset($image->image_url) }}" alt="{{ $product->name }}">
                                @if($image->is_primary)
                                    <span class="primary-badge">Primary</span>
                                @else
                                    <button type="button" class="set-primary" onclick="setPrimaryImage({{ $image->id }})">
                                        Set Primary
                                    </button>
                                @endif
                                <button type="button" class="delete-btn" onclick="deleteImage({{ $image->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

           
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Add New Images</label>
                    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*" id="newImages">
                    <small class="text-muted">You can upload multiple images (JPG, PNG, WebP)</small>
                    @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="image-preview" id="imagePreview"></div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured</label>
                    </div>
                </div>
            </div>

           
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-back" style="margin-left: 10px;">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
   
    document.getElementById('newImages')?.addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        for (let i = 0; i < this.files.length; i++) {
            const reader = new FileReader();
            reader.onload = function() {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${reader.result}" alt="Preview">
                    <button type="button" class="remove-img" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(this.files[i]);
        }
    });

  
    function deleteImage(id) {
        if (confirm('Are you sure you want to delete this image?')) {
            fetch('/admin/products/image/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                alert('Failed to delete image');
            });
        }
    }

  
    function setPrimaryImage(id) {
        if (confirm('Set this as primary image?')) {
            fetch('/admin/products/image/' + id + '/primary', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                alert('Failed to set primary image');
            });
        }
    }
</script>
@endsection