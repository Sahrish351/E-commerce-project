@extends('client.layouts.app')

@section('title', 'My Addresses')

@section('content')
<style>
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
    .page-header-custom .btn-add {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 8px 24px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .page-header-custom .btn-add:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
    }

    .address-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .address-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 22px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        position: relative;
    }
    .address-card:hover {
        border-color: #db4444;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .address-card .default-badge {
        background: #28a745;
        color: #fff;
        padding: 2px 14px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 6px;
    }
    .address-card .address-text {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
        margin: 0;
    }
    .address-card .address-actions {
        margin-top: 12px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .address-card .address-actions .btn-action {
        padding: 4px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .address-card .address-actions .btn-action.delete {
        background: #fce4ec;
        color: #c62828;
    }
    .address-card .address-actions .btn-action.delete:hover {
        background: #dc3545;
        color: #fff;
    }
    .address-card .address-actions .btn-action.default {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .address-card .address-actions .btn-action.default:hover {
        background: #28a745;
        color: #fff;
    }

    .empty-address {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
    }
    .empty-address i {
        font-size: 48px;
        color: #ddd;
        display: block;
        margin-bottom: 12px;
    }
    .empty-address h5 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .empty-address p {
        color: #8c8c9c;
        font-size: 14px;
    }
    .empty-address .btn-add {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 40px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-top: 12px;
    }
    .empty-address .btn-add:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
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

    @media (max-width: 768px) {
        .address-grid { grid-template-columns: 1fr; }
        .page-header-custom { flex-direction: column; align-items: flex-start; }
    }
</style>


<div class="toast-container" id="toastContainer"></div>


<div class="page-header-custom">
    <div>
        <h4><i class="fas fa-map-marker-alt"></i> My Addresses</h4>
        <p>Manage your shipping addresses</p>
    </div>
    <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addAddressModal">
        <i class="fas fa-plus"></i> Add New Address
    </button>
</div>

@if(session('address_success'))
    <div class="alert alert-success">{{ session('address_success') }}</div>
@endif

@if($addresses && $addresses->count() > 0)
    <div class="address-grid">
        @foreach($addresses as $address)
        <div class="address-card">
            @if($address->is_default)
                <span class="default-badge"><i class="fas fa-check-circle"></i> Default</span>
            @endif
            <p class="address-text">
                {{ $address->address_line1 }}
                @if($address->address_line2)
                    <br>{{ $address->address_line2 }}
                @endif
                <br>{{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}
                <br>{{ $address->country }}
            </p>
            <div class="address-actions">
                @if(!$address->is_default)
                <form action="{{ route('client.profile.address.default', $address->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn-action default">
        <i class="fas fa-check"></i> Set Default
    </button>
</form>
                @endif
                <form action="{{ route('client.profile.address.delete', $address->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action delete" onclick="return confirm('Delete this address?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-address">
        <i class="fas fa-map-marker-alt"></i>
        <h5>No Addresses Saved</h5>
        <p>Add your shipping address to make checkout faster.</p>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="fas fa-plus"></i> Add Address
        </button>
    </div>
@endif


<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.1);">
            <div class="modal-header" style="border-bottom:none; padding:20px 24px 0;">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle text-danger me-2"></i> Add Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('client.profile.address.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:20px 24px;">
                    <div class="mb-3">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_default" class="form-check-input" id="isDefault">
                        <label class="form-check-label" for="isDefault">Set as default address</label>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:none; padding:0 24px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="background:#db4444; border:none; border-radius:30px; padding:8px 30px; font-weight:600;">
                        <i class="fas fa-save"></i> Save Address
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

    @if(session('address_success'))
        showToast('{{ session("address_success") }}', 'success');
    @endif
</script>
@endsection