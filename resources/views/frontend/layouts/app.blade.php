<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'StyleHub - E-Commerce Store')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #1a1a2e;
        }
        
        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .navbar-custom .navbar-brand {
            font-weight: 800;
            font-size: 24px;
            color: #1a1a2e;
        }
        .navbar-custom .navbar-brand span {
            color: #db4444;
        }
        .navbar-custom .nav-link {
            color: #555;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
            padding: 8px 16px;
        }
        .navbar-custom .nav-link:hover {
            color: #db4444;
        }
        .navbar-custom .nav-link i {
            margin-right: 4px;
        }
        .btn-danger-custom {
            background: #db4444;
            color: #fff;
            border: none;
            padding: 8px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-danger-custom:hover {
            background: #b33232;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(219, 68, 68, 0.3);
        }
        .badge-count {
            background: #db4444;
            color: #fff;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 4px;
        }
        
        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 8px 0;
            margin-top: 8px;
        }
        .dropdown-menu .dropdown-item {
            padding: 8px 20px;
            font-size: 14px;
            color: #333;
            transition: all 0.2s;
        }
        .dropdown-menu .dropdown-item:hover {
            background: #f8f9fa;
            color: #db4444;
        }
        .dropdown-menu .dropdown-item i {
            width: 20px;
            color: #999;
        }
        .dropdown-menu .dropdown-item:hover i {
            color: #db4444;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #1a1a2e;
            color: #fff;
            padding: 50px 0 30px;
            margin-top: 40px;
        }
        .footer h5 {
            font-weight: 700;
            margin-bottom: 16px;
            color: #fff;
        }
        .footer p {
            color: #aaa;
            font-size: 14px;
            line-height: 1.8;
        }
        .footer a {
            color: #aaa;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .footer a:hover {
            color: #db4444;
        }
        .footer .social-links a {
            display: inline-block;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            margin-right: 8px;
            transition: all 0.3s;
        }
        .footer .social-links a:hover {
            background: #db4444;
            color: #fff;
        }
        .footer hr {
            border-color: #333;
            margin: 20px 0;
        }
        .footer .copyright {
            color: #666;
            font-size: 13px;
            text-align: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .navbar-custom .navbar-collapse {
                padding-top: 12px;
            }
            .navbar-custom .nav-link {
                padding: 6px 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Style<span>Hub</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">
                            <i class="fas fa-store"></i> Shop
                        </a>
                    </li>
                    
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="badge-count" id="cart-count">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                            <i class="fas fa-heart"></i> Wishlist
                            <span class="badge-count" id="wishlist-count">0</span>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.dashboard') }}">
                                    <i class="fas fa-th-large"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.addresses') }}">
                                    <i class="fas fa-map-marker-alt"></i> Addresses
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.password') }}">
                                    <i class="fas fa-lock"></i> Change Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="btn btn-danger-custom" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>Style<span style="color:#db4444;">Hub</span></h5>
                    <p>Your one-stop shop for premium products and accessories. Quality products delivered to your doorstep.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Quick Links</h5>
                    <a href="{{ route('shop.index') }}">Shop</a>
                    <a href="#">About Us</a>
                    <a href="#">Contact</a>
                    <a href="#">FAQ</a>
                </div>
                <div class="col-md-3">
                    <h5>Categories</h5>
                    <a href="#">Electronics</a>
                    <a href="#">Clothing</a>
                    <a href="#">Accessories</a>
                    <a href="#">Shoes</a>
                </div>
                <div class="col-md-3">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-envelope" style="color:#db4444;"></i> support@stylehub.com</p>
                    <p><i class="fas fa-phone" style="color:#db4444;"></i> +1 234 567 890</p>
                    <p><i class="fas fa-map-marker-alt" style="color:#db4444;"></i> 123 Main Street, New York</p>
                </div>
            </div>
            <hr>
            <div class="copyright">
                &copy; {{ date('Y') }} StyleHub. All rights reserved. | Made with <i class="fas fa-heart" style="color:#db4444;"></i>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Update cart count
        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                method: 'GET',
                success: function(data) {
                    $('#cart-count').text(data.count || 0);
                }
            });
        }
        
        // Update wishlist count
        function updateWishlistCount() {
            $.ajax({
                url: '{{ route("wishlist.count") }}',
                method: 'GET',
                success: function(data) {
                    $('#wishlist-count').text(data.count || 0);
                }
            });
        }
        
        $(document).ready(function() {
            @auth
            updateCartCount();
            updateWishlistCount();
            @endauth
        });
    </script>
    
    @stack('scripts')
</body>
</html>