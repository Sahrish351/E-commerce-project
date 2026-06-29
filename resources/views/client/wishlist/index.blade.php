@extends('client.layouts.app')

@section('title', 'Wishlist')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0"><i class="fas fa-heart text-danger me-2"></i> Wishlist</h5>
    </div>
    <div class="card-body">
        @forelse($wishlistItems as $item)
        <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0"><strong>{{ $item->product->name }}</strong></p>
                <p class="mb-0" style="color:#999;">${{ number_format($item->product->price, 2) }}</p>
            </div>
            <form action="{{ route('wishlist.remove', $item->product_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </form>
        </div>
        @empty
        <div class="text-center py-4">
            <i class="fas fa-heart" style="font-size:40px; color:#ddd; display:block; margin-bottom:10px;"></i>
            <p class="text-muted">Your wishlist is empty</p>
            <a href="{{ route('shop.index') }}" class="btn btn-danger">Start Shopping</a>
        </div>
        @endforelse
    </div>
</div>
@endsection