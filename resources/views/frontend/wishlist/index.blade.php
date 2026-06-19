@extends('layouts.app')

@section('title', 'My Wishlist - StyleHub')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Wishlist</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Wishlist Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="wishlist-header d-flex align-items-center justify-content-between flex-wrap">
                <div>
                    <h4 class="fw-bold mb-1">❤️ My Wishlist</h4>
                    <p class="text-muted small mb-0">Products you've saved for later</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                        {{ count($wishlistItems) }} Items
                    </span>
                    @if(count($wishlistItems) > 0)
                        <form action="{{ route('wishlist.move-all') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark rounded-pill px-4">
                                <i class="fas fa-shopping-bag me-2"></i> Move All to Cart
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(count($wishlistItems) > 0)
        <!-- Wishlist Products Grid -->
        <div class="row g-4">
            @foreach($wishlistItems as $item)
            @php
                $product = $item->product;
                $image = $product->images->first();
                $imageName = $image ? $image->image_url : 'default.jpg';
                $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
                $inStock = $product->stock_quantity > 0;
            @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <div class="wishlist-card">
                    <!-- Remove Button (X) -->
                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="remove-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>

                    <!-- Product Image -->
                    <div class="wishlist-image">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ asset('images/products/' . $imageName) }}" alt="{{ $product->name }}">
                        </a>
                        @if($hasDiscount)
                            <span class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                        @endif
                        @if(!$inStock)
                            <span class="stock-badge out-of-stock">Out of Stock</span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="wishlist-info">
                        <h6 class="product-name">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-dark text-decoration-none">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <div class="product-price">
                            @if($hasDiscount)
                                <span class="current-price">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Rating -->
                        <div class="product-rating">
                            @php
                                $avgRating = $product->reviews()->avg('rating') ?? 0;
                                $fullStars = floor($avgRating);
                                $hasHalfStar = $avgRating - $fullStars >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                            <span class="rating-count">({{ $product->reviews()->count() }})</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="wishlist-actions mt-3">
                            <form action="{{ route('wishlist.move-to-cart', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark w-100 rounded-pill" {{ !$inStock ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty Wishlist -->
        <div class="row">
            <div class="col-12">
                <div class="empty-wishlist text-center py-5">
                    <div class="empty-icon mb-4">
                        <i class="far fa-heart fa-5x text-muted opacity-25"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Your Wishlist is Empty</h4>
                    <p class="text-muted mb-4">Save your favorite items here and come back later.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-pill px-5 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Start Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    /* ===== WISHLIST CARD ===== */
    .wishlist-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
        height: 100%;
    }
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: #db4444;
    }

    /* Remove Button */
    .remove-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #fff;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        color: #999;
    }
    .remove-btn:hover {
        background: #db4444;
        color: #fff;
        transform: scale(1.1);
    }

    /* Wishlist Image */
    .wishlist-image {
        position: relative;
        background: #f8f9fa;
        padding: 20px;
        text-align: center;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .wishlist-image img {
        max-width: 100%;
        max-height: 180px;
        object-fit: contain;
        transition: transform 0.3s;
    }
    .wishlist-card:hover .wishlist-image img {
        transform: scale(1.02);
    }

    /* Badges */
    .discount-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #db4444;
        color: #fff;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        z-index: 2;
    }
    .stock-badge {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        z-index: 2;
    }
    .stock-badge.out-of-stock {
        background: #ff6b6b;
        color: #fff;
    }
    .stock-badge.in-stock {
        background: #51cf66;
        color: #fff;
    }

    /* Wishlist Info */
    .wishlist-info {
        padding: 16px;
    }
    .product-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .product-price {
        margin-bottom: 6px;
    }
    .current-price {
        font-size: 16px;
        font-weight: 700;
        color: #db4444;
    }
    .old-price {
        font-size: 13px;
        color: #aaa;
        text-decoration: line-through;
        margin-left: 8px;
    }
    .product-rating {
        font-size: 12px;
        color: #ffc107;
    }
    .rating-count {
        color: #999;
        margin-left: 5px;
    }

    .wishlist-actions .btn-dark {
        background: #000;
        border: none;
        padding: 10px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .wishlist-actions .btn-dark:hover {
        background: #db4444;
        transform: translateY(-2px);
    }
    .wishlist-actions .btn-dark:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    /* Empty Wishlist */
    .empty-wishlist {
        padding: 60px 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wishlist-image {
            min-height: 150px;
        }
        .wishlist-image img {
            max-height: 130px;
        }
        .wishlist-info {
            padding: 12px;
        }
        .product-name {
            font-size: 12px;
        }
        .current-price {
            font-size: 14px;
        }
    }
</style>
@endpush