@extends('layouts.app')

@section('title', 'Wishlist - StyleHub')

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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Wishlist Header - Exactly like picture -->
    <div class="row mb-4 align-items-center">
        <div class="col-6">
            <h2 class="fw-bold fs-2 mb-0">Wishlist ({{ count($wishlistItems) }})</h2>
        </div>
        <div class="col-6 text-end">
            @if(count($wishlistItems) > 0)
                <form action="{{ route('wishlist.move-all') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark px-4 py-2 rounded-0" style="font-size: 14px;">
                        Move All To Bag
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(count($wishlistItems) > 0)
        <!-- Wishlist Products Grid - 4 cards per row -->
        <div class="row g-4">
            @foreach($wishlistItems as $item)
            @php
                $product = $item->product;
                $image = $product->images->first();
                $imageName = $image ? $image->image_url : 'default.jpg';
                $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
            @endphp
            <div class="col-6 col-md-3">
                <div class="wishlist-card">
                    <div class="wishlist-image-wrapper position-relative">
                        <!-- Remove Icon (X) - Top Right -->
                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm p-0" style="background: transparent; border: none;">
                                <i class="fas fa-times-circle text-danger" style="font-size: 18px; cursor: pointer; background: white; border-radius: 50%;"></i>
                            </button>
                        </form>
                        <!-- Product Image -->
                        <img src="{{ asset('images/products/' . $imageName) }}" 
                             alt="{{ $product->name }}" 
                             class="wishlist-img">
                    </div>
                    <div class="wishlist-info mt-3">
                        <h6 class="fw-semibold mb-1 product-name">{{ $product->name }}</h6>
                        <div class="product-price">
                            @if($hasDiscount)
                                <span class="current-price text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="old-price text-muted text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="current-price fw-bold">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <form action="{{ route('wishlist.move-to-cart', $product->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-0 add-to-cart-wishlist" style="font-size: 14px; font-weight: 500;">
                                Add To Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty Wishlist -->
        <div class="row text-center py-5">
            <div class="col-12">
                <div class="empty-wishlist">
                    <i class="far fa-heart fa-5x text-muted mb-4"></i>
                    <h3 class="fw-bold">Your Wishlist is Empty</h3>
                    <p class="text-muted">Save your favorite items here.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger px-5 py-2 rounded-0 mt-3" style="background: #db4444;">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Just For You Section - Exactly like picture -->
    <div class="row mt-5 pt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                <h2 class="fw-bold fs-3 mb-0">Just For You</h2>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark px-4 py-2 rounded-0" style="font-size: 14px;">
                    See All
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @php
            // Get recommended products (not in wishlist)
            $wishlistIds = $wishlistItems->pluck('product_id')->toArray();
            $recommendedProducts = \App\Models\Product::where('is_active', true)
                ->whereNotIn('id', $wishlistIds)
                ->limit(4)
                ->get();
        @endphp
        
        @foreach($recommendedProducts as $product)
        @php
            $image = $product->images->first();
            $imageName = $image ? $image->image_url : 'default.jpg';
        @endphp
        <div class="col-6 col-md-3">
            <div class="recommended-card">
                <div class="recommended-image-wrapper position-relative">
                    <!-- Heart Icon for Wishlist -->
                    <a href="#" class="recommended-heart wishlist-heart" data-product-id="{{ $product->id }}">
                        <i class="far fa-heart"></i>
                    </a>
                    <img src="{{ asset('images/products/' . $imageName) }}" 
                         alt="{{ $product->name }}" 
                         class="recommended-img">
                </div>
                <div class="recommended-info mt-3 text-center">
                    <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                    <div class="product-price fw-bold">${{ number_format($product->price, 2) }}</div>
                    <div class="product-rating mt-1">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="text-muted ms-1">(65)</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Wishlist Card Styles */
    .wishlist-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
        background: #fff;
    }
    .wishlist-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .wishlist-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #f5f5f5;
    }
    .wishlist-img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        padding: 20px;
        transition: transform 0.3s;
    }
    .wishlist-card:hover .wishlist-img {
        transform: scale(1.02);
    }
    .product-name {
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .current-price {
        font-size: 16px;
    }
    .old-price {
        font-size: 12px;
    }
    .add-to-cart-wishlist {
        transition: all 0.3s;
    }
    .add-to-cart-wishlist:hover {
        background: #db4444 !important;
    }
    
    /* Recommended Card Styles */
    .recommended-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
        background: #fff;
    }
    .recommended-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .recommended-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #f5f5f5;
    }
    .recommended-img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        padding: 20px;
    }
    .recommended-heart {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
        z-index: 10;
    }
    .recommended-heart:hover {
        background: #db4444;
        color: #fff;
    }
    .recommended-info h6 {
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Remove Icon Hover */
    .fa-times-circle {
        transition: transform 0.2s;
    }
    .fa-times-circle:hover {
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .wishlist-img {
            height: 150px;
        }
        .recommended-img {
            height: 130px;
        }
        .product-name, .recommended-info h6 {
            font-size: 12px;
        }
        .current-price {
            font-size: 14px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Wishlist Heart Toggle for Just For You section
    $(document).ready(function() {
        $('.wishlist-heart').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var $icon = $(this).find('i');
            
            $.ajax({
                url: '{{ route("wishlist.add") }}/' + productId,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success) {
                        if(response.action === 'added') {
                            $icon.removeClass('far').addClass('fas');
                            $icon.css('color', '#db4444');
                            // Update wishlist count in navbar
                            $.get('{{ route("wishlist.count") }}', function(data) {
                                $('#wishlistCount').text(data.count);
                            });
                        } else {
                            $icon.removeClass('fas').addClass('far');
                            $icon.css('color', '#333');
                        }
                    }
                }
            });
        });
    });
</script>
@endpush