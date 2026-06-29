@extends('layouts.app')

@section('title', 'Checkout - StyleHub')

@section('content')
<style>
    .checkout-wrap {
        padding: 30px 0;
    }
    .checkout-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px 35px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 30px rgba(0,0,0,0.04);
    }
    .checkout-card .card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 2px solid #f0f0f0;
    }
    .checkout-card .card-title i {
        color: #db4444;
        margin-right: 10px;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        background: #f8f9fa !important;
        border: 1.5px solid #e8e8e8 !important;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #db4444 !important;
        box-shadow: 0 0 0 3px rgba(219, 68, 68, 0.08);
        background: #fff !important;
    }
    .form-control::placeholder {
        color: #aaa;
        font-weight: 400;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .form-label .required {
        color: #db4444;
        margin-left: 2px;
    }
    .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
    .form-check-input:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }
    .form-check-label {
        font-size: 14px;
        color: #555;
    }

    .order-summary-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 24px;
        margin-top: 55px;
        border: 1px solid #f0f0f0;
    }
    .order-summary-box .summary-title {
        font-weight: 700;
        font-size: 18px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e8e8e8;
    }
    .order-summary-box .item-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .order-summary-box .item-row:last-child {
        border-bottom: none;
    }
    .order-summary-box .item-row .name {
        color: #333;
        font-weight: 500;
    }
    .order-summary-box .item-row .name small {
        color: #999;
        font-weight: 400;
        margin-left: 4px;
    }
    .order-summary-box .item-row .price {
        font-weight: 600;
        color: #1a1a2e;
    }
    .order-summary-box .total-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0 0;
        margin-top: 8px;
        border-top: 2px solid #e0e0e0;
        font-size: 16px;
    }
    .order-summary-box .total-row .label {
        font-weight: 700;
        color: #1a1a2e;
    }
    .order-summary-box .total-row .value {
        font-weight: 700;
        color: #db4444;
        font-size: 18px;
    }

    .btn-proceed {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s;
        margin-top: 16px;
    }
    .btn-proceed:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219, 68, 68, 0.25);
    }
    .btn-proceed i {
        margin-right: 8px;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-cart i {
        font-size: 56px;
        color: #ddd;
        display: block;
        margin-bottom: 16px;
    }
    .empty-cart h3 {
        font-weight: 700;
        color: #1a1a2e;
    }
    .empty-cart p {
        color: #8c8c9c;
        font-size: 14px;
    }
    .empty-cart .btn-shop {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 40px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-top: 12px;
    }
    .empty-cart .btn-shop:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
    }

    @media (max-width: 992px) {
        .order-summary-box {
            margin-top: 20px;
        }
        .checkout-card {
            padding: 20px;
        }
    }
    @media (max-width: 576px) {
        .checkout-card {
            padding: 16px;
        }
        .checkout-card .card-title {
            font-size: 17px;
        }
        .order-summary-box {
            padding: 16px;
        }
        .order-summary-box .item-row {
            font-size: 13px;
        }
        .order-summary-box .total-row .value {
            font-size: 16px;
        }
        .btn-proceed {
            font-size: 14px;
            padding: 12px;
        }
    }
</style>

<div class="checkout-wrap">
    <div class="container">
        
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">Cart</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
        <div class="row g-4">

            <!-- ========================================
                 BILLING DETAILS
                 ======================================== -->
            <div class="col-lg-7">
                <div class="checkout-card">
                    <div class="card-title">
                        <i class="fas fa-file-invoice"></i> Billing Details
                    </div>

                    <form action="{{ route('checkout.billing') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                   value="{{ old('first_name', Auth::user()->name ?? '') }}" 
                                   placeholder="Enter your full name" required>
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="required">*</span></label>
                            <input type="text" name="street_address" class="form-control @error('street_address') is-invalid @enderror" 
                                   value="{{ old('street_address') }}" 
                                   placeholder="House number and street name" required>
                            @error('street_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Town / City <span class="required">*</span></label>
                            <input type="text" name="town_city" class="form-control @error('town_city') is-invalid @enderror" 
                                   value="{{ old('town_city') }}" 
                                   placeholder="Enter your city" required>
                            @error('town_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <span class="required">*</span></label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                                           placeholder="03XX-XXXXXXX" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email Address <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', Auth::user()->email ?? '') }}" 
                                           placeholder="your@email.com" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-check mt-2">
                            <input type="checkbox" name="save_info" id="saveInfo" class="form-check-input" checked>
                            <label for="saveInfo" class="form-check-label">
                                <i class="fas fa-clock me-1" style="color:#8c8c9c;"></i> 
                                Save this information for faster check-out next time
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========================================
                 ORDER SUMMARY
                 ======================================== -->
            <div class="col-lg-5">
                <div class="order-summary-box">
                    <div class="summary-title">
                        <i class="fas fa-receipt" style="color:#db4444; margin-right:8px;"></i> Order Summary
                    </div>

                    @foreach($cartItems as $item)
                    <div class="item-row">
                        <span class="name">
                            {{ $item->product->name }}
                            <small>x{{ $item->quantity }}</small>
                        </span>
                        <span class="price">${{ number_format(($item->product->sale_price ?? $item->product->price), 2) }}</span>
                    </div>
                    @endforeach

                    <div class="item-row" style="border-top: 2px solid #e8e8e8; padding-top: 12px; margin-top: 4px;">
                        <span class="name">Subtotal</span>
                        <span class="price">${{ number_format($subtotal ?? 0, 2) }}</span>
                    </div>

                    @if(($discount ?? 0) > 0)
                    <div class="item-row">
                        <span class="name" style="color:#28a745;">Discount</span>
                        <span class="price" style="color:#28a745;">-${{ number_format($discount ?? 0, 2) }}</span>
                    </div>
                    @endif

                    <div class="item-row">
                        <span class="name">Shipping</span>
                        <span class="price">
                            @if(($shipping ?? 0) > 0)
                                ${{ number_format($shipping, 2) }}
                            @else
                                <span style="color:#28a745;">Free</span>
                            @endif
                        </span>
                    </div>

                    <div class="item-row">
                        <span class="name">Tax (5%)</span>
                        <span class="price">${{ number_format($tax ?? 0, 2) }}</span>
                    </div>

                    <div class="total-row">
                        <span class="label">Total</span>
                        <span class="value">${{ number_format($total ?? 0, 2) }}</span>
                    </div>

                    <button type="submit" form="checkoutForm" class="btn-proceed">
                        <i class="fas fa-arrow-right"></i> Proceed to Payment
                    </button>
                </div>
            </div>

        </div>
        @else
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your Cart is Empty</h3>
                <p>Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="btn-shop">
                    <i class="fas fa-store me-2"></i> Continue Shopping
                </a>
            </div>
        @endif

    </div>
</div>
@endsection