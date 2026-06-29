@extends('client.layouts.app')

@section('title', 'My Profile')

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header-custom h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header-custom h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header-custom p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    /* ===== PROFILE CARDS ===== */
    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 28px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        margin-bottom: 24px;
        transition: all 0.3s;
    }
    .profile-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }
    .profile-card .card-title {
        font-weight: 700;
        font-size: 17px;
        color: #1a1a2e;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-card .card-title i {
        color: #db4444;
        font-size: 20px;
    }
    .profile-card .card-title .badge-optional {
        font-size: 11px;
        font-weight: 400;
        color: #8c8c9c;
        background: #f5f5f5;
        padding: 2px 10px;
        border-radius: 30px;
        margin-left: auto;
    }
    .profile-card .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .profile-card .form-label .required {
        color: #db4444;
        margin-left: 2px;
    }
    .profile-card .form-control {
        border-radius: 10px;
        padding: 10px 16px;
        border: 1.5px solid #e8e8e8;
        font-size: 14px;
        transition: all 0.3s;
        background: #fafafa;
    }
    .profile-card .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219, 68, 68, 0.06);
        background: #fff;
    }
    .profile-card .form-control::placeholder {
        color: #bbb;
    }

    .btn-save {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 32px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .btn-save:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219, 68, 68, 0.2);
    }

    /* ===== TOAST ===== */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast-custom {
        background: #1a1a2e;
        color: #fff;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast-custom.success { border-left: 4px solid #28a745; }
    .toast-custom.error { border-left: 4px solid #dc3545; }
    .toast-custom .close-btn {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
    }
    .toast-custom .close-btn:hover { opacity: 1; }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-card { padding: 18px 16px; }
        .page-header-custom { flex-direction: column; align-items: flex-start; }
        .btn-save { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
        .profile-card .card-title { font-size: 15px; flex-wrap: wrap; }
        .profile-card .card-title .badge-optional { margin-left: 0; }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header-custom">
    <div>
        <h4><i class="fas fa-user-circle"></i> My Profile</h4>
        <p>Manage your account settings and preferences</p>
    </div>
    <div>
        <span class="badge bg-success" style="padding:6px 16px; font-size:13px;">
            <i class="fas fa-check-circle me-1"></i> Active
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">

        <!-- ===== EDIT PROFILE ===== -->
        <div class="profile-card">
            <div class="card-title">
                <i class="fas fa-user-edit"></i> Edit Profile
                <span class="badge-optional">Update your info</span>
            </div>

            @if(session('profile_success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> {{ session('profile_success') }}
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

            <form action="{{ route('client.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $user->phone) }}" placeholder="03XX-XXXXXXX">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- ===== CHANGE PASSWORD ===== -->
        <div class="profile-card">
            <div class="card-title">
                <i class="fas fa-lock"></i> Change Password
                <span class="badge-optional">Secure your account</span>
            </div>

            @if(session('password_success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> {{ session('password_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('client.profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Current Password <span class="required">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">New Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Confirm Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-custom ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <span class="close-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    @if(session('profile_success'))
        showToast('{{ session("profile_success") }}', 'success');
    @endif
    @if(session('password_success'))
        showToast('{{ session("password_success") }}', 'success');
    @endif
</script>
@endsection