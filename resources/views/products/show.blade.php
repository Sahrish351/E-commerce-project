@extends('layouts.app')

@section('title', $product->name . ' - E-Commerce Store')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row">
    <!-- Product Images -->
    <div class="col-md-5 mb-4">
        @if($product->images->first())
            <img src="{{ $product->images->first()->image_url }}" class="img-fluid rounded" alt="{{ $product->name }}" id="mainImage">
            @if($product->images->count() > 1)
                <div class="mt-3 d-flex gap-2">
                    @foreach($product->images as $image)
                        <img src="{{ $image->image_url }}" class="img-thumbnail cursor-pointer" alt="{{ $product->name }}"
                             onclick="document.getElementById('mainImage').src='{{ $image->image_url }}'" style="cursor: pointer; width: 80px; height: 80px; object-fit: cover;">
                    @endforeach
                </div>
            @endif
        @else
            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                <span class="text-white">No Image Available</span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="col-md-7">
        <h1>{{ $product->name }}</h1>
        <p class="text-muted">SKU: {{ $product->sku }}</p>

        <!-- Rating -->
        @if($product->rating > 0)
            <div class="mb-3">
                <span class="text-warning">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $product->rating)
                            ⭐
                        @else
                            ☆
                        @endif
                    @endfor
                </span>
                <span class="ms-2">{{ number_format($product->rating, 1) }}/5 ({{ $product->reviews()->where('is_approved', true)->count() }} reviews)</span>
            </div>
        @endif

        <!-- Price -->
        <div class="mb-4">
            <h2 class="text-primary">${{ number_format($product->price, 2) }}</h2>
            @if($product->cost_price)
                <p class="text-muted">
                    <span class="text-decoration-line-through">${{ number_format($product->cost_price, 2) }}</span>
                </p>
            @endif
        </div>

        <!-- Stock Status -->
        <div class="mb-4">
            @if($product->isOutOfStock())
                <span class="badge bg-danger" style="font-size: 1rem;">Out of Stock</span>
            @elseif($product->isLowStock())
                <span class="badge bg-warning" style="font-size: 1rem;">Low Stock ({{ $product->stock_quantity }} left)</span>
            @else
                <span class="badge bg-success" style="font-size: 1rem;">In Stock</span>
            @endif
        </div>

        <!-- Add to Cart -->
        @auth
            <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($product->variants->count() > 0)
                    <div class="mb-3">
                        <label for="variant" class="form-label">Choose Variant</label>
                        <select class="form-select" id="variant" name="variant_id">
                            <option value="">Select a variant</option>
                            @foreach($product->variants->where('is_active', true) as $variant)
                                <option value="{{ $variant->id }}">
                                    {{ $variant->name }} (+${{ number_format($variant->price_modifier, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $product->stock_quantity }}" value="1">
                </div>

                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary btn-lg" @disabled($product->isOutOfStock())>
                        🛒 Add to Cart
                    </button>
                    <form action="{{ route('wishlist.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-danger">
                            ❤️ Add to Wishlist
                        </button>
                    </form>
                </div>
            </form>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Login</a> to add items to cart or wishlist
            </div>
        @endauth

        <!-- Description -->
        <div class="mt-4">
            <h4>Description</h4>
            <p>{{ $product->description }}</p>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
    <hr class="my-5">
    <section>
        <h3 class="mb-4">Related Products</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card product-card h-100">
                        @if($related->images->first())
                            <img src="{{ $related->images->first()->image_url }}" class="card-img-top product-image" alt="{{ $related->name }}">
                        @else
                            <div class="card-img-top product-image bg-secondary d-flex align-items-center justify-content-center">
                                <span class="text-white">No Image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $related->name }}</h5>
                            <p class="card-text"><strong>${{ number_format($related->price, 2) }}</strong></p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('products.show', $related) }}" class="btn btn-sm btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

<!-- Reviews Section -->
<hr class="my-5">
<section>
    <h3 class="mb-4">Customer Reviews</h3>

    @auth
        @if(!$userReview)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Write a Review</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store', $product) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="">Select rating</option>
                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                <option value="4">⭐⭐⭐⭐ Very Good</option>
                                <option value="3">⭐⭐⭐ Good</option>
                                <option value="2">⭐⭐ Fair</option>
                                <option value="1">⭐ Poor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Review</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}">Login</a> to write a review
        </div>
    @endauth

    @if($reviews->count() > 0)
        <div class="row">
            @foreach($reviews as $review)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $review->title }}</h5>
                                    <p class="text-muted mb-2">
                                        <strong>{{ $review->user->name }}</strong> -
                                        <span class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)⭐ @else ☆ @endif
                                            @endfor
                                        </span>
                                    </p>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="card-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $reviews->links() }}
    @else
        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
    @endif
</section>
@endsection
