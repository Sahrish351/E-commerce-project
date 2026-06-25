@extends('admin.layouts.app')

@section('title', 'Add Coupon - StyleHub Admin')

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
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        padding: 28px 30px;
    }
    .form-card .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }
    .form-card .form-control,
    .form-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 14px;
        font-size: 14px;
    }
    .form-card .form-control:focus,
    .form-card .form-select:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.08);
    }
    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #e0e0e0;
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
    .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-plus-circle"></i> Add Coupon</h4>
        <p>Create a new discount coupon</p>
    </div>
    <a href="{{ route('admin.coupons.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="e.g. SUMMER25" required>
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                    </select>
                    @error('discount_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}" step="0.01" min="0" required>
                    @error('discount_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Minimum Order Value</label>
                    <input type="number" name="min_order_value" class="form-control @error('min_order_value') is-invalid @enderror" value="{{ old('min_order_value', 0) }}" step="0.01" min="0">
                    @error('min_order_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Usage Limit</label>
                    <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}" min="1" placeholder="Leave empty for unlimited">
                    @error('usage_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                    @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Coupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn-back" style="margin-left: 10px;">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection