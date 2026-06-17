
@extends('layouts.app')

@section('title', 'Home - StyleHub')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - Fashion & Tech Accessories</title>
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
            background-color: #fff;
            color: #333;
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
            font-weight: 500;
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
        
        .category-sidebar {
            border-right: 1px solid #e0e0e0;
            padding-right: 25px;
        }
        
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-list li {
            margin-bottom: 15px;
        }
        
        .category-list a {
            text-decoration: none;
            color: #000000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            transition: color 0.3s;
        }
        
        .category-list a:hover {
            color: #ec1111;
        }
        
        .section-header {
            position: relative;
            padding-left: 15px;
            margin-bottom: 30px;
        }
        
        .section-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #db4444;
            border-radius: 2px;
        }
        
        .section-tag {
            color: #db4444;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: #000;
            margin: 0;
        }
        
        /* Product Card - Full Container Cover */
.product-card {
    border: none;
    border-radius: 12px;
    background: #fff;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.product-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transform: translateY(-5px);
}


.product-image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f5f5f5;
}


.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}


.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #db4444;
    color: #fff;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    z-index: 10;
}


.action-icons {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 10;
}

.action-icon {
    background: #fff;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
    cursor: pointer;
}

.action-icon:hover {
    background: #db4444;
    color: #fff;
}

.action-icon i {
    font-size: 16px;
}


.wishlist-heart.active i,
.wishlist-heart i.fas {
    color: #db4444;
}


