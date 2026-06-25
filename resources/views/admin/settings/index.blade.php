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
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        padding: 24px 28px;
        margin-bottom: 24px;
    }
    .settings-card .card-title {
        font-weight: 600;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .settings-card .card-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .settings-card .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }
    .settings-card .form-control,
    .settings-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 14px;
        font-size: 14px;
    }
    .settings-card .form-control:focus,
    .settings-card .form-select:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.08);
    }
    .btn-submit {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.3);
        color: #fff;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .settings-card {
            padding: 16px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-cog"></i> Settings</h4>
        <p>Manage store settings</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="settings-card">
            <div class="card-title"><i class="fas fa-store"></i> General Settings</div>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Store Name</label>
                    <input type="text" name="store_name" class="form-control" value="StyleHub">
                </div>
                <div class="mb-3">
                    <label class="form-label">Store Email</label>
                    <input type="email" name="store_email" class="form-control" value="admin@stylehub.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="$">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="settings-card">
            <div class="card-title"><i class="fas fa-truck"></i> Shipping Settings</div>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Free Shipping Threshold</label>
                    <input type="number" name="free_shipping_threshold" class="form-control" value="500">
                </div>
                <div class="mb-3">
                    <label class="form-label">Standard Shipping Fee</label>
                    <input type="number" name="shipping_fee" class="form-control" value="50" step="0.01">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="settings-card">
            <div class="card-title"><i class="fas fa-ticket"></i> Coupon Settings</div>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Max Discount Percentage</label>
                    <input type="number" name="max_discount" class="form-control" value="50">
                </div>
                <div class="mb-3">
                    <label class="form-label">Coupon Expiry Days</label>
                    <input type="number" name="coupon_expiry_days" class="form-control" value="30">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="settings-card">
            <div class="card-title"><i class="fas fa-palette"></i> Appearance</div>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Primary Color</label>
                    <input type="color" name="primary_color" class="form-control" value="#db4444" style="height: 50px;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection