@extends('layouts.app')

@section('title', 'Reset Password - StyleHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock fa-3x text-danger"></i>
                        <h4 class="fw-bold mt-3">Reset Password</h4>
                        <p class="text-muted small">Enter your new password below.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                  
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label class="fw-semibold small mb-2">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   value="{{ $request->email ?? old('email') }}" placeholder="Enter your email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold small mb-2">New Password</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   placeholder="Enter new password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold small mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" 
                                   placeholder="Confirm new password" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill fw-semibold">
                            Reset Password
                        </button>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection