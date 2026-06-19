@extends('layouts.app')

@section('title', 'PayFast Payment - StyleHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
              
                <div class="payment-header p-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="payfast-logo bg-white rounded-3 px-3 py-2">
                                <span class="fw-bold" style="color: #1a1a2e;">PayFast</span>
                            </div>
                            <div>
                                <h6 class="text-white fw-bold mb-0">Secure Payment</h6>
                                <span class="text-white-50 small"><i class="fas fa-lock me-1"></i> 256-bit encrypted</span>
                            </div>
                        </div>
                        <div class="text-white-50 small">
                            <i class="fas fa-check-circle text-success me-1"></i> Verified
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    
                    <div class="payment-summary d-flex align-items-center justify-content-between p-3 rounded-3 mb-4" style="background: #f8f9fa; border: 1px solid #eee;">
                        <div>
                            <span class="text-muted small">Total Amount</span>
                            <h4 class="fw-bold mb-0" style="color: #1a1a2e;">$99.99</h4>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                <i class="fas fa-shield-alt me-1"></i> Secure
                            </span>
                        </div>
                    </div>

                    <form id="paymentForm" method="POST" action="{{ route('payment.process') }}">
                        @csrf

                    
                        <div class="mb-3">
                            <label class="fw-semibold small mb-2">Card Number</label>
                            <div class="card-input-wrapper position-relative">
                                <div class="card-type-icons position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); z-index: 10;">
                                    <img src="https://placehold.co/40x25/blue/white?text=VISA" alt="Visa" style="height: 20px;" class="me-1">
                                    <img src="https://placehold.co/40x25/red/white?text=MC" alt="Mastercard" style="height: 20px;" class="me-1">
                                    <img src="https://placehold.co/40x25/lightblue/white?text=Amex" alt="Amex" style="height: 20px;">
                                </div>
                                <input type="text" 
                                       id="cardNumber" 
                                       class="form-control form-control-lg rounded-3" 
                                       placeholder="1234 5678 9012 3456" 
                                       maxlength="19"
                                       style="padding-right: 120px;"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold small mb-2">Cardholder Name</label>
                            <input type="text" 
                                   id="cardName" 
                                   class="form-control form-control-lg rounded-3" 
                                   placeholder="John Doe"
                                   required>
                        </div>

                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="fw-semibold small mb-2">Expiry Date</label>
                                <input type="text" 
                                       id="expiryDate" 
                                       class="form-control form-control-lg rounded-3" 
                                       placeholder="MM/YY"
                                       maxlength="5"
                                       required>
                            </div>
                            <div class="col-6">
                                <label class="fw-semibold small mb-2">CVV</label>
                                <div class="input-group">
                                    <input type="password" 
                                           id="cvv" 
                                           class="form-control form-control-lg rounded-3" 
                                           placeholder="•••"
                                           maxlength="4"
                                           style="border-right: none; border-radius: 8px 0 0 8px;"
                                           required>
                                    <span class="input-group-text rounded-3" 
                                          style="background: #fff; border-left: none; border-radius: 0 8px 8px 0; cursor: pointer;" 
                                          onclick="alert('CVV is the 3-digit number on the back of your card')">
                                        <i class="fas fa-question-circle text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                       
                        <div class="security-badges d-flex gap-3 mt-4 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-lock text-success"></i>
                                <span class="small text-muted">256-bit SSL</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-shield-alt text-success"></i>
                                <span class="small text-muted">Fraud Protection</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i>
                                <span class="small text-muted">Verified by PayFast</span>
                            </div>
                        </div>

                     
                        <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill fw-bold" style="background: linear-gradient(135deg, #db4444, #c0392b);">
                            <i class="fas fa-lock me-2"></i> Pay $99.99
                        </button>

                        
                        <div class="text-center mt-4">
                            
                            <a href="{{ route('profile.payment') }}" class="text-muted small text-decoration-none mt-2 d-inline-block">
                                <i class="fas fa-arrow-left me-1"></i> Back to Payment Options
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control {
        border: 2px solid #e8e8e8;
        transition: all 0.3s;
        font-size: 16px;
    }
    .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 4px rgba(219,68,68,0.08);
    }
    .form-control-lg {
        padding: 14px 18px;
    }
    .input-group-text {
        border: 2px solid #e8e8e8;
        border-left: none;
        background: #fff;
    }
    .input-group .form-control:focus + .input-group-text {
        border-color: #db4444;
    }
    .payment-header {
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .payfast-logo {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .card-input-wrapper {
        position: relative;
    }
    .card-type-icons img {
        opacity: 0.6;
        transition: all 0.3s;
    }
    .card-type-icons img.active {
        opacity: 1;
    }
    .payment-summary {
        border-left: 4px solid #db4444;
    }
    .security-badges {
        padding: 10px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
  
    #cardNumber {
        letter-spacing: 2px;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
    
    const cardNumber = document.getElementById('cardNumber');
    cardNumber.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formatted = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) formatted += ' ';
            formatted += value[i];
        }
        e.target.value = formatted;
        
     
        let firstDigit = value.charAt(0);
        let icons = document.querySelectorAll('.card-type-icons img');
        icons.forEach(icon => icon.classList.remove('active'));
        if (firstDigit === '4') {
            document.querySelector('.card-type-icons img:first-child')?.classList.add('active');
        } else if (firstDigit === '5') {
            document.querySelector('.card-type-icons img:nth-child(2)')?.classList.add('active');
        }
    });

   
    const expiryDate = document.getElementById('expiryDate');
    expiryDate.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
    });

    
    const cvv = document.getElementById('cvv');
    cvv.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    
    const cardName = document.getElementById('cardName');
    cardName.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
    });

  
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();

       
        let cardNum = document.getElementById('cardNumber').value.replace(/\s/g, '');
        let expiry = document.getElementById('expiryDate').value;
        let cvvVal = document.getElementById('cvv').value;
        let nameVal = document.getElementById('cardName').value;

        if (cardNum.length < 16) {
            alert('Please enter a valid 16-digit card number');
            document.getElementById('cardNumber').focus();
            return;
        }
        if (expiry.length < 5) {
            alert('Please enter a valid expiry date (MM/YY)');
            document.getElementById('expiryDate').focus();
            return;
        }
        if (cvvVal.length < 3) {
            alert('Please enter a valid CVV (3-4 digits)');
            document.getElementById('cvv').focus();
            return;
        }
        if (nameVal.length < 2) {
            alert('Please enter cardholder name');
            document.getElementById('cardName').focus();
            return;
        }

       
        let btn = document.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
        btn.disabled = true;

        
        setTimeout(() => {
            window.location.href = '{{ route("payment.success") }}';
        }, 2500);
    });
</script>
@endpush