@extends('layouts.app')

@section('title', 'My Dashboard - StyleHub')

@section('content')
<div class="container py-4">
   
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner p-4 rounded-3" style="background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h4 class="text-white fw-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                        <p class="text-white-50 mb-0 small">Here's what's happening with your account today.</p>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> Verified Account
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
       
        <div class="col-lg-3">
            <div class="profile-sidebar p-3 rounded-3" style="background: #fff; border: 1px solid #eee;">
             
                <div class="text-center pb-3 border-bottom">
                    <div class="avatar mx-auto mb-2" style="width: 70px; height: 70px; background: #db4444; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white fw-bold fs-3">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                </div>

             
                <div class="mt-3">
                  
                    <a href="{{ route('profile.dashboard') }}" class="sidebar-link active d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-tachometer-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Dashboard</span>
                    </a>

                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">Manage My Account</h6>
                    <a href="{{ route('profile.edit') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-user" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Profile</span>
                    </a>
                    <a href="{{ route('profile.addresses') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-map-marker-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Address Book</span>
                    </a>
                    <a href="{{ route('profile.payment') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-credit-card" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Payment Options</span>
                    </a>

                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Orders</h6>

<a href="{{ route('orders.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
    <i class="fas fa-box" style="width: 18px; font-size: 13px;"></i>
    <span class="small">My Orders</span>
</a>

<a href="{{ route('orders.returns') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
    <i class="fas fa-undo" style="width: 18px; font-size: 13px;"></i>
    <span class="small">My Returns</span>
</a>

<a href="{{ route('orders.cancellations') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
    <i class="fas fa-times-circle" style="width: 18px; font-size: 13px;"></i>
    <span class="small">My Cancellations</span>
</a>

                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Wishlist</h6>
                    <a href="{{ route('wishlist.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
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

       
        <div class="col-lg-9">
           
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stats-card p-3 rounded-3 text-center" style="background: #fff; border: 1px solid #e8e8e8; transition: all 0.3s;">
                        <div class="stats-icon mb-2">
                            <i class="fas fa-shopping-bag fa-2x" style="color: #db4444;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                        <p class="text-muted small mb-0">Total Orders</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-3 rounded-3 text-center" style="background: #fff; border: 1px solid #e8e8e8;">
                        <div class="stats-icon mb-2">
                            <i class="fas fa-wallet fa-2x" style="color: #db4444;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">${{ number_format($totalSpent, 2) }}</h3>
                        <p class="text-muted small mb-0">Total Spent</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-3 rounded-3 text-center" style="background: #fff; border: 1px solid #e8e8e8;">
                        <div class="stats-icon mb-2">
                            <i class="fas fa-heart fa-2x" style="color: #db4444;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $wishlistCount }}</h3>
                        <p class="text-muted small mb-0">Wishlist Items</p>
                    </div>
                </div>
            </div>

          
            <div class="recent-orders p-3 rounded-3" style="background: #fff; border: 1px solid #e8e8e8;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color: #1a1a2e;">
                        <i class="fas fa-clock me-2" style="color: #db4444;"></i>Recent Orders
                    </h6>
                    <a href="{{ route('orders.index') }}" class="text-decoration-none small fw-semibold" style="color: #db4444;">
    View All <i class="fas fa-arrow-right ms-1"></i>
</a>
                </div>

                @if(count($recentOrders) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th class="small py-2 text-muted fw-medium">Order ID</th>
                                    <th class="small py-2 text-muted fw-medium">Date</th>
                                    <th class="small py-2 text-muted fw-medium">Status</th>
                                    <th class="small py-2 text-muted fw-medium">Total</th>
                                    <th class="small py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="small fw-medium">#{{ substr($order->order_number, 0, 10) }}</td>
                                    <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                    <td>
                                        @php
    $statusClass = 'secondary';
    if($order->status == 'delivered') $statusClass = 'success';  
    elseif($order->status == 'pending') $statusClass = 'warning';
    elseif($order->status == 'cancelled') $statusClass = 'danger';
    elseif($order->status == 'processing') $statusClass = 'info';
    elseif($order->status == 'shipped') $statusClass = 'primary';
    elseif($order->status == 'refunded') $statusClass = 'warning';  
@endphp
                                        <span class="badge bg-{{ $statusClass }} px-2 py-1 rounded-pill" style="font-size: 10px; font-weight: 500;">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td class="small fw-semibold">${{ number_format($order->total ?? 0, 2) }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="text-decoration-none small" style="color: #db4444;">
                                            View <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted small mb-0">No orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-danger btn-sm mt-3 px-4 rounded-pill">
                            Start Shopping <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            </div>

           
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <a href="{{ route('shop.index') }}" class="quick-action-block d-block p-3 rounded-3 text-center text-decoration-none" style="background: #fff; border: 1px solid #e8e8e8;">
                        <i class="fas fa-store fa-lg mb-2" style="color: #db4444;"></i>
                        <div class="small fw-semibold" style="color: #1a1a2e;">Continue Shopping</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('wishlist.index') }}" class="quick-action-block d-block p-3 rounded-3 text-center text-decoration-none" style="background: #fff; border: 1px solid #e8e8e8;">
                        <i class="fas fa-heart fa-lg mb-2" style="color: #db4444;"></i>
                        <div class="small fw-semibold" style="color: #1a1a2e;">View Wishlist</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('profile.addresses') }}" class="quick-action-block d-block p-3 rounded-3 text-center text-decoration-none" style="background: #fff; border: 1px solid #e8e8e8;">
                        <i class="fas fa-map-marker-alt fa-lg mb-2" style="color: #db4444;"></i>
                        <div class="small fw-semibold" style="color: #1a1a2e;">Manage Addresses</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
   
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
    
 
    .stats-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 12px !important;
    }
    .stats-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(219,68,68,0.12);
        border-color: #db4444 !important;
    }
    
   
    .recent-orders {
        transition: all 0.3s ease;
        border-radius: 12px !important;
    }
    .recent-orders:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border-color: #db4444 !important;
    }
    
   
    .quick-action-block {
        transition: all 0.3s ease;
        border-radius: 12px !important;
    }
    .quick-action-block:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(219,68,68,0.10);
        border-color: #db4444 !important;
        background: #fff5f5 !important;
    }
    
    .avatar {
        box-shadow: 0 3px 10px rgba(219,68,68,0.2);
    }
    
  
    .bg-warning { background: #ffc107 !important; color: #000 !important; }
    .bg-info { background: #0dcaf0 !important; color: #000 !important; }
    .bg-primary { background: #0d6efd !important; color: #fff !important; }
    .bg-success { background: #198754 !important; color: #fff !important; }
    .bg-danger { background: #dc3545 !important; color: #fff !important; }
    .bg-secondary { background: #6c757d !important; color: #fff !important; }
</style>
@endpush