@extends('layouts.app')

@section('title', 'Payment Options - StyleHub')

@section('content')
<div class="container py-4">
    <div class="row">
       
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar p-3 rounded-3" style="background: #fff; border: 1px solid #eee;">
                <div class="text-center pb-3 border-bottom">
                    <div class="avatar mx-auto mb-2" style="width: 70px; height: 70px; background: #db4444; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white fw-bold fs-3">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                </div>

                <div class="mt-3">
                    <a href="{{ route('profile.dashboard') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('profile.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Dashboard</span>
                    </a>
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">Manage My Account</h6>
                    <a href="{{ route('profile.edit') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Profile</span>
                    </a>
                    <a href="{{ route('profile.addresses') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('profile.addresses') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Address Book</span>
                    </a>
                    <a href="{{ route('profile.payment') }}" class="sidebar-link active d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-credit-card" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Payment Options</span>
                    </a>
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Orders</h6>
                    
                  
                    <a href="{{ route('orders.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                        <i class="fas fa-box" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Orders</span>
                    </a>
                    <a href="{{ route('orders.returns') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('orders.returns') ? 'active' : '' }}">
                        <i class="fas fa-undo" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Returns</span>
                    </a>
                    <a href="{{ route('orders.cancellations') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('orders.cancellations') ? 'active' : '' }}">
                        <i class="fas fa-times-circle" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Cancellations</span>
                    </a>
                    
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Wishlist</h6>
                    <a href="{{ route('wishlist.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
                        <i class="fas fa-heart" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">View Wishlist</span>
                    </a>
                    <hr class="my-3">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none text-danger">
                        <i class="fas fa-sign-out-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small fw-semibold">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </div>
        </div>

       
        <div class="col-md-9">
            <div class="profile-content p-4 rounded-3" style="background: #fff; border: 1px solid #eee;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">💳 Payment Options</h5>
                    <span class="badge bg-success px-3 py-2">Secure Payments</span>
                </div>

                <div class="row g-3">
                   
                    <div class="col-md-6">
                        <div class="payment-card active p-3 rounded-3" style="border: 2px solid #db4444; cursor: pointer;" onclick="window.location.href='{{ route('payment.payfast') }}'">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon">
                                    <img src="{{ asset('images/payfast-logo.png') }}" alt="PayFast" style="height: 40px; width: auto;" onerror="this.src='https://placehold.co/80x40/000/fff?text=PayFast'">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">PayFast</h6>
                                    <p class="text-muted small mb-0">Secure online payments</p>
                                </div>
                                <span class="badge bg-success rounded-pill px-3">Active</span>
                                <i class="fas fa-chevron-right text-danger"></i>
                            </div>
                        </div>
                    </div>

                  
                    <div class="col-md-6">
                        <div class="payment-card p-3 rounded-3" style="border: 1px solid #eee;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon" style="width: 60px; height: 40px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">Cash on Delivery</h6>
                                    <p class="text-muted small mb-0">Pay when you receive</p>
                                </div>
                                <span class="badge bg-success rounded-pill px-3">Active</span>
                            </div>
                        </div>
                    </div>

                  
                    <div class="col-md-6">
                        <div class="payment-card p-3 rounded-3" style="border: 1px solid #eee; opacity: 0.7;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon" style="width: 60px; height: 40px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-credit-card fa-2x text-muted"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">Credit / Debit Card</h6>
                                    <p class="text-muted small mb-0">Visa, Mastercard, Amex</p>
                                </div>
                                <span class="badge bg-secondary rounded-pill px-3">Coming Soon</span>
                            </div>
                        </div>
                    </div>

                  
                    <div class="col-md-6">
                        <div class="payment-card p-3 rounded-3" style="border: 1px solid #eee; opacity: 0.7;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon" style="width: 60px; height: 40px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-mobile-alt fa-2x text-muted"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0">Mobile Wallet</h6>
                                    <p class="text-muted small mb-0">JazzCash, EasyPaisa</p>
                                </div>
                                <span class="badge bg-secondary rounded-pill px-3">Coming Soon</span>
                            </div>
                        </div>
                    </div>
                </div>

             
                <div class="alert alert-info mt-4">
                    <i class="fas fa-shield-alt me-2"></i>
                    <strong>PayFast</strong> is our secure payment partner. All transactions are encrypted and secure.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-card {
        transition: all 0.3s ease;
        cursor: default;
    }
    .payment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-color: #db4444 !important;
    }
    .payment-card.active {
        border-color: #db4444 !important;
        background: #fff8f8;
        cursor: pointer;
    }
    .payment-card.active:hover {
        box-shadow: 0 8px 25px rgba(219,68,68,0.15);
        transform: translateY(-4px);
    }
    .payment-card.active .fa-chevron-right {
        animation: bounceRight 1.5s infinite;
    }
    @keyframes bounceRight {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }
    .profile-sidebar {
        position: sticky;
        top: 20px;
    }
    .sidebar-link {
        color: #6c757d;
        font-size: 14px;
        transition: all 0.2s;
    }
    .sidebar-link:hover {
        background: #f8f9fa;
        color: #db4444;
    }
    .sidebar-link.active {
        background: #fff5f5;
        color: #db4444;
    }
    .sidebar-link.active i {
        color: #db4444 !important;
    }
    .avatar {
        box-shadow: 0 3px 10px rgba(219,68,68,0.2);
    }
</style>
@endpush