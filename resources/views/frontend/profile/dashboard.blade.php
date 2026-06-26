@extends('frontend.layouts.app')

@section('title', 'My Dashboard')

@section('content')
<style>
    /* ========================================
       CLIENT DASHBOARD - UNIQUE STYLES
       ======================================== */
    .client-dashboard {
        background: #f5f7fa;
        padding: 30px 0;
        min-height: 70vh;
    }

    /* ===== PROFILE HEADER CARD ===== */
    .profile-header-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
        border-radius: 20px;
        padding: 30px 35px;
        color: #fff;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
        overflow: hidden;
    }
    .profile-header-card::before {
        content: '';
        position: absolute;
        right: -80px;
        top: -80px;
        width: 300px;
        height: 300px;
        background: rgba(219, 68, 68, 0.08);
        border-radius: 50%;
    }
    .profile-header-card .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1;
    }
    .profile-header-card .avatar-lg {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #db4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 700;
        color: #fff;
        border: 3px solid rgba(255,255,255,0.2);
    }
    .profile-header-card .user-name {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .profile-header-card .user-email {
        color: rgba(255,255,255,0.7);
        font-size: 14px;
    }
    .profile-header-card .user-since {
        font-size: 12px;
        color: rgba(255,255,255,0.4);
        margin-top: 4px;
    }
    .profile-header-card .header-actions {
        display: flex;
        gap: 10px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }
    .profile-header-card .btn-outline-light-custom {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
    }
    .profile-header-card .btn-outline-light-custom:hover {
        background: #db4444;
        border-color: #db4444;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ===== GREETING CARD ===== */
    .greeting-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        border-left: 4px solid #db4444;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .greeting-card h4 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
        font-size: 18px;
    }
    .greeting-card p {
        color: #8c8c9c;
        font-size: 14px;
        margin: 0;
    }

    /* ===== STATS ROW ===== */
    .stat-box {
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .stat-box .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-box .stat-icon.blue { background: #e3f2fd; color: #1976d2; }
    .stat-box .stat-icon.green { background: #e8f5e9; color: #2e7d32; }
    .stat-box .stat-icon.orange { background: #fff3e0; color: #e65100; }
    .stat-box .stat-icon.pink { background: #fce4ec; color: #c62828; }
    .stat-box .stat-icon.purple { background: #f3e5f5; color: #6a1b9a; }

    .stat-box .stat-number {
        font-size: 22px;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .stat-box .stat-label {
        font-size: 13px;
        color: #8c8c9c;
        font-weight: 500;
    }

    /* ===== ORDER STATUS BADGES ===== */
    .status-badge-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .status-badge {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 30px;
        padding: 6px 16px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-badge .dot.pending { background: #ffc107; }
    .status-badge .dot.processing { background: #0d6efd; }
    .status-badge .dot.shipped { background: #17a2b8; }
    .status-badge .dot.delivered { background: #28a745; }
    .status-badge .dot.cancelled { background: #dc3545; }
    .status-badge .count {
        font-weight: 700;
        color: #1a1a2e;
        margin-left: 2px;
    }

    /* ===== QUICK LINKS GRID ===== */
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    .quick-link-item {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 18px 12px;
        text-align: center;
        text-decoration: none;
        color: #1a1a2e;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .quick-link-item:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.15);
    }
    .quick-link-item i {
        font-size: 22px;
        margin-bottom: 6px;
        display: block;
        color: #db4444;
    }
    .quick-link-item:hover i {
        color: #fff;
    }
    .quick-link-item span {
        font-size: 13px;
        font-weight: 500;
    }

    /* ===== RECENT ORDERS ===== */
    .section-title {
        font-weight: 700;
        font-size: 17px;
        color: #1a1a2e;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title i {
        color: #db4444;
    }
    .section-title .view-all {
        margin-left: auto;
        font-size: 13px;
        font-weight: 500;
        color: #db4444;
        text-decoration: none;
    }
    .section-title .view-all:hover {
        text-decoration: underline;
    }

    .order-card {
        background: #fff;
        border-radius: 12px;
        padding: 14px 18px;
        border: 1px solid #f0f0f0;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        transition: all 0.3s;
    }
    .order-card:hover {
        border-color: #db4444;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }
    .order-card .order-id {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 14px;
    }
    .order-card .order-date {
        color: #999;
        font-size: 12px;
    }
    .order-card .order-amount {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 15px;
    }
    .order-card .order-status {
        font-size: 12px;
        font-weight: 500;
        padding: 3px 12px;
        border-radius: 30px;
        text-transform: capitalize;
    }
    .order-card .order-status.pending { background: #fff3cd; color: #856404; }
    .order-card .order-status.processing { background: #cce5ff; color: #004085; }
    .order-card .order-status.shipped { background: #d4edda; color: #155724; }
    .order-card .order-status.delivered { background: #28a745; color: #fff; }
    .order-card .order-status.cancelled { background: #f8d7da; color: #721c24; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .quick-links-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .profile-header-card { flex-direction: column; text-align: center; }
        .profile-header-card .user-info { flex-direction: column; }
        .profile-header-card .header-actions { justify-content: center; }
        .quick-links-grid { grid-template-columns: repeat(2, 1fr); }
        .order-card { flex-direction: column; text-align: center; }
    }
    @media (max-width: 576px) {
        .quick-links-grid { grid-template-columns: 1fr; }
        .stat-box { padding: 14px 16px; }
        .stat-box .stat-number { font-size: 18px; }
    }
</style>

<div class="client-dashboard">
    <div class="container">

        <!-- ===== PROFILE HEADER ===== -->
        <div class="profile-header-card">
            <div class="user-info">
                <div class="avatar-lg">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                    <div class="user-since">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        Member since {{ Auth::user()->created_at->format('F d, Y') }}
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('profile.edit') }}" class="btn-outline-light-custom">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('shop.index') }}" class="btn-outline-light-custom">
                    <i class="fas fa-store"></i> Shop Now
                </a>
            </div>
        </div>

        <!-- ===== GREETING ===== -->
        <div class="greeting-card">
            <h4>👋 Hey {{ Auth::user()->name }}!</h4>
            <p>Here's a quick summary of your activity on StyleHub</p>
        </div>

        <!-- ===== STATS ===== -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                <div class="stat-box">
                    <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
                    <div>
                        <div class="stat-number">{{ $orderStats['total'] ?? 0 }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                <div class="stat-box">
                    <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-number">{{ ($orderStats['pending'] ?? 0) + ($orderStats['processing'] ?? 0) }}</div>
                        <div class="stat-label">Active Orders</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                <div class="stat-box">
                    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-number">{{ $orderStats['delivered'] ?? 0 }}</div>
                        <div class="stat-label">Delivered</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                <div class="stat-box">
                    <div class="stat-icon pink"><i class="fas fa-heart"></i></div>
                    <div>
                        <div class="stat-number">{{ $wishlistCount ?? 0 }}</div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== ORDER STATUS BADGES ===== -->
        <div class="status-badge-group mb-4">
            <span class="status-badge">
                <span class="dot pending"></span> Pending <span class="count">{{ $orderStats['pending'] ?? 0 }}</span>
            </span>
            <span class="status-badge">
                <span class="dot processing"></span> Processing <span class="count">{{ $orderStats['processing'] ?? 0 }}</span>
            </span>
            <span class="status-badge">
                <span class="dot shipped"></span> Shipped <span class="count">{{ $orderStats['shipped'] ?? 0 }}</span>
            </span>
            <span class="status-badge">
                <span class="dot delivered"></span> Delivered <span class="count">{{ $orderStats['delivered'] ?? 0 }}</span>
            </span>
            <span class="status-badge">
                <span class="dot cancelled"></span> Cancelled <span class="count">{{ $orderStats['cancelled'] ?? 0 }}</span>
            </span>
        </div>

        <!-- ===== QUICK LINKS ===== -->
        <div class="quick-links-grid mb-4">
            <a href="{{ route('orders.index') }}" class="quick-link-item">
                <i class="fas fa-shopping-bag"></i>
                <span>My Orders</span>
            </a>
            <a href="{{ route('profile.addresses') }}" class="quick-link-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Addresses</span>
            </a>
            <a href="{{ route('wishlist.index') }}" class="quick-link-item">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
            </a>
            <a href="{{ route('profile.password') }}" class="quick-link-item">
                <i class="fas fa-lock"></i>
                <span>Change Password</span>
            </a>
        </div>

        <!-- ===== RECENT ORDERS ===== -->
        <div class="section-title">
            <i class="fas fa-history"></i> Recent Orders
            <a href="{{ route('orders.index') }}" class="view-all">View All →</a>
        </div>

        @forelse($recentOrders ?? [] as $order)
        <a href="{{ route('orders.show', $order->id) }}" class="order-card text-decoration-none">
            <div>
                <div class="order-id">#{{ $order->order_number ?? $order->id }}</div>
                <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
            </div>
            <div>
                <span class="order-status {{ $order->status ?? 'pending' }}">
                    {{ ucfirst($order->status ?? 'pending') }}
                </span>
            </div>
            <div>
                <div class="order-amount">${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</div>
                <div style="font-size:12px; color:#999;">{{ $order->items_count ?? 0 }} items</div>
            </div>
            <div>
                <i class="fas fa-chevron-right" style="color:#ddd;"></i>
            </div>
        </a>
        @empty
        <div style="background:#fff; border-radius:12px; padding:30px; text-align:center; border:1px solid #f0f0f0;">
            <i class="fas fa-inbox" style="font-size:40px; color:#ddd; display:block; margin-bottom:12px;"></i>
            <p style="color:#8c8c9c; margin:0;">You haven't placed any orders yet.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-danger mt-3" style="border-radius:30px; padding:8px 30px; background:#db4444; border:none;">
                Start Shopping
            </a>
        </div>
        @endforelse

    </div>
</div>
@endsection