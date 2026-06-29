<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - @yield('title', 'Fashion & Tech Accessories')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            color: #333;
        }
        
        /* ========================================
           TOP BANNER
           ======================================== */
        .top-banner {
            background: #000;
            color: #fff;
            font-size: 13px;
            padding: 10px 0;
        }
        
        .top-banner a {
            color: #fff;
            text-decoration: underline;
            font-weight: 500;
        }
        
        /* ========================================
           NAVBAR
           ======================================== */
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
        
        /* Search Bar */
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
        
        /* ========================================
           MAIN FOOTER - BLACK BACKGROUND
           ======================================== */
        .main-footer {
            background: #000;
            width: 100%;
            padding: 50px 0 20px;
            margin: 0;
        }
        
        .main-footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .main-footer h5 {
            color: #fff;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .main-footer h6 {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .main-footer p {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 15px;
        }
        
        /* Footer Lists */
        .main-footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .main-footer ul li {
            color: #aaa;
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        /* Footer Links - WHITE, NO BLUE */
        .main-footer ul li a {
            color: #ccc !important;
            text-decoration: none !important;
            transition: color 0.3s;
        }
        
        .main-footer ul li a:hover {
            color: #db4444 !important;
        }
        
        /* Subscribe Form */
        .subscribe-form {
            display: flex;
            max-width: 250px;
        }
        
        .subscribe-form input {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 4px 0 0 4px;
            flex: 1;
        }
        
        .subscribe-form input::placeholder {
            color: #888;
        }
        
        .subscribe-form button {
            background: #fff;
            border: none;
            padding: 0 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .subscribe-form button i {
            color: #000;
            font-size: 14px;
        }
        
        .subscribe-form button:hover {
            background: #db4444;
        }
        
        .subscribe-form button:hover i {
            color: #fff;
        }
        
        /* Subscribe Input Group (Alternative) */
        .main-footer .input-group input {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            font-size: 18px;
        }
        
        .main-footer .input-group input::placeholder {
            color: #888;
        }
        
        .main-footer .input-group button {
            background: #fff;
            border: none;
        }
        
        .main-footer .input-group button i {
            color: #000;
        }
        
        .main-footer .input-group button:hover {
            background: #db4444;
        }
        
        .main-footer .input-group button:hover i {
            color: #fff;
        }
        
        /* Social Icons */
        .social-icons {
            margin-top: 15px;
        }
        
        .social-icons a {
            display: inline-block;
            width: 32px;
            height: 32px;
            background: #222;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            margin-right: 8px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            background: #db4444;
            transform: translateY(-3px);
        }
        
        /* For text social links (Facebook, Twitter etc as text) */
        .social-icons .d-block {
            background: transparent;
            width: auto;
            height: auto;
            line-height: normal;
            text-align: left;
            color: #ccc !important;
        }
        
        .social-icons .d-block:hover {
            background: transparent;
            color: #db4444 !important;
            transform: none;
        }
        
        /* Divider */
        .main-footer hr {
            border-color: #333;
            margin: 20px 0;
        }
        
        /* Copyright */
        .copyright {
            text-align: center;
            font-size: 15px;
            color: #aaa;
        }
        
        /* ========================================
           BACK TO TOP BUTTON - RIGHT SIDE
           ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            left: auto;
            background: #db4444;
            color: #fff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            z-index: 999;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .back-to-top:hover {
            background: #c0392b;
            transform: translateY(-3px);
            color: #fff;
        }
        
        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .main-footer {
                text-align: center;
            }
            
            .subscribe-form {
                margin: 0 auto;
            }
            
            .social-icons {
                margin-bottom: 20px;
            }
            
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
<!-- 
    <! ========================================
         TOP BANNER
         ======================================== -->
    <div class="top-banner">
        <div class="container text-center">
            <span>🔥 Summer Sale Is Live! Up to 50% off on Fashion & Tech Accessories - </span>
            <a href="{{ route('shop.index') }}">Shop Now →</a>
        </div>
    </div>

    <!-- ========================================
         NAVBAR
         ======================================== -->
    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">StyleHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    @if(!auth()->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
                    @endif
                </ul>
                <div class="d-flex align-items-center">
                    <div class="search-bar me-3">
                        <input type="text" id="searchInput" placeholder="Search products...">
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
                    @if(auth()->check())
                        <a href="{{ route('client.dashboard') }}" class="ms-3 text-dark">
                            <i class="fas fa-user-circle fs-5"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav> 

    <!-- ========================================
         MAIN CONTENT (Different for each page)
         ======================================== -->
    <main>
        @yield('content')
    </main>

    <!-- ========================================
         MAIN FOOTER - BLACK BACKGROUND (SAB PAGES PE)
         ======================================== -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <!-- Column 1: StyleHub -->
                <div class="col-md-3 mb-4">
                    <h5>StyleHub</h5>
                    <h6 class="mt-3">Subscribe</h6>
                    <p class="small">Get 10% off your first order</p>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm bg-transparent text-white border-white" 
                               placeholder="Enter your email">
                        <button class="btn btn-sm btn-outline-light" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Column 2: Support -->
                <div class="col-md-3 mb-4">
                    <h5>Support</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Fashion Street, Mumbai</li>
                        <li><i class="fas fa-envelope me-2"></i> <a href="mailto:support@stylehub.com">support@stylehub.com</a></li>
                        <li><i class="fas fa-phone-alt me-2"></i> +91-98765-43210</li>
                        <li><i class="fas fa-clock me-2"></i> 10:00 AM - 10:00 PM</li>
                    </ul>
                </div>
                
                <!-- Column 3: Account -->
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
                
                <!-- Column 4: Quick Link -->
                <div class="col-md-2 mb-4">
                    <h5>Quick Link</h5>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms Of Use</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Column 5: Follow Us -->
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
            
            <hr>
            <div class="copyright">
                © Copyright 2022. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ========================================
         BACK TO TOP BUTTON - RIGHT SIDE
         ======================================== -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- ========================================
         SCRIPTS
         ======================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Back to Top Button
        $('#backToTop').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });
        
        // Cart & Wishlist Count
        $.get('{{ url("/cart/count") }}', function(data) {
            $('#cartCount').text(data.count);
        });
        
        $.get('{{ url("/wishlist/count") }}', function(data) {
            $('#wishlistCount').text(data.count);
        });
        
        // Search
        $('#searchInput').on('keypress', function(e) {
            if(e.which === 13) {
                window.location.href = '{{ route("shop.index") }}?search=' + $(this).val();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>