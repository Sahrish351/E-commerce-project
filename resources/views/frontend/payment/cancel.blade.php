@extends('layouts.app')

@section('title', 'Payment Cancel - StyleHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <i class="fas fa-times-circle fa-5x text-danger mb-4"></i>
                    <h4 class="fw-bold">Payment Cancelled</h4>
                    <p class="text-muted">Your payment was cancelled. Please try again.</p>
                    <a href="{{ route('profile.payment') }}" class="btn btn-danger mt-3 px-4 rounded-pill">Try Again</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection