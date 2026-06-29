@extends('admin.layouts.app')

@section('title', 'Settings - StyleHub Admin')

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

    .settings-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .settings-card .card-title {
        font-weight: 700;
        font-size: 18px;
        color: #1a1a2e;
        margin-bottom: 20px;
    }
    .settings-card .card-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .settings-card .form-label {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 14px;
    }
    .settings-card .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .settings-card .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }
    .settings-card .form-control:disabled {
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
    .btn-reset {
        background: transparent;
        color: #666;
        border: 2px solid #e0e0e0;
        padding: 10px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-reset:hover {
        border-color: #db4444;
        color: #db4444;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ccc;
        border-radius: 26px;
        transition: 0.3s;
    }
    .toggle-slider:before {
        content: "";
        position: absolute;
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: 0.3s;
    }
    .toggle-switch input:checked + .toggle-slider {
        background: #db4444;
    }
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(24px);
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
</style>


<div class="toast-container" id="toastContainer"></div>

<div class="page-header">
    <div>
        <h4><i class="fas fa-cog"></i> Settings</h4>
        <p>Manage your store settings and preferences</p>
    </div>
</div>

<div class="settings-card">
    <div class="card-title"><i class="fas fa-globe"></i> General Settings</div>
    <form id="generalSettingsForm" action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Store Name</label>
                    <input type="text" name="store_name" class="form-control" value="{{ config('app.name', 'StyleHub') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Store Email</label>
                    <input type="email" name="store_email" class="form-control" value="{{ config('mail.from.address', 'admin@stylehub.com') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Store Description</label>
                    <textarea name="store_description" class="form-control" rows="2">Your one-stop shop for premium products and accessories.</textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Settings</button>
    </form>
</div>


<div class="settings-card">
    <div class="card-title"><i class="fas fa-credit-card"></i> Payment Settings</div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Currency</label>
                <select class="form-control" name="currency">
                    <option value="USD" selected>USD ($)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="PKR">PKR (Rs)</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Payment Gateway</label>
                <select class="form-control" name="payment_gateway">
                    <option value="payfast" selected>PayFast</option>
                    <option value="stripe">Stripe</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash">Cash on Delivery</option>
                </select>
            </div>
        </div>
    </div>
</div>


<div class="settings-card">
    <div class="card-title"><i class="fas fa-bell"></i> Notification Settings</div>
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="fw-bold">New Orders</div>
                    <small style="color:#8c8c9c;">Send notification when new order placed</small>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="fw-bold">Low Stock Alerts</div>
                    <small style="color:#8c8c9c;">Send notification when stock is low</small>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="fw-bold">New Customer</div>
                    <small style="color:#8c8c9c;">Send notification for new registration</small>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="fw-bold">Email Marketing</div>
                    <small style="color:#8c8c9c;">Send marketing emails</small>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
</div>


<div class="settings-card">
    <div class="card-title"><i class="fas fa-shield-alt"></i> Security Settings</div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Session Timeout (minutes)</label>
                <input type="number" class="form-control" value="60" min="5">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Max Login Attempts</label>
                <input type="number" class="form-control" value="5" min="1">
            </div>
        </div>
    </div>
    <button class="btn-save"><i class="fas fa-save"></i> Save Security Settings</button>
    <button class="btn-reset ms-2" onclick="if(confirm('Reset all settings to default?')){this.closest('.settings-card').querySelector('form').reset();}">
        <i class="fas fa-undo"></i> Reset to Default
    </button>
</div>

@push('scripts')
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


document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.btn-save');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Save Settings';
            showToast('Settings saved successfully!', 'success');
        }, 1500);
    });
});
</script>
@endpush
@endsection