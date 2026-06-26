@extends('admin.layouts.app')

@section('title', 'Edit Campaign - StyleHub Admin')

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
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-edit"></i> Edit Campaign</h4>
        <p>Update campaign details</p>
    </div>
    <a href="{{ route('admin.marketing.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.marketing.update', $campaign['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Campaign Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $campaign['name']) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Campaign Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="Email" {{ old('type', $campaign['type']) == 'Email' ? 'selected' : '' }}>Email</option>
                        <option value="Push Notification" {{ old('type', $campaign['type']) == 'Push Notification' ? 'selected' : '' }}>Push Notification</option>
                        <option value="Social Media" {{ old('type', $campaign['type']) == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                        <option value="SMS" {{ old('type', $campaign['type']) == 'SMS' ? 'selected' : '' }}>SMS</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Sent</label>
                    <input type="number" name="sent" class="form-control @error('sent') is-invalid @enderror" value="{{ old('sent', $campaign['sent']) }}" min="0">
                    @error('sent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Opened</label>
                    <input type="number" name="opened" class="form-control @error('opened') is-invalid @enderror" value="{{ old('opened', $campaign['opened']) }}" min="0">
                    @error('opened') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $campaign['status']) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ old('status', $campaign['status']) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="completed" {{ old('status', $campaign['status']) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Campaign
                </button>
                <a href="{{ route('admin.marketing.index') }}" class="btn-back" style="margin-left: 10px;">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection