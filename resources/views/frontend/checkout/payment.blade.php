@extends('layouts.app')

@section('title', 'Payment - StyleHub')

@section('content')
<style>
    .payment-wrap {
        padding: 40px 0;
        background: #f8f9fa;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    .payment-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px 45px;
        border: none;
        box-shadow: 0 10px 50px rgba(0,0,0,0.06);
        max-width: 720px;
        margin: 0 auto;
        transition: all 0.3s;
    }
    .payment-card:hover {
        box-shadow: 0 15px 60px rgba(0,0,0,0.08);
    }

    .payment-header {
        text-align: center;
        margin-bottom: 28px;
    }
    .payment-header .icon-wrap {
        width: 64px;
        height: 64px;
        background: #fef0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    .payment-header .icon-wrap i {
        font-size: 28px;
        color: #db4444;
    }
    .payment-header h3 {
        font-weight: 700;
        font-size: 24px;
        color: #1a1a2e;
        margin: 0;
    }
    .payment-header p {
        color: #8c8c9c;
        font-size: 14px;
        margin: 4px 0 0;
    }

    .order-summary-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 16px 22px;
        margin-bottom: 22px;
        border: 1px solid #f0f0f0;
    }
    .order-summary-box .row-item {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        font-size: 14px;
        color: #555;
    }
    .order-summary-box .row-item .label { color: #8c8c9c; }
    .order-summary-box .row-item .val { font-weight: 500; color: #1a1a2e; }
    .order-summary-box .total-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0 0;
        margin-top: 6px;
        border-top: 2px solid #e0e0e0;
    }
    .order-summary-box .total-row .label { font-weight: 700; font-size: 16px; color: #1a1a2e; }
    .order-summary-box .total-row .val { font-weight: 700; font-size: 18px; color: #db4444; }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    .payment-option {
        border: 2px solid #e8e8e8;
        border-radius: 14px;
        padding: 20px 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fff;
        position: relative;
    }
    .payment-option:hover {
        border-color: #db4444;
        transform: translateY(-2px);
    }
    .payment-option.active {
        border-color: #db4444;
        background: #fef0f0;
        box-shadow: 0 4px 20px rgba(219, 68, 68, 0.08);
    }
    .payment-option .icon {
        font-size: 32px;
        display: block;
        margin-bottom: 6px;
    }
    .payment-option .icon.cod { color: #1976d2; }
    .payment-option .icon.bank { color: #e65100; }
    .payment-option .icon.card { color: #2e7d32; }
    .payment-option .icon.easypaisa { color: #6a1b9a; }
    .payment-option .title { font-weight: 600; font-size: 14px; color: #1a1a2e; }
    .payment-option .desc { font-size: 12px; color: #8c8c9c; margin-top: 2px; }
    .payment-option .check {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #db4444;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 12px;
    }
    .payment-option.active .check { display: flex; }

    .payment-details {
        display: none;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px 24px;
        margin: 0 0 20px;
        border: 1px solid #f0f0f0;
    }
    .payment-details.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .payment-details .detail-title {
        font-weight: 600;
        font-size: 15px;
        color: #1a1a2e;
        margin-bottom: 12px;
    }
    .payment-details .detail-title i { color: #db4444; margin-right: 8px; }

    .bank-info {
        background: #fff;
        border-radius: 10px;
        padding: 14px 18px;
        border: 1px solid #e8e8e8;
    }
    .bank-info p { margin: 4px 0; font-size: 13px; }
    .bank-info .label { color: #8c8c9c; font-weight: 500; }
    .bank-info .value { font-weight: 600; color: #1a1a2e; }

    .receipt-upload {
        border: 2px dashed #ddd;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fff;
        margin-top: 12px;
    }
    .receipt-upload:hover { border-color: #db4444; }
    .receipt-upload i { font-size: 26px; color: #ccc; display: block; margin-bottom: 4px; }
    .receipt-upload .file-name { font-size: 13px; color: #8c8c9c; }
    .receipt-upload input[type="file"] { display: none; }
    .receipt-upload.has-file { border-color: #28a745; background: #f0faf0; }

    .card-form { margin-top: 4px; }
    .card-form .form-control {
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        background: #fff !important;
        border: 1.5px solid #e0e0e0 !important;
        transition: all 0.3s;
    }
    .card-form .form-control:focus {
        border-color: #db4444 !important;
        box-shadow: 0 0 0 3px rgba(219, 68, 68, 0.06);
    }
    .card-form .form-label { font-size: 12px; font-weight: 600; color: #333; margin-bottom: 4px; }
    .card-form .card-icons {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }
    .card-form .card-icons i { font-size: 32px; color: #999; transition: all 0.3s; }
    .card-form .card-icons i.visa { color: #1a1f71; }
    .card-form .card-icons i.mastercard { color: #eb001b; }
    .card-form .card-icons i.amex { color: #006fcf; }
    .card-form .card-icons span {
        font-size: 12px;
        color: #8c8c9c;
        margin-left: 4px;
        align-self: center;
    }

    .btn-place-order {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s;
        margin-top: 4px;
    }
    .btn-place-order:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219, 68, 68, 0.25);
    }
    .btn-place-order i { margin-right: 8px; }

    @media (max-width: 768px) {
        .payment-card { padding: 24px 20px; }
        .payment-options { grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .payment-option { padding: 14px 10px; }
        .payment-option .icon { font-size: 24px; }
        .payment-option .title { font-size: 12px; }
        .payment-option .desc { font-size: 10px; }
        .payment-header h3 { font-size: 20px; }
    }
    @media (max-width: 480px) {
        .payment-card { padding: 16px 14px; border-radius: 14px; }
        .payment-options { grid-template-columns: 1fr; gap: 8px; }
        .payment-option { display: flex; align-items: center; gap: 14px; padding: 12px 16px; text-align: left; }
        .payment-option .icon { font-size: 22px; margin-bottom: 0; }
        .payment-option .check { top: -6px; right: -6px; width: 20px; height: 20px; font-size: 10px; }
        .payment-details { padding: 14px 16px; }
        .bank-info { padding: 10px 14px; }
        .bank-info p { font-size: 12px; }
        .payment-header .icon-wrap { width: 50px; height: 50px; }
        .payment-header .icon-wrap i { font-size: 22px; }
        .payment-header h3 { font-size: 18px; }
    }
</style>

<div class="payment-wrap">
    <div class="container">
        <div class="payment-card">

            <div class="payment-header">
                <div class="icon-wrap">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>Secure Payment</h3>
                <p>Select your preferred payment method to complete your order</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <div class="order-summary-box">
                <div class="row-item">
                    <span class="label">Subtotal</span>
                    <span class="val">${{ number_format($subtotal ?? 0, 2) }}</span>
                </div>
                @if(($discount ?? 0) > 0)
                <div class="row-item">
                    <span class="label" style="color:#28a745;">Discount</span>
                    <span class="val" style="color:#28a745;">-${{ number_format($discount ?? 0, 2) }}</span>
                </div>
                @endif
                <div class="row-item">
                    <span class="label">Shipping</span>
                    <span class="val">@if(($shipping ?? 0) > 0) ${{ number_format($shipping, 2) }} @else <span style="color:#28a745;">Free</span> @endif</span>
                </div>
                <div class="row-item">
                    <span class="label">Tax</span>
                    <span class="val">${{ number_format($tax ?? 0, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="label">Total</span>
                    <span class="val">${{ number_format($total ?? 0, 2) }}</span>
                </div>
            </div>

            <form action="{{ route('checkout.place') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                @csrf
                <input type="hidden" name="first_name" value="{{ $billing['first_name'] ?? '' }}">
                <input type="hidden" name="street_address" value="{{ $billing['street_address'] ?? '' }}">
                <input type="hidden" name="town_city" value="{{ $billing['town_city'] ?? '' }}">
                <input type="hidden" name="phone" value="{{ $billing['phone'] ?? '' }}">
                <input type="hidden" name="email" value="{{ $billing['email'] ?? '' }}">

                <!-- ===== PAYMENT OPTIONS ===== -->
                <div class="payment-options">
                    <div class="payment-option active" onclick="selectPayment('cod')">
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span class="icon cod"><i class="fas fa-truck"></i></span>
                        <div class="title">Cash on Delivery</div>
                        <div class="desc">Pay when you receive</div>
                    </div>

                    <div class="payment-option" onclick="selectPayment('bank')">
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span class="icon bank"><i class="fas fa-university"></i></span>
                        <div class="title">Bank Transfer</div>
                        <div class="desc">Pay via bank account</div>
                    </div>

                    <div class="payment-option" onclick="selectPayment('card')">
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span class="icon card"><i class="fas fa-credit-card"></i></span>
                        <div class="title">Card Payment</div>
                        <div class="desc">Credit / Debit Card</div>
                    </div>
                </div>

                
                <input type="radio" name="payment_method" value="cod" checked style="display:none;">
                <input type="radio" name="payment_method" value="bank" style="display:none;">
                <input type="radio" name="payment_method" value="card" style="display:none;">

                @error('payment_method')
                    <div class="text-danger text-center mt-1">{{ $message }}</div>
                @enderror

                
                <div id="paymentDetails" class="payment-details">
                    
                    
                    <div id="bankDetails">
                        <div class="detail-title"><i class="fas fa-university"></i> Bank Transfer Details</div>
                        <div class="bank-info">
                            <p><span class="label">Bank:</span> <span class="value">Meezan Bank</span></p>
                            <p><span class="label">Account Title:</span> <span class="value">StyleHub Store</span></p>
                            <p><span class="label">Account Number:</span> <span class="value">1234-567890-01</span></p>
                            <p><span class="label">IBAN:</span> <span class="value">PK12MEZN0012345678901</span></p>
                        </div>

                        <div class="receipt-upload" id="receiptUpload" onclick="document.getElementById('payment_receipt').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="file-name" id="fileName">Click to upload payment receipt</div>
                            <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf,.doc,.docx">
                            <small class="text-muted">Upload payment screenshot (JPG, PNG, PDF)</small>
                        </div>
                        <div id="receiptError" class="text-danger mt-1" style="display:none; text-align:center;">Please upload your payment receipt</div>
                    </div>

                   
                    <div id="cardDetails" style="display:none;">
                        <div class="detail-title"><i class="fas fa-credit-card"></i> Card Details</div>
                        
                        <div class="card-form">
                            <div class="card-icons">
                                <i class="fab fa-cc-visa visa"></i>
                                <i class="fab fa-cc-mastercard mastercard"></i>
                                <i class="fab fa-cc-amex amex"></i>
                                <span>We accept all major cards</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" name="card_expiry" class="form-control" placeholder="MM / YY">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="card_cvv" class="form-control" placeholder="123" maxlength="4">
                                </div>
                            </div>

                            <div class="mb-3 mt-2">
                                <label class="form-label">Cardholder Name</label>
                                <input type="text" name="card_name" class="form-control" placeholder="John Doe">
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn-place-order" id="placeOrderBtn">
                    <i class="fas fa-lock me-1"></i> Place Order
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    function selectPayment(method) {
        document.querySelectorAll('input[name="payment_method"]').forEach(el => {
            el.checked = (el.value === method);
        });
        
        document.querySelectorAll('.payment-option').forEach(el => {
            el.classList.remove('active');
        });
        document.querySelectorAll('.payment-option').forEach(el => {
            if (el.querySelector('.icon.' + method)) {
                el.classList.add('active');
            }
        });
        
        const details = document.getElementById('paymentDetails');
        const bankDetails = document.getElementById('bankDetails');
        const cardDetails = document.getElementById('cardDetails');
        const fileInput = document.getElementById('payment_receipt');
        const error = document.getElementById('receiptError');
        
        details.classList.remove('active');
        bankDetails.style.display = 'none';
        cardDetails.style.display = 'none';
        fileInput.removeAttribute('required');
        if (error) error.style.display = 'none';
        
        if (method === 'cod') {
            details.classList.remove('active');
        } else if (method === 'bank') {
            details.classList.add('active');
            bankDetails.style.display = 'block';
            cardDetails.style.display = 'none';
            fileInput.setAttribute('required', 'required');
        } else if (method === 'card') {
            details.classList.add('active');
            bankDetails.style.display = 'none';
            cardDetails.style.display = 'block';
            fileInput.removeAttribute('required');
        }
    }

    document.getElementById('payment_receipt')?.addEventListener('change', function() {
        const container = document.getElementById('receiptUpload');
        const fileName = document.getElementById('fileName');
        const error = document.getElementById('receiptError');
        
        if (this.files && this.files[0]) {
            container.classList.add('has-file');
            fileName.textContent = '📎 ' + this.files[0].name;
            if (error) error.style.display = 'none';
        } else {
            container.classList.remove('has-file');
            fileName.textContent = 'Click to upload payment receipt';
        }
    });

    document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            return;
        }
        
        if (paymentMethod.value === 'bank') {
            const fileInput = document.getElementById('payment_receipt');
            const error = document.getElementById('receiptError');
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                if (error) error.style.display = 'block';
                document.getElementById('receiptUpload').scrollIntoView({ behavior: 'smooth' });
                return;
            } else {
                if (error) error.style.display = 'none';
            }
        }
        
        if (paymentMethod.value === 'card') {
            const cardNumber = document.querySelector('input[name="card_number"]');
            const cardExpiry = document.querySelector('input[name="card_expiry"]');
            const cardCvv = document.querySelector('input[name="card_cvv"]');
            
            if (!cardNumber.value.trim()) {
                e.preventDefault();
                alert('Please enter card number');
                cardNumber.focus();
                return;
            }
            if (cardNumber.value.replace(/\s/g, '').length < 16) {
                e.preventDefault();
                alert('Please enter a valid 16-digit card number');
                cardNumber.focus();
                return;
            }
            if (!cardExpiry.value.trim()) {
                e.preventDefault();
                alert('Please enter expiry date');
                cardExpiry.focus();
                return;
            }
            if (!cardCvv.value.trim()) {
                e.preventDefault();
                alert('Please enter CVV');
                cardCvv.focus();
                return;
            }
            if (cardCvv.value.length < 3) {
                e.preventDefault();
                alert('Please enter a valid CVV (3-4 digits)');
                cardCvv.focus();
                return;
            }
        }
    });

    document.querySelector('input[name="card_number"]')?.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        let formatted = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) formatted += ' ';
            formatted += value[i];
        }
        this.value = formatted;
    });

    document.querySelector('input[name="card_expiry"]')?.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        if (value.length >= 2) {
            this.value = value.slice(0, 2) + ' / ' + value.slice(2);
        } else {
            this.value = value;
        }
    });

    document.querySelector('input[name="card_cvv"]')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 4) this.value = this.value.slice(0, 4);
    });

    document.addEventListener('DOMContentLoaded', function() {
        selectPayment('cod');
    });
</script>
@endsection