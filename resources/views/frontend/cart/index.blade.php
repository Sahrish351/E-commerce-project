@extends('layouts.app')

@section('title', 'Cart - StyleHub')

@section('content')
<div class="container py-4">
   
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Cart</li>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($cartItems) > 0)
       
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th style="padding: 15px;">Product</th>
                                <th style="padding: 15px;">Price</th>
                                <th style="padding: 15px;">Quantity</th>
                                <th style="padding: 15px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            @php
                                $product = $item->product;
                                $price = $product->sale_price ?? $product->price;
                                $subtotal = $item->quantity * $price;
                            @endphp
                            <tr>
                                <td style="padding: 15px;">
                                    <div class="d-flex align-items-center gap-3 position-relative">
                                       
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="position-absolute" style="top: -8px; left: -8px; z-index: 10;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm p-0" style="background: transparent; border: none;">
                                                <i class="fas fa-times-circle text-danger" style="font-size: 20px; cursor: pointer; background: white; border-radius: 50%;"></i>
                                            </button>
                                        </form>
                                      
                                        @php
                                            $image = $product->images->first();
                                            $imageName = $image ? $image->image_url : 'default.jpg';
                                        @endphp
                                        <img src="{{ asset($item->product->images->first()->image_url ?? 'images/products/default.jpg') }}"
                                             alt="{{ $product->name }}" 
                                             style="width: 60px; height: 50px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
                                        <div>
                                            <span class="fw-semibold d-block">{{ $product->name }}</span>
                                            <small class="text-muted">In Stock</small>
                                        </div>
                                    </div>
                                 </td>
                                <td style="padding: 15px;" class="text-dark fw-semibold">
                                    ${{ number_format($price, 2) }}
                                 </td>
                                <td style="padding: 15px;">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                               class="form-control quantity-input" style="width: 80px; text-align: center;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                 </td>
                                <td style="padding: 15px;" class="fw-semibold text-dark">
                                    ${{ number_format($subtotal, 2) }}
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark px-4 py-2 rounded-0">
                    Return To Shop
                </a>
            </div>
            <div class="col-6 text-end">
                <button type="button" id="updateCartBtn" class="btn btn-outline-dark px-4 py-2 rounded-0">
                    Update Cart
                </button>
            </div>
        </div>

        <div class="row mt-5">
          
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <input type="text" id="couponCode" class="form-control rounded-0" placeholder="Coupon Code" style="max-width: 300px;">
                    <button onclick="applyCoupon()" class="btn btn-danger rounded-0 px-4" style="background: #db4444;">
                        Apply Coupon
                    </button>
                </div>
                @if(session()->has('coupon'))
                    <div class="mt-2">
                        <span class="badge bg-success">Coupon Applied!</span>
                        <form action="{{ route('cart.remove.coupon') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-link text-danger">Remove</button>
                        </form>
                    </div>
                @endif
            </div>

        
            <div class="col-md-6">
                <div class="cart-total" style="border: 1px solid #ddd; padding: 25px;">
                    <h4 class="fw-bold mb-4">Cart Total</h4>
                    <div class="d-flex justify-content-between mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                        <span class="text-muted">Shipping:</span>
                        <span class="fw-semibold">@if($shipping > 0) ${{ number_format($shipping, 2) }} @else Free @endif</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                        <span class="text-muted">Tax (5%):</span>
                        <span class="fw-semibold">${{ number_format($tax, 2) }}</span>
                    </div>
                    @if(isset($discount) && $discount > 0)
                    <div class="d-flex justify-content-between mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                        <span class="text-muted">Discount:</span>
                        <span class="fw-semibold text-success">-${{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-4 pt-2">
                        <span class="fw-bold fs-5">Total:</span>
                        <span class="fw-bold fs-5" style="color: #db4444;">${{ number_format($total, 2) }}</span>
                    </div>
                    @auth
    <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 rounded-0 py-3" style="background: #db4444; font-weight: 600;">
        Proceed to Checkout
    </a>
@else
    <a href="{{ route('login') }}" class="btn btn-danger w-100 rounded-0 py-3" style="background: #db4444; font-weight: 600;">
        Login to Checkout
    </a>
@endif
                </div>
            </div>
        </div>
    @else
      
        <div class="row text-center py-5">
            <div class="col-12">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h3 class="fw-bold">Your Cart is Empty</h3>
                    <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger px-5 py-2 rounded-0 mt-3" style="background: #db4444;">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    .cart-table thead tr {
        border-bottom: 1px solid #ddd;
        background: #fff;
    }
    .cart-table thead th {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        border: none;
    }
    .cart-table tbody tr {
        border-bottom: 1px solid #eee;
    }
    .cart-table tbody td {
        vertical-align: middle;
        border: none;
    }
    .quantity-input {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    .quantity-input:focus {
        border-color: #db4444;
        outline: none;
        box-shadow: none;
    }
    .cart-total {
        border-radius: 4px;
        background: #fff;
    }
    .btn-outline-dark {
        border: 1px solid #000;
        color: #000;
        background: transparent;
        transition: all 0.3s;
    }
    .btn-outline-dark:hover {
        background: #000;
        color: #fff;
    }
    .btn-danger {
        background: #db4444;
        border: none;
    }
    .btn-danger:hover {
        background: #c0392b;
    }
    .alert-success {
        background: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 4px;
    }
    .alert-danger {
        background: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        border-radius: 4px;
    }
    .fa-times-circle {
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
        transition: transform 0.2s;
    }
    .fa-times-circle:hover {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
    function applyCoupon() {
        var code = document.getElementById('couponCode').value;
        if(code) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.coupon") }}';
            form.innerHTML = '@csrf<input type="hidden" name="code" value="' + code + '">';
            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Please enter a coupon code');
        }
    }
    
    // Update all cart items
    document.getElementById('updateCartBtn')?.addEventListener('click', function() {
        var forms = document.querySelectorAll('form[action*="cart/update"]');
        if (forms.length === 0) {
            alert('No items to update');
            return;
        }
        forms.forEach(function(form) {
            form.submit();
        });
    });

    // Auto-submit on quantity change (optional)
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush