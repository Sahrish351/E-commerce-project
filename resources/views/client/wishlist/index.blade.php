@extends('client.layouts.app')

@section('title', 'My Wishlist')

@section('content')
<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header-custom h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header-custom h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header-custom p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }
    .page-header-custom .badge-total {
        background: #db4444;
        color: #fff;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        position: relative;
    }
    .product-card:hover {
        border-color: #db4444;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }

    .product-card .image-wrapper {
        position: relative;
        height: 200px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        overflow: hidden;
    }
    .product-card .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.4s;
    }
    .product-card:hover .image-wrapper img {
        transform: scale(1.08);
    }

    .product-card .image-wrapper .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #999;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        z-index: 5;
    }
    .product-card .image-wrapper .remove-btn:hover {
        background: #dc3545;
        color: #fff;
        border-color: #dc3545;
        transform: scale(1.1);
    }

    .product-card .image-wrapper .badge-stock {
        position: absolute;
        bottom: 10px;
        left: 10px;
        padding: 3px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        background: #28a745;
        color: #fff;
        z-index: 5;
    }
    .product-card .image-wrapper .badge-stock.out {
        background: #dc3545;
    }

    .product-card .product-info {
        padding: 14px 16px 16px;
    }
    .product-card .product-info .product-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a2e;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 40px;
    }
    .product-card .product-info .product-name a {
        color: #1a1a2e;
        text-decoration: none;
    }
    .product-card .product-info .product-name a:hover {
        color: #db4444;
    }

    .product-card .product-info .product-price {
        font-weight: 700;
        font-size: 18px;
        color: #db4444;
    }
    .product-card .product-info .product-price .old-price {
        font-weight: 400;
        font-size: 13px;
        color: #8c8c9c;
        text-decoration: line-through;
        margin-left: 8px;
    }

    .product-card .product-info .product-rating {
        font-size: 13px;
        color: #ffc107;
        margin-top: 4px;
    }
    .product-card .product-info .product-rating .count {
        color: #8c8c9c;
        font-size: 12px;
        margin-left: 4px;
    }

    .product-card .product-info .add-to-cart-btn {
        width: 100%;
        margin-top: 12px;
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
    }
    .product-card .product-info .add-to-cart-btn:hover {
        background: #db4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(219,68,68,0.25);
    }
    .product-card .product-info .add-to-cart-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    .empty-wishlist {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .empty-wishlist .icon-wrap {
        width: 80px;
        height: 80px;
        background: #fce4ec;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-wishlist .icon-wrap i {
        font-size: 36px;
        color: #db4444;
    }
    .empty-wishlist h5 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .empty-wishlist p {
        color: #8c8c9c;
        font-size: 14px;
    }
    .empty-wishlist .btn-shop {
        background: #db4444;
        color: #fff;
        padding: 10px 40px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        margin-top: 12px;
        border: none;
    }
    .empty-wishlist .btn-shop:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
    }

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

    @media (max-width: 1200px) {
        .wishlist-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 992px) {
        .wishlist-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .wishlist-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .product-card .image-wrapper { height: 140px; }
        .product-card .product-info { padding: 10px 12px 12px; }
        .product-card .product-info .product-name { font-size: 12px; height: 32px; }
        .product-card .product-info .product-price { font-size: 15px; }
        .product-card .product-info .add-to-cart-btn { font-size: 11px; padding: 6px; }
        .page-header-custom h4 { font-size: 18px; }
        .product-card .image-wrapper .remove-btn { width: 26px; height: 26px; font-size: 12px; top: 6px; right: 6px; }
    }
    @media (max-width: 400px) {
        .wishlist-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
        .product-card .image-wrapper { height: 120px; }
        .product-card .product-info .product-name { font-size: 11px; height: 28px; }
        .product-card .product-info .product-price { font-size: 13px; }
        .product-card .product-info .add-to-cart-btn { font-size: 10px; padding: 5px; }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header-custom">
    <div>
        <h4><i class="fas fa-heart"></i> My Wishlist</h4>
        <p>Products you've saved for later</p>
    </div>
    <span class="badge-total">
        <i class="fas fa-heart"></i> {{ $wishlistItems->count() }} Items
    </span>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($wishlistItems->count() > 0)
<div class="wishlist-grid">
    @foreach($wishlistItems as $item)
    <div class="product-card" id="wishlist-item-{{ $item->product_id }}">
        <div class="image-wrapper">
            <img src="{{ asset($item->product->images->first()->image_url ?? 'images/products/default.jpg') }}" 
                 alt="{{ $item->product->name }}">
            
            <button onclick="removeFromWishlist('{{ $item->product_id }}')" class="remove-btn" title="Remove from wishlist">
                <i class="fas fa-times"></i>
            </button>

            @if(($item->product->stock_quantity ?? 0) > 0)
                <span class="badge-stock">In Stock</span>
            @else
                <span class="badge-stock out">Out of Stock</span>
            @endif
        </div>

        <div class="product-info">
            <div class="product-name">
                <a href="{{ route('product.detail', $item->product->slug ?? $item->product->id) }}">
                    {{ $item->product->name }}
                </a>
            </div>

            <div class="product-price">
                ${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}
                @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                    <span class="old-price">${{ number_format($item->product->price, 2) }}</span>
                @endif
            </div>

            <div class="product-rating">
                @php
                    $rating = $item->product->reviews_avg_rating ?? 0;
                    $count = $item->product->reviews_count ?? 0;
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= round($rating) ? '' : '-o' }}"></i>
                @endfor
                <span class="count">({{ $count }})</span>
            </div>

            <form action="{{ route('client.wishlist.move-to-cart', $item->product_id) }}" method="POST">
                @csrf
                <button type="submit" class="add-to-cart-btn" 
                        {{ ($item->product->stock_quantity ?? 0) <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<!-- ===== EMPTY STATE ===== -->
<div class="empty-wishlist">
    <div class="icon-wrap">
        <i class="fas fa-heart"></i>
    </div>
    <h5>Your Wishlist is Empty</h5>
    <p>Save your favorite items here and come back later.</p>
    <a href="{{ route('shop.index') }}" class="btn-shop">
        <i class="fas fa-store me-2"></i> Start Shopping
    </a>
</div>
@endif

<script>
    function removeFromWishlist(productId) {
        if (confirm('Are you sure you want to remove this item from wishlist?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("client.wishlist.remove", ":id") }}'.replace(':id', productId);
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
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