<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
        }
        
      
        .top-banner {
            background: #000;
            color: #fff;
            font-size: 13px;
            padding: 10px 0;
        }
        
        .top-banner a {
            color: #fff;
            text-decoration: underline;
        }
     
        .navbar {
            padding: 15px 0;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 28px;
            color: #000;
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: #db4444;
        }
        
        .search-bar {
            position: relative;
        }
        
        .search-bar input {
            border-radius: 25px;
            padding: 8px 35px 8px 15px;
            background: #f5f5f5;
            border: none;
            width: 220px;
            font-size: 13px;
        }
        
        .search-bar i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
        }
        
      
        .register-section {
            padding: 50px 0;
            min-height: calc(100vh - 150px);
        }
        
        .register-card {
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .register-title {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .register-subtitle {
            color: #555;
            margin-bottom: 35px;
            font-size: 14px;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            outline: none;
            font-size: 14px;
            background: transparent;
            margin-bottom: 30px;
        }
        
        .form-control-custom:focus {
            border-bottom-color: #db4444;
        }
        
        .btn-create {
            background: #db4444;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 4px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .btn-create:hover {
            background: #c0392b;
        }
        
        .btn-google {
            background: transparent;
            border: 1px solid #db4444;
            padding: 12px;
            border-radius: 4px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            color: #db4444;
        }
        
        .btn-google:hover {
            border-color: #db4444;
            color: #db4444;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        
        .login-link a {
            color: #db4444;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #db4444;
            font-size: 12px;
            margin-top: -25px;
            margin-bottom: 15px;
        }
        
        .form-control-custom.is-invalid {
            border-bottom-color: #db4444;
        }
        
        .terms-checkbox {
            margin-bottom: 25px;
        }
        
        .terms-checkbox label {
            font-size: 13px;
            color: #555;
        }
        
       
        .image-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .image-side img {
            max-width: 100%;
            max-height: 500px;
            object-fit: contain;
        }
        
  
        .main-footer {
            background: #000;
            color: #fff;
            padding: 50px 0 30px;
        }
        
        .main-footer h5 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .main-footer ul {
            list-style: none;
            padding: 0;
        }
        
        .main-footer li {
            margin-bottom: 10px;
        }
        
        .main-footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .main-footer a:hover {
            color: #db4444;
        }
        
        .social-icons a {
            color: #fff;
            margin-right: 15px;
            font-size: 18px;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #db4444;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            z-index: 999;
        }
        
        @media (max-width: 768px) {
            .register-title { font-size: 28px; }
            .register-section { padding: 30px 0; }
            .image-side { display: none; }
        }
    </style>
</head>
<body>


    <div class="top-banner">
        <div class="container text-center">
            <span>🔥 Summer Sale Is Live! Up to 50% off on Fashion & Tech Accessories - </span>
            <a href="{{ route('shop.index') }}">Shop Now →</a>
        </div>
    </div>


    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">StyleHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="search-bar me-3">
                        <input type="text" id="searchInput" placeholder="What are you looking for?">
                        <i class="fas fa-search"></i>
                    </div>
                    <a href="{{ route('wishlist.index') }}" class="text-dark me-3 position-relative">
                        <i class="far fa-heart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="wishlistCount" style="font-size: 10px;">0</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-dark position-relative">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="font-size: 10px;">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

   
    <div class="container register-section">
        <div class="row align-items-center">
           
            <div class="col-lg-6 image-side">
                <img src="{{ asset('images/login.jpg') }}" alt="Sign Up Illustration">
            </div>

          
            <div class="col-lg-6">
                <div class="register-card">
                    <h2 class="register-title">Create an account</h2>
                    <p class="register-subtitle">Enter your details below</p>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 mb-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                      
                        <div class="form-floating-custom">
                            <input type="text" name="name" class="form-control-custom @error('name') is-invalid @enderror" 
                                   placeholder="Name" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating-custom">
                            <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" 
                                   placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating-custom">
                            <input type="password" name="password" class="form-control-custom @error('password') is-invalid @enderror" 
                                   placeholder="Password" required autocomplete="new-password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                    
                        <div class="form-floating-custom">
                            <input type="password" name="password_confirmation" class="form-control-custom" 
                                   placeholder="Confirm Password" required autocomplete="new-password">
                        </div>

                        <div class="terms-checkbox">
                            <label class="d-flex align-items-center gap-2">
                                <input type="checkbox" name="terms" required>
                                <span>I agree to the <a href="#" class="text-danger">Terms & Conditions</a></span>
                            </label>
                        </div>

                        <button type="submit" class="btn-create">Create Account</button>

                        <a href="{{ route('auth.google.redirect') }}" class="btn-google">
    <i class="fab fa-google"></i> Sign up with Google
</a>

                        <div class="login-link">
                            Already have account? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>StyleHub</h5>
                    <h6 class="mt-3">Subscribe</h6>
                    <p class="small">Get 10% off your first order</p>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm bg-transparent text-white border-white" 
                               placeholder="Enter your email">
                        <button class="btn btn-sm btn-outline-light" type="button"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Support</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Fashion Street, Mumbai</li>
                        <li><i class="fas fa-envelope me-2"></i> <a href="mailto:support@stylehub.com">support@stylehub.com</a></li>
                        <li><i class="fas fa-phone-alt me-2"></i> +91-98765-43210</li>
                        <li><i class="fas fa-clock me-2"></i> 10:00 AM - 10:00 PM</li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="{{ route('register') }}">Login / Register</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                        <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Link</h5>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms Of Use</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Follow Us</h5>
                    <div class="social-icons mt-3">
                        <a href="#" class="d-block mb-2"><i class="fab fa-facebook-f me-2"></i> Facebook</a>
                        <a href="#" class="d-block mb-2"><i class="fab fa-twitter me-2"></i> Twitter</a>
                        <a href="#" class="d-block mb-2"><i class="fab fa-instagram me-2"></i> Instagram</a>
                        <a href="#" class="d-block mb-2"><i class="fab fa-linkedin-in me-2"></i> LinkedIn</a>
                        <a href="#" class="d-block mb-2"><i class="fab fa-youtube me-2"></i> YouTube</a>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center small">
                © Copyright 2022. All rights reserved.
            </div>
        </div>
    </footer>

  
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#backToTop').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 500);
        });
        
        $.get('{{ url("/cart/count") }}', function(data) { $('#cartCount').text(data.count); });
        $.get('{{ url("/wishlist/count") }}', function(data) { $('#wishlistCount').text(data.count); });
    </script>
</body>
</html>