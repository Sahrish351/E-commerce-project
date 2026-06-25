@extends('admin.layouts.app')

@section('title', 'Add Category - StyleHub Admin')

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
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
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
    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #e0e0e0;
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
    .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-plus-circle"></i> Add Category</h4>
        <p>Create a new category</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">None (Top Level)</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}">
                    @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-back" style="margin-left: 10px;">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
    // Auto-generate slug from name
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        const slugInput = document.querySelector('input[name="slug"]');
        if (!slugInput.value || slugInput.value === '') {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-');
        }
    });
</script>
@endsection