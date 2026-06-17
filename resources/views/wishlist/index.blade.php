@extends('layouts.app')

@section('title', 'My Wishlist - E-Commerce Store')

@section('content')
<h1 class="mb-4">My Wishlist</h1>

@if($wishlist->count() > 0)
    <div class="row">
        @foreach($wishlist as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card product-card h-100">
                    @if($item->product->images->first())
                        <img src="{{ $item->product->images->first()->image_url }}"
                             class="card-img-top product-image" alt="{{ $item->product->name }}">
                    @else
                        <div class="card-img-top product-image bg-secondary d-flex align-items-center justify-content-center">
                            <span class="text-white">No Image</span>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $item->product->name }}</h5>
                        <p class="card-text text-muted">
                            {{ $item->product->category->name }}
                        </p>
                        <p class="card-text">
                            {{ Str::limit($item->product->short_desc, 60) }}
                        </p>
                        <p class="card-text">
                            <strong class="h5 text-primary">
                                ${{ number_format($item->product->price, 2) }}
                            </strong>
                        </p>

                        @if($item->product->isOutOfStock())
                            <span class="badge bg-danger">Out of Stock</span>
                        @elseif($item->product->isLowStock())
                            <span class="badge bg-warning">Low Stock</span>
                        @else
                            <span class="badge bg-success">In Stock</span>
                        @endif
                    </div>

                    <div class="card-footer bg-white">
                        <div class="d-grid gap-2">
                            @if(!$item->product->isOutOfStock())
                                <form action="{{ route('wishlist.toCart', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        🛒 Move to Cart
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('wishlist.remove', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    Remove
                                </button>
                            </form>
                            <a href="{{ route('products.show', $item->product) }}" class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $wishlist->links() }}
@else
    <div class="alert alert-info">
        <h4>Your wishlist is empty</h4>
        <p>Add items to your wishlist to save them for later!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
    </div>
@endif
@endsection
