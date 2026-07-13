<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Forgot Password</title>
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
           FORGOT PASSWORD CARD - ONLY
           ======================================== */
        .forgot-wrapper {
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08), 0 10px 30px rgba(0, 0, 0, 0.03);
            padding: 45px 40px 40px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .forgot-wrapper:hover {
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.10), 0 15px 40px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        
        /* ========================================
           HEADER
           ======================================== */
        .forgot-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .forgot-header .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .forgot-header .logo span {
            color: #e94560;
        }
        
        .forgot-header .icon-box {
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
        
        .forgot-header .icon-box i {
            font-size: 28px;
            color: #e94560;
        }
        
        .forgot-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        
        .forgot-header h2 span {
            color: #e94560;
        }
        
        .forgot-header p {
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
            margin-bottom: 24px;
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
        
        /* ========================================
           BUTTONS
           ======================================== */
        .btn-send {
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
        
        .btn-send:hover {
            background: linear-gradient(135deg, #c23152 0%, #a02040 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(233, 69, 96, 0.35);
        }
        
        .btn-send:active {
            transform: translateY(0);
        }
        
        .btn-send i {
            font-size: 16px;
        }
        
        /* ========================================
           BACK TO LOGIN
           ======================================== */
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
        
        .alert-success-custom {
            background: #f0faf5;
            border-left: 4px solid #00a651;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .alert-success-custom i {
            color: #00a651;
            font-size: 20px;
        }
        
        .alert-success-custom p {
            margin: 0;
            color: #1a6e3a;
            font-size: 14px;
            font-weight: 500;
        }
        
        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 576px) {
            body {
                padding: 15px;
                background: #f0f2f5;
            }
            .forgot-wrapper {
                padding: 30px 22px 28px;
                border-radius: 18px;
            }
            .forgot-header .logo {
                font-size: 24px;
            }
            .forgot-header h2 {
                font-size: 22px;
            }
            .forgot-header p {
                font-size: 13px;
            }
            .forgot-header .icon-box {
                width: 60px;
                height: 60px;
            }
            .forgot-header .icon-box i {
                font-size: 24px;
            }
            .form-control-custom {
                font-size: 13px;
                padding: 11px 12px 11px 40px;
            }
            .btn-send {
                font-size: 14px;
                padding: 13px;
            }
        }
        
        @media (max-width: 400px) {
            .forgot-wrapper {
                padding: 22px 16px 20px;
                border-radius: 14px;
            }
            .forgot-header h2 {
                font-size: 18px;
            }
            .forgot-header p {
                font-size: 12px;
            }
            .forgot-header .icon-box {
                width: 50px;
                height: 50px;
            }
            .forgot-header .icon-box i {
                font-size: 20px;
            }
            .form-control-custom {
                font-size: 12px;
                padding: 9px 10px 9px 36px;
            }
            .btn-send {
                font-size: 13px;
                padding: 11px;
            }
            .forgot-header .logo {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- ========================================
         FORGOT PASSWORD CARD - ONLY
         ======================================== -->
    <div class="forgot-wrapper">
        
        <!-- Header -->
        <div class="forgot-header">
            
            <h2>Forgot <span>Password?</span></h2>
            <p>Enter your email address and we'll send you a link to reset your password.</p>
        </div>

        <!-- Success Message -->
        @if(session('status'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <p>{{ session('status') }}</p>
            </div>
        @endif

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
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

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

            <!-- Send Button -->
            <button type="submit" class="btn-send">
                <i class="fas fa-paper-plane"></i> Send Reset Link
            </button>

            <!-- Back to Login -->
            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </form>
        
    </div>

    <!-- ========================================
         SCRIPTS
         ======================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>