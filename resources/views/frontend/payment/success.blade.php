@extends('layouts.app')

@section('title', 'Payment Success - StyleHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="success-icon mb-4">
                        <i class="fas fa-check-circle fa-5x" style="color: #00a651;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Payment Successful! 🎉</h4>
                    <p class="text-muted small">Your payment has been processed successfully.</p>
                    <div class="payment-details p-3 rounded-3 mb-4" style="background: #f8f9fa; border: 1px solid #eee;">
                        <p class="small mb-1"><strong>Transaction ID:</strong> #PAY-{{ strtoupper(uniqid()) }}</p>
                        <p class="small mb-0"><strong>Amount:</strong> $99.99</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-danger px-4 rounded-pill">
                        <i class="fas fa-home me-2"></i> Go to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection