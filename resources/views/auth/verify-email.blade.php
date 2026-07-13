<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Verify Email</title>
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
        
        .verify-wrapper {
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08), 0 10px 30px rgba(0, 0, 0, 0.03);
            padding: 45px 40px 40px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }
        
        .verify-wrapper:hover {
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.10), 0 15px 40px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        
        .verify-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .verify-header .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .verify-header .logo span {
            color: #e94560;
        }
        
        .verify-header .icon-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fff5f5 0%, #fdf0f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border: 2px solid #fde8e8;
        }
        
        .verify-header .icon-box i {
            font-size: 34px;
            color: #e94560;
        }
        
        .verify-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        
        .verify-header h2 span {
            color: #e94560;
        }
        
        .verify-header p {
            color: #8888aa;
            font-size: 14px;
            margin-top: 8px;
            font-weight: 400;
            letter-spacing: 0.2px;
            line-height: 1.6;
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
        
        .btn-verify {
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
        
        .btn-verify:hover {
            background: linear-gradient(135deg, #c23152 0%, #a02040 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(233, 69, 96, 0.35);
        }
        
        .btn-verify:active {
            transform: translateY(0);
        }
        
        .btn-verify i {
            font-size: 16px;
        }
        
        .btn-logout {
            background: transparent;
            border: 2px solid #e8e8f0;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            color: #555;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            width: 100%;
            justify-content: center;
        }
        
        .btn-logout:hover {
            border-color: #e94560;
            color: #e94560;
            background: #fff5f5;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 22px 0;
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
        
        /* RESPONSIVE */
        @media (max-width: 576px) {
            .verify-wrapper {
                padding: 30px 22px 28px;
                border-radius: 18px;
            }
            .verify-header .logo {
                font-size: 24px;
            }
            .verify-header h2 {
                font-size: 22px;
            }
            .verify-header p {
                font-size: 13px;
            }
            .verify-header .icon-box {
                width: 65px;
                height: 65px;
            }
            .verify-header .icon-box i {
                font-size: 28px;
            }
            .btn-verify {
                font-size: 14px;
                padding: 13px;
            }
            .btn-logout {
                font-size: 13px;
                padding: 10px 20px;
            }
        }
        
        @media (max-width: 400px) {
            .verify-wrapper {
                padding: 22px 16px 20px;
                border-radius: 14px;
            }
            .verify-header h2 {
                font-size: 18px;
            }
            .verify-header p {
                font-size: 12px;
            }
            .verify-header .icon-box {
                width: 55px;
                height: 55px;
            }
            .verify-header .icon-box i {
                font-size: 22px;
            }
            .btn-verify {
                font-size: 13px;
                padding: 11px;
            }
            .btn-logout {
                font-size: 12px;
                padding: 8px 16px;
            }
            .verify-header .logo {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="verify-wrapper">
        
        <!-- Header -->
        <div class="verify-header">
            <div class="logo">Style<span>Hub</span></div>
            <div class="icon-box">
                <i class="fas fa-envelope"></i>
            </div>
            <h2>Verify <span>Email</span></h2>
            <p>
                Thanks for signing up! Before getting started, could you verify your email address 
                by clicking on the link we just emailed to you?
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <p>A new verification link has been sent to your email address.</p>
            </div>
        @endif

        <!-- Resend Verification Email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-verify">
                <i class="fas fa-paper-plane"></i> Resend Verification Email
            </button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <span>OR</span>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </button>
        </form>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>