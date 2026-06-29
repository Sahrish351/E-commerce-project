@extends('layouts.app')

@section('title', 'Products - StyleHub')

@section('content')
<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #f0f0f0;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        border-color: #db4444;
    }
    .product-image-wrapper {
        position: relative;
        height: 220px;
        background: #f8f9fa;
        overflow: hidden;
    }
    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
        padding: 10px;
    }
    .product-card:hover .product-image-wrapper img {
        transform: scale(1.05);
    }

    /* Wishlist Button */
    .wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        color: #333;
    }
    .wishlist-btn:hover {
        background: #db4444;
        color: #fff;
        transform: scale(1.1);
    }
    .wishlist-btn.active {
        background: #db4444;
        color: #fff;
    }
    .wishlist-btn i {
        font-size: 16px;
    }

    .stock-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        padding: 3px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        z-index: 5;
    }
    .stock-badge.in-stock { background: #28a745; color: #fff; }
    .stock-badge.low-stock { background: #ffc107; color: #333; }
    .stock-badge.out-stock { background: #dc3545; color: #fff; }

    .product-info {
        padding: 16px;
    }
    .product-info .product-name {
        font-weight: 600;
        font-size: 15px;
        color: #1a1a2e;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 44px;
    }
    .product-info .product-name a {
        color: #1a1a2e;
        text-decoration: none;
    }
    .product-info .product-name a:hover {
        color: #db4444;
    }
    .product-info .product-category {
        font-size: 12px;
        color: #8c8c9c;
        margin-bottom: 6px;
    }
    .product-info .product-price {
        font-weight: 700;
        font-size: 18px;
        color: #db4444;
    }
    .product-info .product-price .old-price {
        font-weight: 400;
        font-size: 14px;
        color: #8c8c9c;
        text-decoration: line-through;
        margin-left: 8px;
    }
    .product-info .product-rating {
        font-size: 13px;
        color: #ffc107;
        margin-top: 4px;
    }
    .product-info .product-rating .count {
        color: #8c8c9c;
        font-size: 12px;
        margin-left: 4px;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 8px;
        border-radius: 30px;
        background: #1a1a2e;
        color: #fff;
        border: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 10px;
    }
    .add-to-cart-btn:hover {
        background: #db4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(219,68,68,0.25);
    }
    .add-to-cart-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Filter Sidebar */
    .filter-card {
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        background: #fff;
    }
    .filter-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px 20px;
    }
    .filter-card .card-body {
        padding: 20px;
    }

    /* Pagination */
    .pagination-custom .pagination {
        gap: 6px;
    }
    .pagination-custom .page-link {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        color: #1a1a2e;
        padding: 8px 16px;
        transition: all 0.3s;
    }
    .pagination-custom .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-custom .active .page-link {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }

    /* Toast */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast-custom {
        background: #1a1a2e;
        color: #fff;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast-custom.success { border-left: 4px solid #28a745; }
    .toast-custom.error { border-left: 4px solid #dc3545; }
    .toast-custom .close-btn {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
    }
    .toast-custom .close-btn:hover { opacity: 1; }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    @media (max-width: 768px) {
        .product-image-wrapper { height: 180px; }
    }
    @media (max-width: 576px) {
        .product-image-wrapper { height: 150px; }
        .product-info .product-name { font-size: 13px; height: 36px; }
        .product-info .product-price { font-size: 15px; }
        .add-to-cart-btn { font-size: 11px; padding: 6px; }
        .wishlist-btn { width: 30px; height: 30px; }
        .wishlist-btn i { font-size: 13px; }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<div class="container py-4">
    <div class="row">

        <!-- ===== SIDEBAR FILTERS ===== -->
        <div class="col-lg-3 mb-4">
            <div class="filter-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2" style="color:#db4444;"></i> Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                       placeholder="Search products..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select" name="category">
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
                            <label class="form-label fw-semibold">Sort By</label>
                            <select class="form-select" name="sort">
                                <option value="">Latest</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Price: Low to High</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Price: High to Low</option>
                                <option value="rating" @selected(request('sort') == 'rating')>Top Rated</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 mb-2" style="background:#db4444;">
                            <i class="fas fa-check-circle"></i> Apply Filters
                        </button>

                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-undo"></i> Clear Filters
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== PRODUCTS GRID ===== -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Products</h4>
                <p class="text-muted mb-0">{{ $products->total() }} products found</p>
            </div>

            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <!-- Image -->
                                <div class="product-image-wrapper">
                                    <img src="{{ asset($product->images->first()->image_url ?? 'images/products/default.jpg') }}"
                                         alt="{{ $product->name }}">

                                    <!-- Wishlist Button -->
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="wishlist-btn" title="Add to wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </form>

                                    <!-- Stock Badge -->
                                    @php $stock = $product->stock_quantity ?? 0; @endphp
                                    @if($stock <= 0)
                                        <span class="stock-badge out-stock">Out of Stock</span>
                                    @elseif($stock <= 5)
                                        <span class="stock-badge low-stock">Low Stock</span>
                                    @else
                                        <span class="stock-badge in-stock">In Stock</span>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="product-info">
                                    <div class="product-category">
                                        <i class="fas fa-tag"></i> {{ $product->category->name ?? 'Uncategorized' }}
                                    </div>

                                    <div class="product-name">
                                        <a href="{{ route('product.detail', $product->slug ?? $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </div>

                                    <div class="product-price">
                                        ${{ number_format($product->sale_price ?? $product->price, 2) }}
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="product-rating">
                                        @php
                                            $rating = $product->reviews_avg_rating ?? 0;
                                            $count = $product->reviews_count ?? 0;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= round($rating) ? '' : '-o' }}"></i>
                                        @endfor
                                        <span class="count">({{ $count }})</span>
                                    </div>

                                    <!-- Add to Cart -->
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="add-to-cart-btn" {{ $stock <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-custom mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5>No products found</h5>
                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        const toast = document.createElement('div');
        toast.className = `toast-custom ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <span class="close-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session("error") }}', 'error');
    @endif
</script>
@endsection