.product-info {
    padding: 12px;
    text-align: left;
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price {
    color: #db4444;
    font-weight: 700;
    font-size: 16px;
}

.old-price {
    text-decoration: line-through;
    color: #aaa;
    font-size: 12px;
    margin-left: 8px;
}

.product-rating {
    font-size: 12px;
    color: #ffc107;
    margin-top: 5px;
}

.rating-count {
    color: #888;
    margin-left: 5px;
    font-size: 11px;
}


.add-to-cart-btn {
    position: absolute;
    bottom: -45px;
    left: 0;
    right: 0;
    background: #000;
    color: #fff;
    border: none;
    padding: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: bottom 0.3s;
    cursor: pointer;
    z-index: 15;
}

.product-card:hover .add-to-cart-btn {
    bottom: 0;
}
        
      
.category-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 2px;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-card:hover {
    background: #db4444;
    border-color: #db4444;
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(219, 68, 68, 0.25);
}

.category-icon {
    color: #333;
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    color: #fff !important;
    transform: scale(1.1);
}

.category-name {
    color: #333;
    transition: color 0.3s ease;
    font-size: 16px;
    font-weight: 400px;
}

.category-card:hover .category-name {
    color: #fff !important;
}


.category-card.active {
    background: #db4444;
    border-color: #db4444;
}

.category-card.active .category-icon {
    color: #fff;
}

.category-card.active .category-name {
    color: #fff;
}


@media (max-width: 768px) {
    .category-card {
        padding: 20px 15px;
    }
    
    .category-icon {
        font-size: 2rem !important;
    }
    
    .category-name {
        font-size: 12px !important;
    }
}
      .view-all-btn {
            background: #db4444;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .view-all-btn:hover {
            background: #c0392b;
            color: #fff;
        }

    
.btn-danger {
    background: #db4444;
    border: none;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: #c0392b;
    transform: scale(1.05);
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price {
    color: #db4444;
    font-weight: 700;
    font-size: 16px;
}

.old-price {
    text-decoration: line-through;
    color: #aaa;
    font-size: 12px;
    margin-left: 8px;
}

.product-rating {
    font-size: 12px;
    color: #ffc107;
}

.rating-count {
    color: #888;
    margin-left: 5px;
    font-size: 11px;
}
       
.enhance-banner {
    background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
   
    overflow: hidden;
    margin: 30px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}


.timer-box {
    background: #fff;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.timer-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,255,0,0.2);
}

.timer-number {
    font-size: 25px;
    font-weight: 700;
    color: #000;
    line-height: 1;
    font-family: 'Poppins', monospace;
}

.timer-label {
    font-size: 8px;
    color: #666;
    margin-top: 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 500;
}


.shoes-banner-img {
    transition: all 0.3s ease;
  

.shoes-banner-img:hover {
    transform: scale(1.02);
}



.btn-success {
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: #00cc00 !important;
    transform: translateX(5px);
    box-shadow: 0 5px 5px rgba(0,255,0,0.3);
}


@media (max-width: 992px) {
    .timer-box {
        width: 70px;
        height: 70px;
    }
    .timer-number {
        font-size: 20px;
    }
    .enhance-banner h2 {
        font-size: 38px !important;
    }
}

@media (max-width: 768px) {
    .timer-box {
        width: 55px;
        height: 55px;
    }
    .timer-number {
        font-size: 16px;
    }
    .timer-label {
        font-size: 8px;
    }
    .enhance-banner h2 {
        font-size: 28px !important;
    }
    .shoes-banner-img {
        max-height: 250px !important;
    }
    .btn-success {
        padding: 10px 25px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 576px) {
    .timer-box {
        width: 45px;
        height: 45px;
    }
    .timer-number {
        font-size: 12px;
    }
    .timer-label {
        font-size: 7px;
    }
    .d-flex.gap-3 {
        gap: 8px !important;
    }
}


.color-circles span {
    transition: transform 0.2s ease;
}

.color-circles span:hover {
    transform: scale(1.2);
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
}


.new-badge {
    background: #00a651;
    color: #fff;
    padding: 4px 12px;
    font-size: 11px;
    border-radius: 4px;
    font-weight: 600;
}


.add-to-cart-btn {
    background: #000;
    color: #fff;
    border: none;
    padding: 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: #db4444;
    transform: translateY(-2px);
}


.action-icons {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 10;
}

.action-icon {
    background: #fff;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}


.action-icon:hover {
    background: #db4444;
    color: #fff !important;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(219, 68, 68, 0.3);
}

.action-icon:hover i {
    color: #fff !important;
}


.action-icon i {
    font-size: 16px;
    transition: all 0.3s ease;
    color: #333;
}


.action-icon .fas.fa-heart {
    color: #db4444 !important;
}

.action-icon.active {
    background: #db4444;
}

.action-icon.active i {
    color: #fff !important;
}


.wishlist-heart i.fas {
    color: #db4444 !important;
}

.wishlist-heart i.far {
    color: #333;
}

.wishlist-heart:hover i {
    color: #fff !important;
}


.new-arrival-card .arrival-img {
    background-color: transparent !important;
    mix-blend-mode: normal;
    filter: brightness(1) contrast(1.05);
}


.new-arrival-card .arrival-img {
    background: #000 !important;
    object-fit: contain;
}
 .buy-now-btn {
            background: #19cf22;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
  
.footer-services {
    background: #f8f8f8 !important;
    padding: 60px 0 !important;
    width: 100% !important;
}

.footer-services .service-card {
    text-align: center !important;
    padding: 20px 15px !important;
}


.footer-services .service-img {
    margin-bottom: 20px !important;
}

.footer-services .service-img img {
    width: 60px !important;
    height: 60px !important;
    max-width: 60px !important;
    object-fit: contain !important;
    transition: transform 0.3s ease !important;
}

.footer-services .service-img img:hover {
    transform: scale(1.1) !important;
}


.footer-services .service-title {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #000 !important;
    margin-bottom: 12px !important;
    letter-spacing: 0.5px !important;
}

.footer-services .service-desc {
    font-size: 14px !important;
    color: #666 !important;
    line-height: 1.5 !important;
    max-width: 250px !important;
    margin: 0 auto !important;
}


@media (max-width: 768px) {
    .footer-services {
        padding: 40px 0 !important;
    }
    
    .footer-services .service-img img {
        width: 50px !important;
        height: 50px !important;
        max-width: 50px !important;
    }
    
    .footer-services .service-title {
        font-size: 14px !important;
    }
    
    .footer-services .service-desc {
        font-size: 11px !important;
    }
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
                        <a href="{{ route('profile.dashboard') }}" class="ms-3 text-dark">
                            <i class="fas fa-user-circle fs-5"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

   
    <div class="container py-3">
        
     
        <div class="row g-4">
           
            <div class="col-lg-3 category-sidebar">
                <ul class="category-list">
                    <li><a href="#">👟 Sports Shoes</a></li>
                    <li><a href="#">👞 Casual Shoes</a></li>
                    <li><a href="#">👟 Sneakers</a></li>
                    <li><a href="#">⌚ Smart Watches</a></li>
                    <li><a href="#">⌚ Fashion Watches</a></li>
                    <li><a href="#">🎧 Wireless Earbuds</a></li>
                    <li><a href="#">🕶️ Sunglasses</a></li>
                    <li><a href="#">📱 Mobile Accessories</a></li>
                    <li><a href="#">⚡ Fast Chargers</a></li>
                    <li><a href="#">🔋 Power Banks</a></li>
                    <li><a href="#">🔌 Cables & Wires</a></li>
                </ul>
            </div>

        
        <div class="col-lg-9">
             <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
       
        <div class="carousel-indicators" style="bottom: -30px; z-index: 10;">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
        </div>
        
       
        <div class="carousel-inner" style="border-radius: 15px;">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 img-fluid" alt="Banner 1" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100 img-fluid" alt="Banner 2" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/bluetooth.png') }}" class="d-block w-100 img-fluid" alt="Banner 3" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner casual shoes.png') }}" class="d-block w-100 img-fluid" alt="Banner 4" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
        </div>
        
        
    </div>
</div>
</div>


<div class="row mt-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-4">
                <div class="section-header" style="padding-left: 15px;">
                    <span class="section-tag" style="color: #db4444; font-size: 16px; font-weight: 600;">Today's</span>
                    <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin-top: 8px;">Flash Sales</h2>
                </div>
                
               
                <div class="d-flex align-items-center gap-3 ms-4">
                    <div class="text-center">
                        <span class="d-block" style="font-size: 12px; color: #555;">Days</span>
                        <span class="d-block countdown-days" style="font-size: 32px; font-weight: 700; line-height: 1;">03</span>
                    </div>
                    <span style="font-size: 32px; font-weight: 700; color: #db4444;">:</span>
                    <div class="text-center">
                        <span class="d-block" style="font-size: 12px; color: #555;">Hours</span>
                        <span class="d-block countdown-hours" style="font-size: 32px; font-weight: 700; line-height: 1;">03</span>
                    </div>
                    <span style="font-size: 32px; font-weight: 700; color: #db4444;">:</span>
                    <div class="text-center">
                        <span class="d-block" style="font-size: 12px; color: #555;">Minutes</span>
                        <span class="d-block countdown-minutes" style="font-size: 32px; font-weight: 700; line-height: 1;">00</span>
                    </div>
                    <span style="font-size: 32px; font-weight: 700; color: #db4444;">:</span>
                    <div class="text-center">
                        <span class="d-block" style="font-size: 12px; color: #555;">Seconds</span>
                        <span class="d-block countdown-seconds" style="font-size: 32px; font-weight: 700; line-height: 1;">21</span>
                    </div>
                </div>
            </div>
            
            
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 35px; height: 35px;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 35px; height: 35px;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
   
    <div class="col-6 col-md-3 mb-4">
    <div class="product-card">
        <div class="product-image-wrapper">
            <span class="discount-badge">-40%</span>
            <div class="action-icons">
                <a href="#" class="action-icon wishlist-heart" data-product-id="1">
                    <i class="far fa-heart"></i>
                </a>
                <a href="#" class="action-icon" data-product-id="1">
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <img src="{{ asset('images/products/shoes5.jpg') }}" alt="Nike Air Max" class="product-image">
        </div>
        <div class="product-info">
            <h6 class="product-title">Nike Air Max Sports Shoes</h6>
            <div class="product-price">
                $120 <span class="old-price">$160</span>
            </div>
            <div class="product-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="rating-count">(88)</span>
            </div>
        </div>
        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="7">
            <input type="hidden" name="quantity" value="1">
            <!-- YAHAN BUTTON KI CLASS CHANGE KARO -->
            <button type="submit" class="add-to-cart-btn">Add To Cart</button>
        </form>
    </div>
</div>

   
    <div class="col-6 col-md-3 mb-4">
        <div class="product-card">
            <div class="product-image-wrapper">
                <span class="discount-badge">-35%</span>
                <div class="action-icons">
                    <a href="#" class="action-icon wishlist-heart" data-product-id="2">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" data-product-id="2">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/products/smart watch.jpg') }}" alt="Apple Watch" class="product-image">
            </div>
            <div class="product-info">
                <h6 class="product-title">Apple Watch Series 9</h6>
                <div class="product-price">
                    $200 <span class="old-price">$260</span>
                </div>
                <div class="product-rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <span class="rating-count">(75)</span>
                </div>
            </div>
            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
    @csrf
    <input type="hidden" name="product_id" value="8">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="add-to-cart-btn">Add To Cart</button>
</form>
        </div>
    </div>

    
    <div class="col-6 col-md-3 mb-4">
    <div class="product-card">
        <div class="product-image-wrapper">
            <span class="discount-badge">-30%</span>
            <div class="action-icons">
                <a href="#" class="action-icon wishlist-heart" data-product-id="3">
                    <i class="far fa-heart"></i>
                </a>
                <a href="#" class="action-icon" data-product-id="3">
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <img src="{{ asset('images/products/bluetooth8.jpg') }}" alt="Sony Earbuds" class="product-image">
        </div>
        <div class="product-info">
            <h6 class="product-title">Sony WF-1000XM5 Earbuds</h6>
            <div class="product-price">$70 <span class="old-price">$100</span></div>
            <div class="product-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="rating-count">(99)</span>
            </div>
        </div>
        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="9">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn">Add To Cart</button>
        </form>
    </div>
</div>

  
   <div class="col-6 col-md-3 mb-4">
    <div class="product-card">
        <div class="product-image-wrapper">
            <span class="discount-badge">-25%</span>
            <div class="action-icons">
                <a href="#" class="action-icon wishlist-heart" data-product-id="4">
                    <i class="far fa-heart"></i>
                </a>
                <a href="#" class="action-icon" data-product-id="4">
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <img src="{{ asset('images/products/glasses5.jpg') }}" alt="Ray-Ban" class="product-image">
        </div>
        <div class="product-info">
            <h6 class="product-title">Ray-Ban Aviator Sunglasses</h6>
            <div class="product-price">$37 <span class="old-price">$60</span></div>
            <div class="product-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="rating-count">(99)</span>
            </div>
        </div>
        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="10">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn">Add To Cart</button>
        </form>
    </div>
</div>


<div class="row mt-3 mb-5">
    <div class="col-12 text-center">
        <button class="view-all-btn" style="background: #db4444; color: #fff; border: none; padding: 12px 40px; border-radius: 4px; font-weight: 600;">
            View All Products
        </button>
    </div>
</div>

      
<div class="container mt-5 pt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                <div>
                    <span class="text-danger fw-semibold fs-6">Categories</span>
                    <h2 class="fw-bold fs-1 mt-2 mb-0">Browse By Category</h2>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light border rounded-circle p-2 category-prev" style="width: 46px; height: 46px;">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-light border rounded-circle p-2 category-next" style="width: 46px; height: 46px;">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
       
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'shoes']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-shoe-prints fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Shoes</h5>
                </div>
            </a>
        </div>

       
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'watches']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Watches</h5>
                </div>
            </a>
        </div>

      
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'sunglasses']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-glasses fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Glasses</h5>
                </div>
            </a>
        </div>

       
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'earbuds']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-headphones fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Earbuds</h5>
                </div>
            </a>
        </div>

        
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'chargers']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-bolt fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Chargers</h5>
                </div>
            </a>
        </div>

        
        <div class="col-6 col-md-2">
            <a href="{{ route('shop.index', ['category' => 'powerbanks']) }}" class="text-decoration-none">
                <div class="category-card text-center p-4 border rounded-4">
                    <div class="mb-3">
                        <i class="fas fa-battery-full fa-4x category-icon"></i>
                    </div>
                    <h5 class="fw-semibold mb-0 category-name">Power Banks</h5>
                </div>
            </a>
        </div>
    </div>
</div>

      
<div class="row mt-5 pt-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <div>
                <span class="text-danger fw-semibold fs-6">This Month</span>
                <h2 class="fw-bold fs-1 mt-2 mb-0">Best Selling Products</h2>
            </div>
            <div>
                <a href="{{ route('shop.index') }}" class="btn btn-danger px-4 py-2 rounded-2" style="background: #db4444; border: none;">
                    View All
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
  
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon bg-white rounded-circle d-flex align-items-center justify-content-center wishlist-heart" data-product-id="1" style="width: 34px; height: 34px;">
                        <i class="far fa-heart"></i>
                    </a>
                   
                </div>
                <img src="{{ asset('images/products/shoes9.jpg') }}" alt="Sports Shoes" class="product-image">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Nike Air Max Sports Shoes</h6>
                <div class="product-price">
                    $100 <span class="old-price">$130</span>
                </div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(65)</span>
                </div>
            </div>
           
        </div>
    </div>

   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon bg-white rounded-circle d-flex align-items-center justify-content-center wishlist-heart" data-product-id="2" style="width: 34px; height: 34px;">
                        <i class="far fa-heart"></i>
                    </a>
                    
                </div>
                <img src="{{ asset('images/products/smart watch.jpg') }}" alt="Watch" class="product-image">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Apple Watch Series 12</h6>
                <div class="product-price">
                    $160 <span class="old-price">$200</span>
                </div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(65)</span>
                </div>
            </div>
            
        </div>
    </div>

   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon bg-white rounded-circle d-flex align-items-center justify-content-center wishlist-heart" data-product-id="3" style="width: 34px; height: 34px;">
                        <i class="far fa-heart"></i>
                    </a>
                    
                </div>
                <img src="{{ asset('images/products/bluetooth1.jpg') }}" alt="Earbuds" class="product-image">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Sony WF-1000XM5 Earbuds</h6>
                <div class="product-price">
                    $60 <span class="old-price">$90</span>
                </div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(65)</span>
                </div>
            </div>
           
        </div>
    </div>

  
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon bg-white rounded-circle d-flex align-items-center justify-content-center wishlist-heart" data-product-id="4" style="width: 34px; height: 34px;">
                        <i class="far fa-heart"></i>
                    </a>
                   
                </div>
                <img src="{{ asset('images/products/glasses5.jpg') }}" alt="Sunglasses" class="product-image">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Ray-Ban Aviator Sunglasses</h6>
                <div class="product-price">
                    $50
                </div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(65)</span>
                </div>
            </div>
            
        </div>
    </div>
</div>

            

<div class="row mt-5 pt-4">
    <div class="col-12">
        <div class="enhance-banner" style="background: #000000; border-radius: 0px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div class="row align-items-center g-0">
                
               
                <div class="col-md-6 p-4 p-md-5">
                    <span class="text-success fw-semibold fs-6 mb-2 d-inline-block px-3 py-1 rounded-pill" style="color: #00ff00 !important; background: rgba(0,255,0,0.1);">
                        🔥 Summer Sale
                    </span>
                    <h2 class="text-white fw-bold mt-3" style="font-size: 52px; line-height: 1.2;">
                        Step Into<br>Casual Comfort
                    </h2>
                    <p class="text-white-50 mt-2 mb-4" style="font-size: 16px;">Premium quality casual shoes for everyday comfort</p>
                    
                    
                    <div class="d-flex gap-3 mt-4 mb-4">
                        <div class="timer-box bg-white rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg">
                            <span class="timer-number fw-bold" id="timerDays">05</span>
                            <span class="timer-label text-muted">DAYS</span>
                        </div>
                        <div class="timer-box bg-white rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg">
                            <span class="timer-number fw-bold" id="timerHours">13</span>
                            <span class="timer-label text-muted">HOURS</span>
                        </div>
                        <div class="timer-box bg-white rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg">
                            <span class="timer-number fw-bold" id="timerMinutes">36</span>
                            <span class="timer-label text-muted">MINUTES</span>
                        </div>
                        <div class="timer-box bg-white rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg">
                            <span class="timer-number fw-bold" id="timerSeconds">55</span>
                            <span class="timer-label text-muted">SECONDS</span>
                        </div>
                    </div>
                    <a href="{{ route('shop.index', ['category' => 'shoes']) }}" class="btn btn-success px-3 py-2 rounded-pill fw-semibold" style="background: #00ff00; border: none; color: #000; font-weight: 600; font-size: 16px;">
                        Buy Now! <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                
                
<div class="col-md-6 text-start p-2" style="margin-left: -120px; position: relative;">
    <div style="position: relative; display: inline-block;">
        
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.1) 100%); border-radius: 0px; z-index: 1;"></div>
        
       
        <img src="{{ asset('images/summer sale.png') }}" alt="Casual Shoes" 
             class="shoes-banner-img"
             style="height: 400px; width: 600px; margin-left: 20px; object-fit: contain; 
                    filter: brightness(0.95) contrast(1.1) drop-shadow(0 10px 20px rgba(0,0,0,0.2));
                    position: relative; z-index: 0;">
        </div>
    </div>
                
</div>
        </div>
    </div>
</div>


<div class="row mt-5 pt-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <div>
                <span class="text-danger fw-semibold fs-6">Our Products</span>
                <h2 class="fw-bold fs-1 mt-2 mb-0">Explore Our Products</h2>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light border rounded-circle p-2" style="width: 40px; height: 40px;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-light border rounded-circle p-2" style="width: 40px; height: 40px;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="row g-4">
   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/products/runningshoes.jpg') }}" alt="Sports Shoes" style="width: 100%; height: 280px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Sports Running Shoes</h6>
                <div class="product-price">$120</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(88)</span>
                </div>
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

  
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/products/watch6.jpg') }}" alt="Smart Watch" style="width: 100%; height: 260px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Sveston Watch</h6>
                <div class="product-price">$450</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(95)</span>
                </div>
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

    
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/products/bluetooth.jpg') }}" alt="Wireless Earbuds" style="width: 100%; height: 260px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Wireless Noise Earbuds</h6>
                <div class="product-price">$280</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(325)</span>
                </div>
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/products/glasses5.jpg') }}" alt="Sunglasses" style="width: 100%; height: 340px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Premium Sunglasses</h6>
                <div class="product-price">$150</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(145)</span>
                </div>
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <span class="new-badge" style="position: absolute; top: 10px; left: 10px; background: #00a651; color: #fff; padding: 4px 12px; font-size: 11px; border-radius: 0px; z-index: 10;">NEW</span>
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/fitness2.png') }}" alt="Smart Fitness Band" style="width: 100%; height: 300px; object-fit: contain; background: #f5f5f5; border-radius: 2px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Smart Fitness Band</h6>
                <div class="product-price">$49</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(128)</span>
                </div>
                
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

    
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <span class="new-badge" style="position: absolute; top: 10px; left: 10px; background: #00a651; color: #fff; padding: 4px 12px; font-size: 11px; border-radius: 4px; z-index: 10;">NEW</span>
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/mouse.jpg') }}" alt="Wireless Mouse" style="width: 100%; height: 260px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Wireless Silent Mouse</h6>
                <div class="product-price">$29</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(256)</span>
                </div>
                
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <span class="new-badge" style="position: absolute; top: 10px; left: 10px; background: #00a651; color: #fff; padding: 4px 12px; font-size: 11px; border-radius: 4px; z-index: 10;">NEW</span>
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/speaker2.jpg') }}" alt="Bluetooth Speaker" style="width: 100%; height: 260px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">Portable Bluetooth Speaker</h6>
                <div class="product-price">$59</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(189)</span>
                </div>
                
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>

   
    <div class="col-6 col-md-3">
        <div class="product-card">
            <div class="product-image-wrapper position-relative">
                <span class="new-badge" style="position: absolute; top: 10px; left: 10px; background: #00a651; color: #fff; padding: 4px 12px; font-size: 11px; border-radius: 4px; z-index: 10;">NEW</span>
                <div class="action-icons position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <a href="#" class="action-icon wishlist-heart" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="action-icon" style="background: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 8px;">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <img src="{{ asset('images/usb hub2.jpg') }}" alt="USB Hub" style="width: 100%; height: 300px; object-fit: contain; background: #f5f5f5; border-radius: 8px;">
            </div>
            <div class="product-info mt-2">
                <h6 class="product-title">USB-C Multi Port Hub</h6>
                <div class="product-price">$39</div>
                <div class="product-rating mt-1">
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <span class="rating-count text-muted ms-1">(98)</span>
                </div>
                
                <button class="add-to-cart-btn w-100 mt-2" style="background: #000; color: #fff; border: none; padding: 8px; border-radius: 4px; font-size: 12px;">Add To Cart</button>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4 mb-5">
    <div class="col-12 text-center">
        <a href="{{ route('shop.index') }}" class="btn btn-danger px-4 py-2 rounded" style="background: #db4444; border: none;">
            View All Products
        </a>
    </div>
</div>


<div class="row mt-5 pt-4">
    <div class="col-12">
        <div class="section-header">
            <span class="text-danger fw-semibold fs-6">Featured</span>
            <h2 class="fw-bold fs-1 mt-2 mb-4">New Arrival</h2>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
   
    <div class="col-md-6">
        <div class="new-arrival-card" style="background: #000; border-radius: 0px; overflow: hidden; position: relative; height: 100%; min-height: 0px;">
           
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 50%); z-index: 1;"></div>
            
            <div class="p-4" style="position: absolute; bottom: 0; left: 0; z-index: 2;">
                <h3 class="text-white fw-bold mb-2">PlayStation 5</h3>
                <p class="text-white-50 mb-3" style="font-size: 14px;">Black and White version of the PS5<br>coming out on sale.</p>
                <a href="{{ route('shop.index', ['category' => 'gaming']) }}" class="shop-now-btn text-white" style="border-bottom: 2px solid #fff; padding-bottom: 5px; text-decoration: none;">
                    Shop Now →
                </a>
            </div>
            <img src="{{ asset('images/feature.png') }}" alt="PlayStation 5" class="arrival-img" style="position: absolute; bottom: 0; right: 0; max-width: 75%; height: auto; object-fit: contain; background: transparent; z-index: 0;">
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="row g-4 h-100">
           
            <div class="col-12">
                <div class="new-arrival-card" style="background: #000; border-radius: 0px; overflow: hidden; position: relative; height: 100%; min-height: 210px;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
                    <div class="p-4" style="position: absolute; bottom: 0; left: 0; z-index: 2;">
                        <h4 class="text-white fw-bold mb-2">Women's Collections</h4>
                        <p class="text-white-50 mb-3" style="font-size: 13px;">Featured woman collections that<br>give you another vibe.</p>
                        <a href="{{ route('shop.index', ['category' => 'women']) }}" class="shop-now-btn text-white" style="border-bottom: 2px solid #fff; padding-bottom: 5px; text-decoration: none;">
                            Shop Now →
                        </a>
                    </div>
                    <img src="{{ asset('images/women.png') }}" alt="Women Collection" class="arrival-img" style="position: absolute; bottom: 0; right: 0; max-width: 60%; height: auto; object-fit: contain; background: transparent;">
                </div>
            </div>

          
            <div class="row g-4">
                <div class="col-6">
                    <div class="new-arrival-card" style="background: #000; border-radius: 0px; overflow: hidden; position: relative; height: 100%; min-height: 210px;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 80%); z-index: 1;"></div>
                        <div class="p-3" style="position: absolute; bottom: 0; left: 0; z-index: 2;">
                            <h5 class="text-white fw-bold mb-1">Speakers</h5>
                            <p class="text-white-50 mb-2" style="font-size: 12px;">Amazon wireless speakers</p>
                            <a href="{{ route('shop.index', ['category' => 'speakers']) }}" class="shop-now-btn text-white" style="border-bottom: 2px solid #fff; padding-bottom: 3px; text-decoration: none; font-size: 12px;">
                                Shop Now →
                            </a>
                        </div>
                        <img src="{{ asset('images/speaker.png') }}" alt="Speakers" class="arrival-img" style="position: absolute; bottom: 0; right: 0; max-width: 75%; height: auto; object-fit: contain; background: transparent;">
                    </div>
                </div>

                <div class="col-6">
                    <div class="new-arrival-card" style="background: #000; border-radius: 0px; overflow: hidden; position: relative; height: 100%; min-height: 210px;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 80%); z-index: 1;"></div>
                        <div class="p-3" style="position: absolute; bottom: 0; left: 0; z-index: 2;">
                            <h5 class="text-white fw-bold mb-1">Perfume</h5>
                            <p class="text-white-50 mb-2" style="font-size: 12px;">GUCCI INTENSE OUD EDP</p>
                            <a href="{{ route('shop.index', ['category' => 'perfume']) }}" class="shop-now-btn text-white" style="border-bottom: 2px solid #fff; padding-bottom: 3px; text-decoration: none; font-size: 12px;">
                                Shop Now →
                            </a>
                        </div>
                        <img src="{{ asset('images/perfume.png') }}" alt="Perfume" class="arrival-img" style="position: absolute; bottom: 0; right: 0; max-width: 80%; height: auto; object-fit: contain; background: transparent;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="footer-services">
    <div class="container" style="margin-bottom: 50px;">
        <div class="row">
           
            <div class="col-md-4 text-center mb-4">
                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/footer1.png') }}" alt="Fast Delivery" 
                             style="width: 100px; height: 100px; margin-bottom: 20px; object-fit: contain;">
                    </div>
                    <h5 class="service-title">FREE AND FAST DELIVERY</h5>
                    <p class="service-desc">Free delivery for all orders over $140</p>
                </div>
            </div>
            
            <div class="col-md-4 text-center mb-4">
                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/footer2.png') }}" alt="Customer Service" 
                             style="width: 100px; height: 100px; margin-bottom: 20px; object-fit: contain;">
                    </div>
                    <h5 class="service-title">24/7 CUSTOMER SERVICE</h5>
                    <p class="service-desc">Friendly 24/7 customer support</p>
                </div>
            </div>
          
            <div class="col-md-4 text-center mb-4">
                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/footer3.png') }}" alt="Money Back" 
                             style="width: 100px; height: 100px; margin-bottom: 20px; object-fit: contain;">
                    </div>
                    <h5 class="service-title">MONEY BACK GUARANTEE</h5>
                    <p class="service-desc">We return money within 30 days</p>
                </div>
            </div>
        </div>
    </div>
