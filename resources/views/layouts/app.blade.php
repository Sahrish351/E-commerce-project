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

        @media (max-width: 576px) {
            .top-banner {
                font-size: 10px;
                padding: 6px 0;
            }
            .top-banner span {
                display: block;
            }
        }
        
        /* ========================================
           NAVBAR - SAME ON ALL PAGES
           ======================================== */
        .navbar {
            padding: 12px 0;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 26px;
            color: #000;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 20px;
            }
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
            font-size: 15px;
        }
        
        .nav-link:hover {
            color: #db4444;
        }

        /* ========================================
           NAVBAR TOGGLE - Hamburger
           ======================================== */
        .navbar-toggler {
            border: none !important;
            padding: 6px 10px !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .navbar-toggler:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        .navbar-toggler-icon {
            width: 28px;
            height: 28px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0,0,0,0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            transition: all 0.3s ease;
        }

        /* ========================================
           SEARCH BAR - COLORFUL ON CLICK
           ======================================== */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-bar input {
            border-radius: 25px;
            padding: 8px 40px 8px 16px;
            background: #f5f5f5;
            border: 2px solid transparent;
            width: 220px;
            font-size: 13px;
            transition: all 0.4s ease;
            color: #333;
        }

        /* SEARCH BAR - COLORFUL ON FOCUS/CLICK */
        .search-bar input:focus {
            outline: none;
            background: #fff;
            border-color: #db4444;
            box-shadow: 0 0 0 4px rgba(219, 68, 68, 0.15),
                        0 0 20px rgba(219, 68, 68, 0.08);
            width: 260px;
            transform: scale(1.02);
        }

        /* Search Bar Placeholder Color */
        .search-bar input::placeholder {
            color: #999;
            transition: color 0.3s;
        }

        .search-bar input:focus::placeholder {
            color: #db4444;
        }

        /* Search Icon - Colorful on Focus */
        .search-bar i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .search-bar input:focus + i,
        .search-bar i:hover {
            color: #db4444;
            transform: translateY(-50%) scale(1.1);
        }

        /* ========================================
           SEARCH BAR - ANIMATION ON FOCUS
           ======================================== */
        @keyframes searchPulse {
            0% { box-shadow: 0 0 0 0 rgba(219, 68, 68, 0.2); }
            100% { box-shadow: 0 0 0 10px rgba(219, 68, 68, 0); }
        }

        .search-bar input:focus {
            animation: searchPulse 0.6s ease-out;
        }

        /* ========================================
           SEARCH BAR - RESPONSIVE
           ======================================== */
        @media (max-width: 992px) {
            .search-bar input {
                width: 100% !important;
                padding: 10px 45px 10px 15px;
                font-size: 14px;
                border-radius: 30px;
                background: #f5f5f5;
                border: 2px solid transparent;
            }
            
            .search-bar input:focus {
                width: 100% !important;
                border-color: #db4444;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(219, 68, 68, 0.12),
                            0 0 25px rgba(219, 68, 68, 0.06);
                transform: scale(1.01);
            }
            
            .search-bar i {
                right: 15px;
                font-size: 16px;
                color: #888;
            }

            .search-bar input:focus + i {
                color: #db4444;
            }
        }

        @media (max-width: 576px) {
            .search-bar input {
                padding: 8px 40px 8px 12px;
                font-size: 13px;
            }
            .search-bar input:focus {
                box-shadow: 0 0 0 3px rgba(219, 68, 68, 0.12);
                transform: scale(1.005);
            }
            .search-bar i {
                right: 12px;
                font-size: 14px;
            }
        }
        
        /* ========================================
           NAVBAR ICONS
           ======================================== */
        .navbar-icons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-icons a {
            color: #333;
            transition: color 0.3s;
            font-size: 20px;
            position: relative;
        }

        .navbar-icons a:hover {
            color: #db4444;
        }

        .navbar-icons .badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        /* ========================================
           MOBILE MENU
           ======================================== */
        @media (max-width: 992px) {
            .navbar-collapse {
                background: #fff;
                padding: 20px 20px 15px;
                border-radius: 16px;
                margin-top: 12px;
                box-shadow: 0 15px 50px rgba(0,0,0,0.1);
                border: 1px solid #f0f0f0;
            }
            
            .navbar-nav .nav-item {
                border-bottom: 1px solid #f5f5f5;
            }
            .navbar-nav .nav-item:last-child {
                border-bottom: none;
            }
            .navbar-nav .nav-link {
                padding: 12px 0 !important;
                font-size: 15px;
                font-weight: 500;
                color: #222;
            }
            .navbar-nav .nav-link:hover {
                color: #db4444;
            }
            
            .navbar-right {
                width: 100%;
                margin-top: 12px;
                padding-top: 15px;
                border-top: 1px solid #f0f0f0;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .search-bar {
                flex: 1;
                min-width: 60%;
            }
            
            .navbar-icons {
                gap: 15px;
            }
            
            .navbar-icons a {
                font-size: 22px;
            }
        }

        @media (max-width: 576px) {
            .navbar-collapse {
                padding: 15px 15px 12px;
                border-radius: 12px;
            }
            .navbar-nav .nav-link {
                padding: 10px 0 !important;
                font-size: 14px;
            }
            .navbar-icons a {
                font-size: 18px;
            }
        }
        
        /* ========================================
   MAIN FOOTER - FIXED
   ======================================== */
.main-footer {
    background: #000;
    width: 100%;
    padding: 50px 0 20px;
    margin: 0;
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

.main-footer ul li {
    color: #aaa;
    margin-bottom: 8px;
    font-size: 14px;
    line-height: 1.5;
}

.main-footer ul li a {
    color: #aaa !important;
    text-decoration: none !important;
    transition: color 0.3s;
}

.main-footer ul li a:hover {
    color: #db4444 !important;
}

.main-footer .input-group input {
    background: transparent;
    border: 1px solid #fff;
    color: #fff;
    font-size: 14px;
    padding: 10px 15px;
}

.main-footer .input-group input::placeholder {
    color: #888;
}

.main-footer .input-group button {
    background: #fff;
    border: none;
    padding: 0 18px;
    transition: all 0.3s;
}

.main-footer .input-group button i {
    color: #000;
    font-size: 16px;
    transition: all 0.3s;
}

.main-footer .input-group button:hover {
    background: #db4444;
}

.main-footer .input-group button:hover i {
    color: #fff;
}

.main-footer hr {
    border-color: #333;
    margin: 30px 0 20px;
}

/* ========================================
   FOOTER - RESPONSIVE
   ======================================== */
@media (max-width: 992px) {
    .main-footer {
        padding: 40px 0 20px;
    }
    .main-footer h5 {
        font-size: 16px;
        margin-bottom: 15px;
    }
}

@media (max-width: 768px) {
    .main-footer {
        text-align: center;
        padding: 30px 0 15px;
    }
    .main-footer .col-md-6 {
        margin-bottom: 25px !important;
    }
    .main-footer .input-group {
        max-width: 300px;
        margin: 0 auto;
    }
    .main-footer ul li {
        font-size: 13px;
    }
    .main-footer h5 {
        font-size: 15px;
    }
}

@media (max-width: 576px) {
    .main-footer {
        padding: 25px 0 15px;
    }
    .main-footer .col-sm-6 {
        margin-bottom: 20px !important;
    }
    .main-footer h5 {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .main-footer ul li {
        font-size: 12px;
        margin-bottom: 5px;
    }
    .main-footer .input-group input {
        font-size: 12px;
        padding: 8px 12px;
    }
    .copyright {
        font-size: 11px;
    }
}
        
        /* ========================================
           BACK TO TOP BUTTON
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

        @media (max-width: 576px) {
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 38px;
                height: 38px;
            }
            .back-to-top i {
                font-size: 16px;
            }
        }
        
        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .main-footer {
                text-align: center;
            }
            .social-icons {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .main-footer h5 {
                font-size: 16px;
            }
            .main-footer ul li {
                font-size: 13px;
            }
            .main-footer .input-group input {
                font-size: 12px;
                padding: 8px 12px;
            }
            .copyright {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- ========================================
         TOP BANNER
         ======================================== -->
    <div class="top-banner">
        <div class="container text-center">
            <span>🔥 Summer Sale Is Live! Up to 50% off on Fashion & Tech Accessories - </span>
            <a href="{{ route('shop.index') }}">Shop Now →</a>
        </div>
    </div>

    <!-- ========================================
         NAVBAR - SAME ON ALL PAGES
         ======================================== -->
    <nav class="navbar navbar-expand-lg sticky-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">StyleHub</a>
            
            <!-- Hamburger Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navbar Links -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    @if(!auth()->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
                    @endif
                </ul>
                
                <!-- Right Side: Search + Icons (Horizontal) -->
                <div class="navbar-right">
                    <div class="search-bar">
                        <input type="text" id="searchInput" placeholder="What are you looking for?">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="navbar-icons">
                        <a href="{{ route('wishlist.index') }}" class="position-relative">
                            <i class="far fa-heart"></i>
                            <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" id="wishlistCount">0</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" id="cartCount">0</span>
                        </a>
                        @if(auth()->check())
                            <a href="{{ route('client.dashboard') }}" class="ms-1">
                                <i class="fas fa-user-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========================================
         MAIN CONTENT
         ======================================== -->
    <main>
        @yield('content')
    </main>

    <!-- ========================================
     MAIN FOOTER - FIXED
     ======================================== -->
<footer class="main-footer">
    <div class="container">
        <div class="row g-4">
            <!-- Column 1: StyleHub -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <h5 class="fw-bold">StyleHub</h5>
                <h6 class="mt-3 text-white">Subscribe</h6>
                <p class="text-secondary small">Get 10% off your first order</p>
                <div class="input-group">
                    <input type="email" class="form-control form-control-sm bg-transparent text-white border-white" 
                           placeholder="Enter your email">
                    <button class="btn btn-sm btn-outline-light" type="button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            
            <!-- Column 2: Support -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <h5 class="fw-bold">Support</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <span class="text-secondary">123 Fashion Street, Mumbai</span></li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-secondary"></i> <a href="mailto:support@stylehub.com" class="text-secondary text-decoration-none">support@stylehub.com</a></li>
                    <li class="mb-2"><i class="fas fa-phone-alt me-2 text-secondary"></i> <span class="text-secondary">+91-98765-43210</span></li>
                    <li class="mb-2"><i class="fas fa-clock me-2 text-secondary"></i> <span class="text-secondary">10:00 AM - 10:00 PM</span></li>
                </ul>
            </div>
            
            <!-- Column 3: Account -->
            <div class="col-lg-2 col-md-6 col-sm-6">
                <h5 class="fw-bold">Account</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">My Account</a></li>
                    <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Login / Register</a></li>
                    <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-secondary text-decoration-none">Cart</a></li>
                    <li class="mb-2"><a href="{{ route('wishlist.index') }}" class="text-secondary text-decoration-none">Wishlist</a></li>
                    <li class="mb-2"><a href="{{ route('shop.index') }}" class="text-secondary text-decoration-none">Shop</a></li>
                </ul>
            </div>
            
            <!-- Column 4: Quick Link -->
            <div class="col-lg-2 col-md-6 col-sm-6">
                <h5 class="fw-bold">Quick Link</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Privacy Policy</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Terms Of Use</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">FAQ</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-secondary text-decoration-none">Contact</a></li>
                </ul>
            </div>
            
            <!-- Column 5: Follow Us -->
            <div class="col-lg-2 col-md-6 col-sm-6">
                <h5 class="fw-bold">Follow Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none"><i class="fab fa-facebook-f me-2"></i> Facebook</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none"><i class="fab fa-twitter me-2"></i> Twitter</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none"><i class="fab fa-instagram me-2"></i> Instagram</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none"><i class="fab fa-linkedin-in me-2"></i> LinkedIn</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none"><i class="fab fa-youtube me-2"></i> YouTube</a></li>
                </ul>
            </div>
        </div>
        
        <hr class="border-secondary">
        <div class="text-center text-secondary">
            © Copyright 2022. All rights reserved.
        </div>
    </div>
</footer>

    <!-- ========================================
         BACK TO TOP BUTTON
         ======================================== -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

     <!-- ========================================
         BOOTSTRAP JS - ADD THIS
         ======================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ========================================
         SCRIPTS
         ======================================== -->
    
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

        // ========================================
        // FIX: Mobile Menu Close Properly
        // ========================================
        $(document).ready(function() {
            // Close menu when clicking on nav link
            $('.navbar-nav .nav-link').on('click', function() {
                var navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    $(navbarCollapse).collapse('hide');
                }
            });

            // Close menu when clicking outside
            $(document).on('click', function(event) {
                var navbar = $('.navbar');
                var target = $(event.target);
                
                if (!navbar.is(target) && !navbar.has(target).length) {
                    var navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        $(navbarCollapse).collapse('hide');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>