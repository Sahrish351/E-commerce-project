@extends('layouts.app')

@section('title', 'About Us - StyleHub')

@section('content')
<div class="container py-4">
    
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <span class="badge bg-danger mb-2" style="background: #db4444 !important; padding: 6px 16px; font-size: 12px; border-radius: 30px;">About Us</span>
            <h1 class="fw-bold" style="font-size: 36px; color: #333;">Who We <span style="color: #db4444;">Are</span></h1>
            <p class="text-muted" style="max-width: 500px; margin: 0 auto;">Learn more about our story and what makes us different</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="text-center p-4" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <i class="fas fa-store" style="font-size: 32px; color: #db4444;"></i>
                <h3 class="fw-bold mt-2" style="font-size: 28px; color: #333;">2020</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Founded</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="text-center p-4" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <i class="fas fa-users" style="font-size: 32px; color: #db4444;"></i>
                <h3 class="fw-bold mt-2" style="font-size: 28px; color: #333;">12,847+</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Happy Customers</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="text-center p-4" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <i class="fas fa-box" style="font-size: 32px; color: #db4444;"></i>
                <h3 class="fw-bold mt-2" style="font-size: 28px; color: #333;">15,234</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Orders Delivered</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="text-center p-4" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <i class="fas fa-star" style="font-size: 32px; color: #db4444;"></i>
                <h3 class="fw-bold mt-2" style="font-size: 28px; color: #333;">4.9</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Average Rating</p>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
            <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 16px; padding: 40px; text-align: center; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <div>
                    <i class="fas fa-quote-left" style="font-size: 36px; color: #db4444; opacity: 0.3;"></i>
                    <p style="font-size: 20px; font-style: italic; color: #555; line-height: 1.8; max-width: 400px; margin: 0 auto;">
                        "Style is a way to say who you are without having to speak."
                    </p>
                    <p style="color: #999; font-size: 14px; margin-top: 10px;">— Rachel Zoe</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h3 class="fw-bold" style="font-size: 24px; color: #333;">Our <span style="color: #db4444;">Story</span></h3>
            <p style="color: #666; line-height: 1.8; font-size: 15px;">
                StyleHub was founded in 2020 with a simple vision: to make premium fashion accessible to everyone. 
                What started as a small boutique has grown into a trusted destination for thousands of customers worldwide.
            </p>
            <p style="color: #666; line-height: 1.8; font-size: 15px;">
                We believe that style is a form of self-expression, and we're committed to curating collections 
                that help you tell your unique story.
            </p>
            <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-0 px-4" style="background: #db4444; font-weight: 600;">
                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
            </a>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="row mb-4">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold" style="font-size: 28px; color: #333;">Why Choose <span style="color: #db4444;">Us</span></h3>
            <p class="text-muted">We're dedicated to providing the best experience for our customers</p>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
            <div class="text-center p-3" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <div style="width: 60px; height: 60px; background: #fef0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class="fas fa-check-circle" style="font-size: 24px; color: #db4444;"></i>
                </div>
                <h6 class="fw-bold" style="font-size: 14px;">Quality Products</h6>
                <p style="font-size: 12px; color: #999; margin-bottom: 0;">Carefully curated & tested</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-3" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <div style="width: 60px; height: 60px; background: #fef0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class="fas fa-truck" style="font-size: 24px; color: #db4444;"></i>
                </div>
                <h6 class="fw-bold" style="font-size: 14px;">Free Shipping</h6>
                <p style="font-size: 12px; color: #999; margin-bottom: 0;">On orders over $500</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-3" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <div style="width: 60px; height: 60px; background: #fef0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class="fas fa-headset" style="font-size: 24px; color: #db4444;"></i>
                </div>
                <h6 class="fw-bold" style="font-size: 14px;">24/7 Support</h6>
                <p style="font-size: 12px; color: #999; margin-bottom: 0;">Always here to help</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-center p-3" style="border: 1px solid #eee; border-radius: 12px; background: #fff; transition: all 0.3s;">
                <div style="width: 60px; height: 60px; background: #fef0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class="fas fa-shield-alt" style="font-size: 24px; color: #db4444;"></i>
                </div>
                <h6 class="fw-bold" style="font-size: 14px;">Secure Payments</h6>
                <p style="font-size: 12px; color: #999; margin-bottom: 0;">100% secure checkout</p>
            </div>
        </div>
    </div>
</div>

<style>
    .stats-section .col-6:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .why-choose .col-md-3:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
</style>
@endsection