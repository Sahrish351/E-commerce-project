@extends('layouts.app')

@section('title', 'Change Password - StyleHub')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-key fa-3x text-danger"></i>
                        <h4 class="fw-bold mt-3">Change Password</h4>
                        <p class="text-muted small">Enter your new password below.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- NEW PASSWORD -->
                        <div class="mb-3">
                            <label class="fw-semibold small mb-2">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
                            </div>
                            <small class="text-muted">Password must be at least 8 characters.</small>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="mb-4">
                            <label class="fw-semibold small mb-2">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-check-circle text-muted"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 rounded-pill fw-semibold">
                            <i class="fas fa-save me-2"></i> Change Password
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ route('profile.dashboard') }}" class="text-muted small text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .form-control {
        border-radius: 0 8px 8px 0;
        border-left: none;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #db4444;
    }
    .input-group:focus-within .input-group-text {
        border-color: #db4444;
    }
</style>
@endpush