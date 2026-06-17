@extends('layouts.app')

@section('title', 'Products - E-Commerce Store')

@section('content')
<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-filters"></i> Filters</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Search products..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="">Latest</option>
                            <option value="price_asc" @selected(request('sort') == 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(request('sort') == 'price_desc')>Price: High to Low</option>
                            <option value="rating" @selected(request('sort') == 'rating')>Top Rated</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-check-circle"></i> Apply Filters
                    </button>
                    
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-repeat"></i> Clear Filters
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Products</h1>
            <p class="text-muted mb-0">{{ $products->total() }} products found</p>
        </div>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->image_url }}"
                                     class="card-img-top product-image" alt="{{ $product->name }}">
                            @else
                                <div class="card-img-top product-image bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                
                                @if($product->category)
                                    <p class="card-text text-muted small">
                                        <i class="bi bi-tag"></i> {{ $product->category->name }}
                                    </p>
                                @endif
                                
                                <p class="card-text">{{ Str::limit($product->short_desc, 60) }}</p>

                                <div class="mb-3">
                                    <strong class="h5 text-primary">${{ number_format($product->price, 2) }}</strong>
                                    @if($product->rating > 0)
                                        <small class="text-warning ms-2">
                                            ⭐ {{ number_format($product->rating, 1) }}/5
                                        </small>
                                    @endif
                                </div>

                                @php
                                    $stock = $product->stock ?? 0;
                                @endphp
                                
                                @if($stock <= 0)
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Out of Stock</span>
                                @elseif($stock <= 5)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> Low Stock</span>
                                @else
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> In Stock</span>
                                @endif
                            </div>

                            <div class="card-footer bg-white border-top-0">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> No products found. Try adjusting your filters.
            </div>
        @endif
    </div>
</div>
@endsection