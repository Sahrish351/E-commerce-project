@extends('layouts.app')

@section('title', $product->name . ' - StyleHub')

@section('content')
<div class="container py-4">
    
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-dark">Shop</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('shop.index', ['category' => $product->category->id]) }}" class="text-decoration-none text-dark">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-5">
       
        <!-- Gallery -->
        <div class="col-md-6">
            <div class="product-gallery">
                <!-- Main Image -->
                <div style="background: #f5f5f5; border-radius: 8px; padding: 20px; text-align: center; height: 400px; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
                    @php
                        $mainImage = $product->images->first();
                    @endphp
                    <img src="{{ $mainImage ? asset($mainImage->image_url) : asset('images/products/default.jpg') }}" 
                         alt="{{ $product->name }}" 
                         id="mainProductImage"
                         style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                
                <!-- Thumbnails -->
                @if($product->images->count() > 0)
                <div class="d-flex gap-2 mt-3" style="overflow-x: auto; padding-bottom: 5px;">
                    @foreach($product->images as $image)
                    <div style="width: 80px; height: 80px; background: #f5f5f5; border-radius: 4px; padding: 5px; flex-shrink: 0; cursor: pointer; border: 2px solid {{ $loop->first ? '#db4444' : 'transparent' }}; transition: all 0.3s;" 
                         onclick="changeMainImage(this, '{{ asset($image->image_url) }}')">
                        <img src="{{ asset($image->image_url) }}" 
                             alt="{{ $product->name }}" 
                             style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
           
            @if($product->category)
                <span style="font-size: 13px; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $product->category->name }}
                </span>
            @endif
            
            <h1 class="fw-bold mt-1" style="font-size: 28px;">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="d-flex align-items-center gap-2 mt-2">
                <span>
                    @php
                        $rating = $product->reviews_avg_rating ?? 0;
                        $count = $product->reviews_count ?? 0;
                        $fullStars = (int)floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                    @endphp
                    @for($i = 1; $i <= $fullStars; $i++)
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                    @endfor
                    @if($halfStar)
                        <i class="fas fa-star-half-alt" style="color: #ffb800;"></i>
                    @endif
                    @for($i = 1; $i <= $emptyStars; $i++)
                        <i class="far fa-star" style="color: #ddd;"></i>
                    @endfor
                </span>
                <span style="font-weight: 600;">{{ number_format($rating, 1) }}</span>
                <span class="text-muted">|</span>
                <span class="text-muted">{{ $count }} reviews</span>
                <span class="text-muted">|</span>
                <span style="color: #28a745;">{{ number_format($product->sold_count ?? 0) }} sold</span>
            </div>
            
            <!-- Price -->
            <div class="d-flex align-items-center gap-3 mt-3">
                <span class="fw-bold" style="color: #db4444; font-size: 28px;">
                    ${{ number_format($product->sale_price ?? $product->price, 2) }}
                </span>
                @if($product->sale_price && $product->price > $product->sale_price)
                <span style="text-decoration: line-through; color: #999; font-size: 20px;">
                    ${{ number_format($product->price, 2) }}
                </span>
                <span style="background: #db4444; color: #fff; padding: 2px 12px; border-radius: 30px; font-size: 14px; font-weight: 600;">
                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                </span>
                @endif
            </div>
            
            <!-- Stock -->
            <div class="mt-3">
                @if($product->stock_quantity > 0)
                    <span style="color: #28a745; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock_quantity }} available)
                    </span>
                @else
                    <span style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-times-circle"></i> Out of Stock
                    </span>
                @endif
            </div>
            
            <!-- Description -->
            <div class="mt-3">
                <p style="color: #666; line-height: 1.8;">
                    {{ $product->short_description ?? $product->description ?? 'No description available.' }}
                </p>
            </div>
            
            <!-- Action Buttons -->
            @if($product->stock_quantity > 0)
            <div class="d-flex gap-3 mt-4 flex-wrap">
                <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2 align-items-center">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden; display: flex;">
                        <button type="button" class="btn btn-light btn-sm rounded-0" onclick="decrementQty()" style="border: none; padding: 8px 12px;">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ $product->stock_quantity }}" 
                               style="width: 50px; border: none; text-align: center; padding: 8px 0; outline: none;">
                        <button type="button" class="btn btn-light btn-sm rounded-0" onclick="incrementQty()" style="border: none; padding: 8px 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-danger rounded-0 px-5 py-2" style="background: #db4444; font-weight: 600;">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </form>
                
                <!-- ✅ WISHLIST BUTTON - FIXED -->
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark rounded-0 px-4" style="border-color: #ddd; transition: all 0.3s;">
                        <i class="far fa-heart"></i>
                    </button>
                </form>
            </div>
            @endif
            
            <!-- Meta -->
            <div class="mt-4 pt-3" style="border-top: 1px solid #eee;">
                <p style="font-size: 14px; color: #666; margin-bottom: 5px;">
                    <strong>Category:</strong> 
                    @if($product->category)
                        <a href="{{ route('shop.index', ['category' => $product->category->id]) }}" class="text-decoration-none text-dark">
                            {{ $product->category->name }}
                        </a>
                    @else
                        Uncategorized
                    @endif
                </p>
                <p style="font-size: 14px; color: #666; margin-bottom: 0;">
                    <strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- ===== RELATED PRODUCTS ===== -->
    @if($relatedProducts && $relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Related Products</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-card" style="border: 1px solid #eee; padding: 15px; text-align: center; background: #fff; border-radius: 8px; height: 100%; transition: all 0.3s;">
                        @php
                            $relImage = $related->images->first();
                        @endphp
                        <div style="height: 150px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; border-radius: 4px;">
                            <img src="{{ $relImage ? asset($relImage->image_url) : asset('images/products/default.jpg') }}" 
                                 alt="{{ $related->name }}" 
                                 style="max-width: 100%; max-height: 140px; object-fit: contain;">
                        </div>
                        <h6 class="fw-semibold" style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px;">
                            {{ $related->name }}
                        </h6>
                        <p class="fw-bold" style="color: #db4444; font-size: 16px;">
                            ${{ number_format($related->sale_price ?? $related->price, 2) }}
                        </p>
                        <a href="{{ route('product.detail', $related->slug ?? $related->id) }}" class="btn btn-dark btn-sm rounded-0 w-100" style="background: #000;">
                            View Product
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- ===== REVIEWS SECTION ===== -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Reviews ({{ $product->reviews->count() ?? 0 }})</h3>
            
            @if(Auth::check())
                <!-- Review Form -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h5 class="fw-bold mb-3">Write a Review</h5>
                    <form action="{{ route('product.review', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating</label>
                            <div class="d-flex gap-2" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-value="{{ $i }}" style="border: none; font-size: 24px; padding: 0 5px;">
                                        <i class="far fa-star" style="color: #ffb800;"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comment</label>
                            <textarea name="comment" class="form-control rounded-0" rows="4" placeholder="Share your experience with this product..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger rounded-0 px-4" style="background: #db4444;">
                            Submit Review
                        </button>
                    </form>
                </div>
            @else
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <p class="mb-0">Please <a href="{{ route('login') }}" class="text-danger">login</a> to write a review.</p>
                </div>
            @endif
            
            <!-- Reviews List -->
            @if($product->reviews->count() > 0)
                @foreach($product->reviews as $review)
                <div style="border-bottom: 1px solid #eee; padding: 15px 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">{{ $review->user->name ?? 'Anonymous' }}</span>
                            <span style="font-size: 13px; color: #999; margin-left: 10px;">
                                {{ $review->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star" style="color: #ffb800;"></i>
                                @else
                                    <i class="far fa-star" style="color: #ddd;"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p style="color: #666; margin-top: 8px;">{{ $review->comment }}</p>
                </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 30px; color: #999;">
                    <i class="fas fa-comment" style="font-size: 36px; margin-bottom: 10px;"></i>
                    <p>No reviews yet. Be the first to review this product!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .product-gallery .thumbnails img:hover {
        border-color: #db4444;
    }
    #starRating button {
        transition: all 0.2s;
    }
    #starRating button:hover {
        transform: scale(1.1);
    }
    .product-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .btn-outline-dark:hover {
        background: #000;
        color: #fff;
    }
</style>

<script>
    // ========================================
    // QUANTITY INCREMENT/DECREMENT
    // ========================================
    function incrementQty() {
        const input = document.getElementById('qtyInput');
        const max = parseInt(input.getAttribute('max') || 999);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decrementQty() {
        const input = document.getElementById('qtyInput');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // ========================================
    // CHANGE MAIN IMAGE
    // ========================================
    function changeMainImage(element, imageUrl) {
        document.querySelectorAll('.product-gallery .d-flex .gap-2 div').forEach(el => {
            el.style.borderColor = 'transparent';
        });
        element.style.borderColor = '#db4444';
        document.getElementById('mainProductImage').src = imageUrl;
    }

    // ========================================
    // STAR RATING
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating button');
        const ratingInput = document.getElementById('ratingInput');
        let selectedRating = 0;
        
        stars.forEach((star) => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.value);
                ratingInput.value = selectedRating;
                
                stars.forEach((s, index) => {
                    if (index < selectedRating) {
                        s.querySelector('i').className = 'fas fa-star';
                        s.style.color = '#ffb800';
                    } else {
                        s.querySelector('i').className = 'far fa-star';
                        s.style.color = '#ffb800';
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.querySelector('i').className = 'fas fa-star';
                        s.style.color = '#ffb800';
                    } else {
                        s.querySelector('i').className = 'far fa-star';
                        s.style.color = '#ffb800';
                    }
                });
            });
            
            star.addEventListener('mouseleave', function() {
                stars.forEach((s, index) => {
                    if (index < selectedRating) {
                        s.querySelector('i').className = 'fas fa-star';
                        s.style.color = '#ffb800';
                    } else {
                        s.querySelector('i').className = 'far fa-star';
                        s.style.color = '#ffb800';
                    }
                });
            });
        });
    });
</script>

@endsection