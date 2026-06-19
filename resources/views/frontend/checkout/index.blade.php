@extends('layouts.app')

@section('title', 'Checkout - StyleHub')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">View Cart</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">CheckOut</li>
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
        
        <div class="col-lg-7">
            <h3 class="fw-bold mb-4" style="font-size: 24px; color: #000;">Billing Details</h3>
            
            <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
                @csrf
                
             
                <div class="mb-3">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control rounded-0 @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', Auth::user()->name ?? '') }}" 
                           placeholder="Sheri" required
                           style="background: #f5f5f5; border: 1px solid #ddd;">
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
               

                <div class="mb-3">
                    <label class="form-label fw-semibold">Street Address <span class="text-danger">*</span></label>
                    <input type="text" name="street_address" class="form-control rounded-0 @error('street_address') is-invalid @enderror" 
                           value="{{ old('street_address') }}" 
                           placeholder="Jinnah Park Skeikhpura" required
                           style="background: #f5f5f5; border: 1px solid #ddd;">
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

               
                <div class="mb-3">
                    <label class="form-label fw-semibold">Town/City <span class="text-danger">*</span></label>
                    <input type="text" name="town_city" class="form-control rounded-0 @error('town_city') is-invalid @enderror" 
                           value="{{ old('town_city') }}" 
                           placeholder="Sheikhupura" required
                           style="background: #f5f5f5; border: 1px solid #ddd;">
                    @error('town_city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

               
                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone Number</label>
                    <input type="tel" name="phone" class="form-control rounded-0 @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                           placeholder="03067898765" required
                           style="background: #f5f5f5; border: 1px solid #ddd;">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid @enderror" 
                           value="{{ old('email', Auth::user()->email ?? '') }}" 
                           placeholder="sheri@gmail.com" required
                           style="background: #f5f5f5; border: 1px solid #ddd;">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

               
                <div class="form-check mt-3">
                    <input type="checkbox" name="save_info" id="saveInfo" class="form-check-input" checked>
                    <label for="saveInfo" class="form-check-label">Save this information for faster check-out next time</label>
                </div>

                <div class="d-lg-none mt-4">
                    <button type="submit" class="btn btn-danger w-100 rounded-0 py-3" style="background: #db4444; font-weight: 600; font-size: 16px;">
                        Place Order
                    </button>
                </div>
            </form>
        </div>

       
        <div class="col-lg-5 mt-4 mt-lg-0">
            <div class="order-summary" style="background: #fff; border: 1px solid #ddd; padding: 25px; margin-left: 50px; margin-top:55px;">
                
               
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">LCD Monitor</span>
                    <span class="fw-semibold">$650</span>
                </div>

                <!-- HI Gamepad -->
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">HI Gamepad</span>
                    <span class="fw-semibold">$1100</span>
                </div>

                <!-- Subtotal -->
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Subtotal:</span>
                    <span class="fw-semibold">$1750</span>
                </div>

                <!-- Shipping -->
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Shipping:</span>
                    <span class="fw-semibold text-success">Free</span>
                </div>

                <!-- Total -->
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-bold fs-5">Total:</span>
                    <span class="fw-bold fs-5" style="color: #db4444;">$1750</span>
                </div>

                <!-- Payment Methods - Bank & Cash on delivery -->
                <div class="py-3" style="border-bottom: 1px solid #eee;">
                    <div class="d-flex align-items-center gap-4">
                        <div class="form-check">
                            <input type="radio" name="payment_method" id="bank" value="bank" class="form-check-input" checked>
                            <label for="bank" class="form-check-label fw-semibold">Bank</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="payment_method" id="cod" value="cod" class="form-check-input">
                            <label for="cod" class="form-check-label fw-semibold">Cash on delivery</label>
                        </div>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="d-flex gap-2 py-3" style="border-bottom: 1px solid #eee;">
                    <input type="text" id="checkoutCoupon" class="form-control rounded-0" placeholder="Coupon Code" style="flex: 1; border: 1px solid #ddd; background: #f5f5f5;">
                    <button onclick="applyCheckoutCoupon()" class="btn btn-dark rounded-0 px-4" style="background: #000; border: none; white-space: nowrap;">
                        Apply Coupon
                    </button>
                </div>

                <!-- Place Order Button (Desktop) -->
                <div class="d-none d-lg-block mt-4">
                    <button type="submit" form="checkoutForm" class="btn btn-danger w-100 rounded-0 py-3" style="background: #db4444; font-weight: 600; font-size: 16px;">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
        <!-- Empty Cart -->
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
    .order-summary {
        border-radius: 4px;
    }
    .form-control {
        border-radius: 0;
        padding: 12px 15px;
        font-size: 14px;
        background: #f5f5f5 !important;
        border: 1px solid #ddd !important;
    }
    .form-control:focus {
        border-color: #db4444 !important;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
        background: #f5f5f5 !important;
    }
    .form-control::placeholder {
        color: #999;
        font-weight: 400;
    }
    .form-label {
        font-size: 14px;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }
    .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
    .form-check-input:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }
    .btn-danger {
        background: #db4444;
        border: none;
        transition: all 0.3s;
    }
    .btn-danger:hover {
        background: #c0392b;
    }
    .btn-dark {
        background: #000;
        border: none;
        transition: all 0.3s;
    }
    .btn-dark:hover {
        background: #333;
    }
    .breadcrumb-item a {
        color: #333;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: #db4444;
    }
    .breadcrumb-item.active {
        color: #db4444;
    }
    .text-danger {
        color: #db4444 !important;
    }
    .form-check-label {
        font-weight: 500;
    }
    @media (max-width: 991px) {
        .order-summary {
            padding: 20px !important;
            margin-left: 0 !important;
            margin-top: 0 !important;
        }
    }
    @media (max-width: 576px) {
        .order-summary {
            padding: 15px !important;
            margin-left: 0 !important;
            margin-top: 0 !important;
        }
        .form-check {
            margin-bottom: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function applyCheckoutCoupon() {
        var code = document.getElementById('checkoutCoupon').value;
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
</script>
@endpush