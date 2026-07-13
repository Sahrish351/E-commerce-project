<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf1 50%, #f0f2f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .reset-wrapper {
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08), 0 10px 30px rgba(0, 0, 0, 0.03);
            padding: 45px 40px 40px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .reset-wrapper:hover {
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.10), 0 15px 40px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        
        .reset-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .reset-header .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .reset-header .logo span {
            color: #e94560;
        }
        
        .reset-header .icon-box {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #fff5f5 0%, #fdf0f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border: 2px solid #fde8e8;
        }
        
        .reset-header .icon-box i {
            font-size: 28px;
            color: #e94560;
        }
        
        .reset-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        
        .reset-header h2 span {
            color: #e94560;
        }
        
        .reset-header p {
            color: #8888aa;
            font-size: 14px;
            margin-top: 4px;
            font-weight: 400;
            letter-spacing: 0.2px;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #2a2a4a;
            display: block;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }
        
        .form-group label .required {
            color: #e94560;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaaacc;
            font-size: 15px;
            transition: color 0.3s;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 2px solid #e8e8f0;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #f8f9fc;
            transition: all 0.3s;
            color: #1a1a2e;
            font-weight: 400;
        }
        
        .form-control-custom::placeholder {
            color: #b0b0c8;
            font-weight: 400;
        }
        
        .form-control-custom:focus {
            border-color: #e94560;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.06);
        }
        
        .form-control-custom.is-invalid {
            border-color: #dc3545;
            background: #fff8f8;
        }
        
        .form-control-custom.is-invalid + .input-icon {
            color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0b0c8;
            cursor: pointer;
            font-size: 15px;
            padding: 0;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #e94560;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, #e94560 0%, #c23152 100%);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 15px rgba(233, 69, 96, 0.2);
        }
        
        .btn-reset:hover {
            background: linear-gradient(135deg, #c23152 0%, #a02040 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(233, 69, 96, 0.35);
        }
        
        .btn-reset:active {
            transform: translateY(0);
        }
        
        .btn-reset i {
            font-size: 16px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #8888aa;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-link a:hover {
            color: #e94560;
        }
        
        .alert-custom {
            background: #fff5f5;
            border-left: 4px solid #e94560;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .alert-custom ul {
            margin: 0;
            padding-left: 20px;
            color: #dc3545;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
        }
        
        /* RESPONSIVE */
        @media (max-width: 576px) {
            .reset-wrapper {
                padding: 30px 22px 28px;
                border-radius: 18px;
            }
            .reset-header .logo {
                font-size: 24px;
            }
            .reset-header h2 {
                font-size: 22px;
            }
            .reset-header p {
                font-size: 13px;
            }
            .reset-header .icon-box {
                width: 60px;
                height: 60px;
            }
            .reset-header .icon-box i {
                font-size: 24px;
            }
            .form-control-custom {
                font-size: 13px;
                padding: 11px 12px 11px 40px;
            }
            .btn-reset {
                font-size: 14px;
                padding: 13px;
            }
        }
        
        @media (max-width: 400px) {
            .reset-wrapper {
                padding: 22px 16px 20px;
                border-radius: 14px;
            }
            .reset-header h2 {
                font-size: 18px;
            }
            .reset-header p {
                font-size: 12px;
            }
            .reset-header .icon-box {
                width: 50px;
                height: 50px;
            }
            .reset-header .icon-box i {
                font-size: 20px;
            }
            .form-control-custom {
                font-size: 12px;
                padding: 9px 10px 9px 36px;
            }
            .btn-reset {
                font-size: 13px;
                padding: 11px;
            }
            .reset-header .logo {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="reset-wrapper">
        
        <!-- Header -->
        <div class="reset-header">
            <div class="logo">Style<span>Hub</span></div>
            <div class="icon-box">
                <i class="fas fa-lock"></i>
            </div>
            <h2>Reset <span>Password</span></h2>
            <p>Enter your new password below</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert-custom">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Field -->
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" 
                           class="form-control-custom @error('email') is-invalid @enderror" 
                           placeholder="your@email.com" value="{{ $request->email ?? old('email') }}" 
                           required autocomplete="email">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- New Password Field -->
            <div class="form-group">
                <label>New Password <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                           class="form-control-custom @error('password') is-invalid @enderror" 
                           placeholder="Enter new password" required autocomplete="new-password">
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label>Confirm Password <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-check-circle input-icon"></i>
                    <input type="password" name="password_confirmation" id="passwordConfirm"
                           class="form-control-custom" 
                           placeholder="Confirm new password" required autocomplete="new-password">
                </div>
            </div>

            <!-- Reset Button -->
            <button type="submit" class="btn-reset">
                <i class="fas fa-sync-alt"></i> Reset Password
            </button>

            <!-- Back to Login -->
            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </form>
        
    </div>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>