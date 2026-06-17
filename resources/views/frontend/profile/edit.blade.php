@extends('layouts.app')

@section('title', 'Edit Profile - StyleHub')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
<div class="col-md-3 mb-4">
    <div class="profile-sidebar p-3 rounded-3" style="background: #fff; border: 1px solid #eee;">
        <!-- User Info -->
        <div class="text-center pb-3 border-bottom">
            <div class="avatar mx-auto mb-2" style="width: 70px; height: 70px; background: #db4444; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span class="text-white fw-bold fs-3">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
            <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
        </div>

        <!-- Sidebar Menu -->
        <div class="mt-3">
            <!-- Dashboard - Normal style -->
            <a href="{{ route('profile.dashboard') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-2 text-decoration-none">
                <i class="fas fa-th-large" style="width: 18px; font-size: 13px;"></i>
                <span class="small fw-semibold">Dashboard</span>
            </a>

            <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">Manage My Account</h6>
            <a href="{{ route('profile.edit') }}" class="sidebar-link active d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                <i class="fas fa-user" style="width: 18px; font-size: 13px;"></i>
                <span class="small">My Profile</span>
            </a>
            <a href="{{ route('profile.addresses') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                <i class="fas fa-map-marker-alt" style="width: 18px; font-size: 13px;"></i>
                <span class="small">Address Book</span>
            </a>
            <a href="#" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                <i class="fas fa-credit-card" style="width: 18px; font-size: 13px;"></i>
                <span class="small">My Payment Options</span>
            </a>

            <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Orders</h6>
            <a href="{{ route('profile.orders') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                <i class="fas fa-undo" style="width: 18px; font-size: 13px;"></i>
                <span class="small">My Returns</span>
            </a>
            <a href="#" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
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

        <!-- Main Content - Edit Profile Form -->
        <div class="col-md-9">
            <div class="profile-content p-4 rounded-3" style="background: #fff; border: 1px solid #eee;">
                <h5 class="fw-bold mb-4">Edit Your Profile</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- First Name & Last Name Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold small mb-1">First Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold small mb-1">Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter last name">
                        </div>
                    </div>

                    <!-- Email & Address Row -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-semibold small mb-1">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled style="background: #f8f9fa;">
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold small mb-1">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address ?? '') }}" placeholder="Enter your address">
                        </div>
                    </div>

                    <hr>

                    <!-- Password Changes Section -->
                    <h6 class="fw-bold mb-3">Password Changes</h6>

                    <div class="mb-3">
                        <label class="fw-semibold small mb-1">Current Password</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold small mb-1">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold small mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill">Save Changes</button>
                        <a href="{{ route('profile.dashboard') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Cancel</a>
                    </div>
                </form>
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
    
    /* Dashboard Link Style */
    .sidebar-link[style*="background: #db4444"]:hover {
        background: #c0392b !important;
    }
    
    .profile-content {
        min-height: 500px;
    }
    
    .form-control:focus {
        border-color: #db4444;
        box-shadow: none;
    }
    
    .avatar {
        box-shadow: 0 3px 10px rgba(219,68,68,0.2);
    }
</style>
@endpush