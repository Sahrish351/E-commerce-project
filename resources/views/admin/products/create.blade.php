@extends('admin.layouts.app')

@section('title', 'Add Product - StyleHub Admin')

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
    }
    .image-preview .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-plus-circle me-2" style="color: #db4444;"></i> Add Product</h4>
        <p>Create a new product</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Sale Price</label>
                    <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" step="0.01">
                    @error('sale_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity') }}" required>
                    @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2">{{ old('short_description') }}</textarea>
                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Product Images</label>
                    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                    <small class="text-muted">You can upload multiple images (JPG, PNG, WebP)</small>
                    @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="image-preview" id="imagePreview"></div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured</label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-back" style="margin-left: 10px;">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        for (let i = 0; i < this.files.length; i++) {
            const reader = new FileReader();
            reader.onload = function() {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${reader.result}" alt="Preview">`;
                preview.appendChild(div);
            }
            reader.readAsDataURL(this.files[i]);
        }
    });
</script>
@endsection