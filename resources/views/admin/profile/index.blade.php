@extends('admin.layouts.app')

@section('title', 'My Profile - StyleHub Admin')

@section('page-title', 'My Profile')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    .profile-avatar-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .profile-avatar-card .avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #db4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 700;
        color: #fff;
        margin: 0 auto 15px;
    }
    .profile-avatar-card .name {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
    }
    .profile-avatar-card .email {
        color: #8c8c9c;
        font-size: 14px;
    }
    .profile-avatar-card .badge-role {
        background: #db4444;
        padding: 4px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        display: inline-block;
        margin-top: 8px;
    }

    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .profile-card .card-title {
        font-weight: 700;
        font-size: 18px;
        color: #1a1a2e;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }
    .profile-card .card-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .profile-card .form-label {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 14px;
    }
    .profile-card .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .profile-card .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }
    .profile-card .form-control:disabled {
        background: #f8f9fa;
    }
    .btn-save {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-save:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(219, 68, 68, 0.3);
    }
    .info-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-row .label {
        width: 130px;
        color: #8c8c9c;
        font-weight: 500;
        font-size: 14px;
    }
    .info-row .value {
        color: #1a1a2e;
        font-weight: 500;
        font-size: 14px;
    }
    .info-row .value i {
        color: #28a745;
        font-size: 10px;
        margin-right: 4px;
    }

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
        padding: 15px 20px;
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

    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
            gap: 4px;
        }
        .info-row .label {
            width: 100%;
        }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-user-circle"></i> My Profile</h4>
        <p>Manage your account settings and preferences</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column - Avatar & Info -->
    <div class="col-md-4">
        <!-- Avatar Card -->
        <div class="profile-avatar-card">
            <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="name">{{ auth()->user()->name }}</div>
            <div class="email">{{ auth()->user()->email }}</div>
            <span class="badge-role">Administrator</span>
            <div class="mt-2">
                <span style="color:#28a745; font-size:13px;">
                    <i class="fas fa-circle" style="font-size:8px;"></i> Active
                </span>
            </div>
        </div>

        <!-- Info Card -->
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-info-circle"></i> Account Details</div>
            <div class="info-row">
                <span class="label">Full Name</span>
                <span class="value">{{ auth()->user()->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email</span>
                <span class="value">{{ auth()->user()->email }}</span>
            </div>
            <div class="info-row">
                <span class="label">Role</span>
                <span class="value">Administrator</span>
            </div>
            <div class="info-row">
                <span class="label">Joined</span>
                <span class="value">{{ auth()->user()->created_at->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status</span>
                <span class="value"><i class="fas fa-circle"></i> Active</span>
            </div>
        </div>
    </div>

    <!-- Right Column - Edit Form -->
    <div class="col-md-8">
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-edit"></i> Edit Profile</div>
            
            <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="card-title" style="font-size:16px; margin-top:10px; border-bottom: none; padding-bottom:0;">
                    <i class="fas fa-lock" style="color:#db4444;"></i> Change Password
                </div>
                <p style="font-size:13px; color:#8c8c9c; margin-bottom:15px;">Leave blank to keep current password</p>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    
    const submitBtn = form.querySelector('.btn-save');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            let errorMsg = 'Error updating profile';
            if (data.errors) {
                errorMsg = Object.values(data.errors).flat().join(', ');
            }
            showToast(errorMsg, 'error');
        }
    })
    .catch(error => {
        showToast('Error updating profile. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Update Profile';
    });
});

function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
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
</script>
@endpush
@endsection