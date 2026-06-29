@extends('layouts.app')

@section('title', 'Checkout - StyleHub')

@section('content')
<style>
    .payment-option-card {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .payment-option-card:hover {
        border-color: #db4444;
    }
    .payment-option-card.active {
        border-color: #db4444;
        background: #fef0f0;
    }
    .payment-option-card .icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .payment-option-card .icon.cod { background: #e3f2fd; color: #1976d2; }
    .payment-option-card .icon.bank { background: #fff3e0; color: #e65100; }
    .payment-option-card .icon.easypaisa { background: #e8f5e9; color: #2e7d32; }
    .payment-option-card .info .title {
        font-weight: 600;
        color: #1a1a2e;
    }
    .payment-option-card .info .desc {
        font-size: 12px;
        color: #8c8c9c;
    }
    .payment-option-card .radio {
        margin-left: auto;
    }
    .payment-option-card .radio input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #db4444;
        cursor: pointer;
    }

    .payment-details {
        display: none;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 12px;
        border: 1px solid #e0e0e0;
    }
    .payment-details.active {
        display: block;
    }
    .payment-details .bank-info {
        background: #fff;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 14px;
        border: 1px solid #e0e0e0;
    }
    .payment-details .bank-info p {
        margin: 4px 0;
        font-size: 14px;
    }
    .payment-details .bank-info .label {
        color: #8c8c9c;
        font-weight: 500;
    }
    .payment-details .bank-info .value {
        font-weight: 600;
        color: #1a1a2e;
    }
    .receipt-upload {
        border: 2px dashed #ddd;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fff;
    }
    .receipt-upload:hover {
        border-color: #db4444;
    }
    .receipt-upload i {
        font-size: 32px;
        color: #ddd;
        display: block;
        margin-bottom: 6px;
    }
    .receipt-upload .file-name {
        font-size: 13px;
        color: #8c8c9c;
    }
    .receipt-upload input[type="file"] {
        display: none;
    }
    .receipt-upload.has-file {
        border-color: #28a745;
        background: #f0faf0;
    }
</style>

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

    @if(isset($cartItems) && count($cartItems) > 0)
    <div class="row">
        <!-- Billing Details -->
        <div class="col-lg-7">
            <h3 class="fw-bold mb-4" style="font-size: 24px; color: #000;">Billing Details</h3>
            
            <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control rounded-0 @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', Auth::user()->name ?? '') }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Street Address <span class="text-danger">*</span></label>
                    <input type="text" name="street_address" class="form-control rounded-0 @error('street_address') is-invalid @enderror" 
                           value="{{ old('street_address') }}" required>
                    @error('street_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Town/City <span class="text-danger">*</span></label>
                    <input type="text" name="town_city" class="form-control rounded-0 @error('town_city') is-invalid @enderror" 
                           value="{{ old('town_city') }}" required>
                    @error('town_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone Number</label>
                    <input type="tel" name="phone" class="form-control rounded-0 @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid @enderror" 
                           value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- ===== PAYMENT METHODS ===== -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Payment Method <span class="text-danger">*</span></label>
                    
                    <!-- Cash on Delivery -->
                    <div class="payment-option-card active" onclick="selectPayment('cod')">
                        <div class="icon cod"><i class="fas fa-truck"></i></div>
                        <div class="info">
                            <div class="title">Cash on Delivery</div>
                            <div class="desc">Pay when you receive your order</div>
                        </div>
                        <div class="radio">
                            <input type="radio" name="payment_method" value="cod" checked>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="payment-option-card" onclick="selectPayment('bank')">
                        <div class="icon bank"><i class="fas fa-university"></i></div>
                        <div class="info">
                            <div class="title">Bank Transfer</div>
                            <div class="desc">Pay via bank account transfer</div>
                        </div>
                        <div class="radio">
                            <input type="radio" name="payment_method" value="bank">
                        </div>
                    </div>

                    <!-- EasyPaisa -->
                    <div class="payment-option-card" onclick="selectPayment('easypaisa')">
                        <div class="icon easypaisa"><i class="fas fa-mobile-alt"></i></div>
                        <div class="info">
                            <div class="title">EasyPaisa</div>
                            <div class="desc">Pay via EasyPaisa mobile account</div>
                        </div>
                        <div class="radio">
                            <input type="radio" name="payment_method" value="easypaisa">
                        </div>
                    </div>

                    @error('payment_method')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ===== PAYMENT DETAILS (Bank/EasyPaisa) ===== -->
                <div id="paymentDetails" class="payment-details">
                    <h6 class="fw-bold mb-2"><i class="fas fa-info-circle text-danger"></i> Payment Instructions</h6>
                    
                    <!-- Bank Details -->
                    <div id="bankInfo" class="bank-info">
                        <p><span class="label">Bank:</span> <span class="value">Meezan Bank</span></p>
                        <p><span class="label">Account Title:</span> <span class="value">StyleHub Store</span></p>
                        <p><span class="label">Account Number:</span> <span class="value">1234-567890-01</span></p>
                        <p><span class="label">IBAN:</span> <span class="value">PK12MEZN0012345678901</span></p>
                    </div>

                    <!-- EasyPaisa Details -->
                    <div id="easypaisaInfo" class="bank-info" style="display:none;">
                        <p><span class="label">EasyPaisa Number:</span> <span class="value">03XX-XXXXXXX</span></p>
                        <p><span class="label">Account Title:</span> <span class="value">StyleHub Store</span></p>
                    </div>

                    <!-- Upload Receipt -->
                    <div class="receipt-upload" id="receiptUpload" onclick="document.getElementById('payment_receipt').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div class="file-name" id="fileName">Click to upload payment receipt</div>
                        <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">Upload your payment screenshot (JPG, PNG, PDF)</small>
                    </div>
                    <div id="receiptError" class="text-danger mt-1" style="display:none;">Please upload your payment receipt</div>
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

        <!-- Order Summary -->
        <div class="col-lg-5 mt-4 mt-lg-0">
            <div class="order-summary" style="background: #fff; border: 1px solid #ddd; padding: 25px; margin-left: 50px; margin-top:55px;">
                
                @foreach($cartItems as $item)
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">{{ $item->product->name }} <span class="text-muted">x{{ $item->quantity }}</span></span>
                    <span class="fw-semibold">${{ number_format(($item->product->sale_price ?? $item->product->price), 2) }}</span>
                </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Subtotal:</span>
                    <span class="fw-semibold">${{ number_format($subtotal ?? 0, 2) }}</span>
                </div>

                @if(($discount ?? 0) > 0)
                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Discount:</span>
                    <span class="fw-semibold text-success">-${{ number_format($discount ?? 0, 2) }}</span>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Shipping:</span>
                    <span class="fw-semibold {{ ($shipping ?? 0) > 0 ? '' : 'text-success' }}">
                        {{ ($shipping ?? 0) > 0 ? '$'.number_format($shipping, 2) : 'Free' }}
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-semibold">Tax:</span>
                    <span class="fw-semibold">${{ number_format($tax ?? 0, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid #eee;">
                    <span class="fw-bold fs-5">Total:</span>
                    <span class="fw-bold fs-5" style="color: #db4444;">${{ number_format($total ?? 0, 2) }}</span>
                </div>

                <div class="d-flex gap-2 py-3" style="border-bottom: 1px solid #eee;">
                    <input type="text" id="checkoutCoupon" class="form-control rounded-0" placeholder="Coupon Code" style="flex: 1; border: 1px solid #ddd; background: #f5f5f5;">
                    <button onclick="applyCheckoutCoupon()" class="btn btn-dark rounded-0 px-4" style="background: #000; border: none; white-space: nowrap;">
                        Apply Coupon
                    </button>
                </div>

                <div class="d-none d-lg-block mt-4">
                    <button type="submit" form="checkoutForm" class="btn btn-danger w-100 rounded-0 py-3" style="background: #db4444; font-weight: 600; font-size: 16px;">
                        Place Order
                    </button>
                </div>
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

<script>

    function selectPayment(method) {
       
        document.querySelectorAll('input[name="payment_method"]').forEach(el => {
            el.checked = (el.value === method);
        });
        
        document.querySelectorAll('.payment-option-card').forEach(el => {
            el.classList.remove('active');
        });
        event.currentTarget?.classList.add('active');
        
       
        const details = document.getElementById('paymentDetails');
        const bankInfo = document.getElementById('bankInfo');
        const easypaisaInfo = document.getElementById('easypaisaInfo');
        const receiptUpload = document.getElementById('receiptUpload');
        const fileInput = document.getElementById('payment_receipt');
        
        if (method === 'cod') {
            details.classList.remove('active');
            fileInput.removeAttribute('required');
        } else {
            details.classList.add('active');
            fileInput.setAttribute('required', 'required');
            
            if (method === 'bank') {
                bankInfo.style.display = 'block';
                easypaisaInfo.style.display = 'none';
            } else if (method === 'easypaisa') {
                bankInfo.style.display = 'none';
                easypaisaInfo.style.display = 'block';
            }
        }
    }

    
    document.getElementById('payment_receipt')?.addEventListener('change', function() {
        const container = document.getElementById('receiptUpload');
        const fileName = document.getElementById('fileName');
        const error = document.getElementById('receiptError');
        
        if (this.files && this.files[0]) {
            container.classList.add('has-file');
            fileName.textContent = '📎 ' + this.files[0].name;
            error.style.display = 'none';
        } else {
            container.classList.remove('has-file');
            fileName.textContent = 'Click to upload payment receipt';
        }
    });

    
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            return;
        }
        
        if (paymentMethod.value !== 'cod') {
            const fileInput = document.getElementById('payment_receipt');
            const error = document.getElementById('receiptError');
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                error.style.display = 'block';
                document.getElementById('receiptUpload').scrollIntoView({ behavior: 'smooth' });
                return;
            } else {
                error.style.display = 'none';
            }
        }
    });


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

   
    document.addEventListener('DOMContentLoaded', function() {
      
        selectPayment('cod');
    });
</script>
@endsection

@push('styles')
<style>
    .order-summary { border-radius: 4px; }
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
    .btn-danger {
        background: #db4444;
        border: none;
        transition: all 0.3s;
    }
    .btn-danger:hover { background: #c0392b; }
    .btn-dark { background: #000; border: none; }
    .btn-dark:hover { background: #333; }
    .breadcrumb-item a { color: #333; text-decoration: none; }
    .breadcrumb-item a:hover { color: #db4444; }
    .breadcrumb-item.active { color: #db4444; }
    @media (max-width: 991px) {
        .order-summary { padding: 20px !important; margin-left: 0 !important; margin-top: 0 !important; }
    }
    @media (max-width: 576px) {
        .order-summary { padding: 15px !important; margin-left: 0 !important; margin-top: 0 !important; }
        .payment-option-card { padding: 12px 16px; }
        .payment-option-card .icon { width: 32px; height: 32px; font-size: 14px; }
    }
</style>
@endpush