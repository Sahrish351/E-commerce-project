<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* ========================================
           GLOBAL STYLES
           ======================================== */
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
        
        /* ========================================
           REGISTER CARD
           ======================================== */
        .register-wrapper {
            max-width: 460px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08), 0 10px 30px rgba(0, 0, 0, 0.03);
            padding: 45px 40px 40px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .register-wrapper:hover {
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.10), 0 15px 40px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        
        /* ========================================
           REGISTER HEADER
           ======================================== */
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            display: inline-block;
            margin-bottom: 6px;
        }
        
        .register-header .logo span {
            color: #e94560;
        }
        
        .register-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .register-header h2 span {
            color: #e94560;
        }
        
        .register-header p {
            color: #8888aa;
            font-size: 14px;
            margin-top: 4px;
            font-weight: 400;
            letter-spacing: 0.2px;
        }
        
        /* ========================================
           FORM
           ======================================== */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #2a2a4a;
            display: block;
            margin-bottom: 5px;
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
            padding: 12px 16px 12px 44px;
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
            margin-top: 4px;
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
        
        /* ========================================
           TERMS CHECKBOX
           ======================================== */
        .terms-checkbox {
            margin: 6px 0 22px;
        }
        
        .terms-checkbox label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #4a4a6a;
            cursor: pointer;
            font-weight: 400;
            line-height: 1.5;
        }
        
        .terms-checkbox input[type="checkbox"] {
            width: 17px;
            height: 17px;
            accent-color: #e94560;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 1px;
            flex-shrink: 0;
        }
        
        .terms-checkbox label a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }
        
        .terms-checkbox label a:hover {
            text-decoration: underline;
        }
        
        /* ========================================
           BUTTONS
           ======================================== */
        .btn-create {
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
        
        .btn-create:hover {
            background: linear-gradient(135deg, #c23152 0%, #a02040 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(233, 69, 96, 0.35);
        }
        
        .btn-create:active {
            transform: translateY(0);
        }
        
        .btn-create i {
            font-size: 16px;
        }
        
        .btn-google {
            background: transparent;
            border: 2px solid #e8e8f0;
            padding: 12px;
            border-radius: 12px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #4a4a6a;
            margin-top: 12px;
            text-decoration: none;
        }
        
        .btn-google:hover {
            border-color: #e94560;
            background: #fdf5f5;
            transform: translateY(-2px);
            text-decoration: none;
        }
        
        .btn-google i {
            font-size: 18px;
            color: #ea4335;
        }
        
        /* ========================================
           DIVIDER
           ======================================== */
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e8f0;
        }
        
        .divider span {
            padding: 0 16px;
            color: #b0b0c8;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        /* ========================================
           LOGIN LINK
           ======================================== */
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #4a4a6a;
        }
        
        .login-link a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            color: #c23152;
            text-decoration: underline;
        }
        
        /* ========================================
           ALERT
           ======================================== */
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
        
        /* ========================================
           RESPONSIVE - ALL DEVICES
           ======================================== */
        
        /* Tablets & Small Laptops */
        @media (max-width: 992px) {
            .register-wrapper {
                max-width: 420px;
                padding: 38px 32px 34px;
            }
            .register-header h2 {
                font-size: 26px;
            }
        }
        
        /* Large Phones & Small Tablets */
        @media (max-width: 768px) {
            body {
                padding: 16px;
                background: #f0f2f5;
            }
            .register-wrapper {
                max-width: 100%;
                padding: 32px 28px 28px;
                border-radius: 20px;
            }
            .register-header .logo {
                font-size: 24px;
            }
            .register-header h2 {
                font-size: 24px;
            }
            .register-header p {
                font-size: 13px;
            }
            .form-control-custom {
                font-size: 14px;
                padding: 11px 14px 11px 42px;
            }
            .btn-create {
                font-size: 14px;
                padding: 13px;
            }
            .btn-google {
                font-size: 14px;
                padding: 11px;
            }
            .form-group {
                margin-bottom: 18px;
            }
            .terms-checkbox {
                margin: 4px 0 18px;
            }
        }
        
        /* Mobile Phones */
        @media (max-width: 576px) {
            body {
                padding: 12px;
                background: #f0f2f5;
            }
            .register-wrapper {
                padding: 24px 18px 22px;
                border-radius: 16px;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            }
            .register-header {
                margin-bottom: 24px;
            }
            .register-header .logo {
                font-size: 22px;
                margin-bottom: 4px;
            }
            .register-header h2 {
                font-size: 22px;
            }
            .register-header p {
                font-size: 12px;
            }
            .form-group {
                margin-bottom: 16px;
            }
            .form-group label {
                font-size: 12px;
                margin-bottom: 4px;
            }
            .form-control-custom {
                font-size: 13px;
                padding: 10px 12px 10px 38px;
                border-radius: 10px;
            }
            .input-wrapper .input-icon {
                font-size: 13px;
                left: 12px;
            }
            .password-toggle {
                font-size: 13px;
                right: 12px;
            }
            .btn-create {
                font-size: 14px;
                padding: 12px;
                border-radius: 10px;
            }
            .btn-create i {
                font-size: 14px;
            }
            .btn-google {
                font-size: 13px;
                padding: 10px;
                border-radius: 10px;
                margin-top: 10px;
            }
            .btn-google i {
                font-size: 16px;
            }
            .divider {
                margin: 16px 0;
            }
            .divider span {
                font-size: 11px;
                padding: 0 12px;
            }
            .terms-checkbox {
                margin: 2px 0 16px;
            }
            .terms-checkbox label {
                font-size: 12px;
                gap: 8px;
            }
            .terms-checkbox input[type="checkbox"] {
                width: 15px;
                height: 15px;
                margin-top: 0;
            }
            .login-link {
                font-size: 13px;
                margin-top: 16px;
            }
            .alert-custom {
                padding: 10px 14px;
                margin-bottom: 16px;
                border-radius: 8px;
            }
            .alert-custom ul {
                font-size: 12px;
            }
            .error-message {
                font-size: 11px;
            }
        }
        
        /* Very Small Phones */
        @media (max-width: 400px) {
            body {
                padding: 8px;
            }
            .register-wrapper {
                padding: 18px 14px 16px;
                border-radius: 12px;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            }
            .register-header .logo {
                font-size: 18px;
            }
            .register-header h2 {
                font-size: 18px;
            }
            .register-header p {
                font-size: 11px;
            }
            .form-group {
                margin-bottom: 14px;
            }
            .form-group label {
                font-size: 11px;
            }
            .form-control-custom {
                font-size: 12px;
                padding: 8px 10px 8px 34px;
                border-radius: 8px;
            }
            .input-wrapper .input-icon {
                font-size: 12px;
                left: 10px;
            }
            .password-toggle {
                font-size: 12px;
                right: 10px;
            }
            .btn-create {
                font-size: 13px;
                padding: 10px;
                border-radius: 8px;
            }
            .btn-create i {
                font-size: 13px;
            }
            .btn-google {
                font-size: 12px;
                padding: 9px;
                border-radius: 8px;
            }
            .btn-google i {
                font-size: 14px;
            }
            .divider {
                margin: 12px 0;
            }
            .divider span {
                font-size: 10px;
                padding: 0 10px;
            }
            .terms-checkbox label {
                font-size: 11px;
            }
            .login-link {
                font-size: 12px;
                margin-top: 14px;
            }
            .alert-custom {
                padding: 8px 12px;
                border-radius: 6px;
            }
            .alert-custom ul {
                font-size: 11px;
                padding-left: 16px;
            }
            .error-message {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- ========================================
         REGISTER CARD - ONLY
         ======================================== -->
    <div class="register-wrapper">
        
        <!-- Register Header -->
        <div class="register-header">
            
            <h2>Create <span>Account</span></h2>
            <p>Please fill in your details to get started</p>
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

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Field -->
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" 
                           class="form-control-custom @error('name') is-invalid @enderror" 
                           placeholder="John Doe" value="{{ old('name') }}" 
                           required autocomplete="name">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" 
                           class="form-control-custom @error('email') is-invalid @enderror" 
                           placeholder="your@email.com" value="{{ old('email') }}" 
                           required autocomplete="email">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                           class="form-control-custom @error('password') is-invalid @enderror" 
                           placeholder="Enter your password" required autocomplete="new-password">
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
                           placeholder="Confirm your password" required autocomplete="new-password">
                </div>
            </div>

            <!-- Terms Checkbox -->
<div class="terms-checkbox">
    <label>
        <input type="checkbox" name="terms" required>
        I agree to the <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and 
        <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
    </label>
</div>

            <!-- Create Account Button -->
            <button type="submit" class="btn-create">
                <i class="fas fa-user-plus"></i> Create Account
            </button>

            <!-- Divider -->
            <div class="divider">
                <span>OR</span>
            </div>

            <!-- Google Button -->
            <a href="{{ route('auth.google.redirect') }}" class="btn-google">
                <i class="fab fa-google"></i> Sign up with Google
            </a>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </div>
        
    </div>

    <!-- ========================================
         SCRIPTS
         ======================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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