</div>

   

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Back to Top
    $('#backToTop').click(function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
    });
    
    // Flash Sales Countdown
    function updateCountdown() {
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 3);
        targetDate.setHours(23, 59, 59, 999);
        
        const now = new Date();
        const diff = targetDate - now;
        
        if (diff > 0) {
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (86400000)) / (3600000));
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            
            $('.countdown-days').text(String(days).padStart(2, '0'));
            $('.countdown-hours').text(String(hours).padStart(2, '0'));
            $('.countdown-minutes').text(String(minutes).padStart(2, '0'));
            $('.countdown-seconds').text(String(seconds).padStart(2, '0'));
        }
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // Wishlist Heart
    $(document).ready(function() {
        $('.wishlist-heart').click(function(e) {
            e.preventDefault();
            var $heartIcon = $(this).find('i');
            
            if ($heartIcon.hasClass('far')) {
                $heartIcon.removeClass('far').addClass('fas');
                $(this).css('color', '#db4444'); 
                alert('Added to wishlist!');
            } else {
                $heartIcon.removeClass('fas').addClass('far');
                $(this).css('color', '#333');
                alert('Removed from wishlist!');
            }
        });
    });
    

    // Summer Sale Countdown
    function startCountdown() {
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 5);
        targetDate.setHours(13, 36, 55, 0);
        
        function updateTimer() {
            const now = new Date();
            const diff = targetDate - now;
            
            if (diff > 0) {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (86400000)) / (3600000));
                const minutes = Math.floor((diff % 3600000) / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);
                
                const daysEl = document.getElementById('timerDays');
                const hoursEl = document.getElementById('timerHours');
                const minutesEl = document.getElementById('timerMinutes');
                const secondsEl = document.getElementById('timerSeconds');
                
                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
            }
        }
        updateTimer();
        setInterval(updateTimer, 1000);
    }
    startCountdown();

    // Category Click
    $('.category-card').click(function() {
        var category = $(this).find('.category-name').text().toLowerCase();
        window.location.href = '/shop?category=' + category;
    });
    
    // Cart & Wishlist Count
    $.get('{{ url("/cart/count") }}', function(data) { $('#cartCount').text(data.count); });
    $.get('{{ url("/wishlist/count") }}', function(data) { $('#wishlistCount').text(data.count); });
    
    // Search
    $('#searchInput').on('keypress', function(e) {
        if(e.which === 13) {
            window.location.href = '{{ route("shop.index") }}?search=' + $(this).val();
        }
    });
</script>
</body>
</html>