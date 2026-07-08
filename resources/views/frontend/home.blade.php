@extends('layouts.app')

@section('title', 'Home - StyleHub')

@section('content')
<style>
  
    .hero-slide-wrapper {
        width: 100%;
        height: 450px;
        overflow: hidden;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-slide-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }
    @media (max-width: 992px) { .hero-slide-wrapper { height: 350px; } }
    @media (max-width: 768px) { .hero-slide-wrapper { height: 280px; } }


.carousel-indicators {
    gap: 6px !important;
    bottom: 20px !important;
    z-index: 5 !important;
    margin-bottom: 0 !important;
}
.carousel-indicators button {
    width: 10px !important;
    height: 10px !important;
    border-radius: 50% !important;
    background-color: rgba(255, 255, 255, 0.8) !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    margin: 0 3px !important;
    padding: 0 !important;
    opacity: 0.9 !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
}
.carousel-indicators .active {
    background-color: #db4444 !important;
    border-color: #db4444 !important;
    width: 12px !important;
    height: 12px !important;
    transform: scale(1.1);
    opacity: 1 !important;
}


@media (max-width: 576px) {
    .hero-slide-wrapper { height: 200px; }
    .carousel-indicators {
        bottom: 12px !important;
        gap: 4px !important;
    }
    .carousel-indicators button {
        width: 7px !important;
        height: 7px !important;
        border-width: 1.5px !important;
    }
    .carousel-indicators .active {
        width: 9px !important;
        height: 9px !important;
    }
}


@media (max-width: 400px) {
    .hero-slide-wrapper { height: 160px; }
    .carousel-indicators {
        bottom: 8px !important;
        gap: 3px !important;
    }
    .carousel-indicators button {
        width: 5px !important;
        height: 5px !important;
        border-width: 1px !important;
    }
    .carousel-indicators .active {
        width: 7px !important;
        height: 7px !important;
    }
}

   
    .flash-sales-wrapper { position: relative; overflow: hidden; margin-bottom: 10px; }
    .flash-sales-track {
        display: flex;
        transition: transform 0.5s ease;
        gap: 15px;
        will-change: transform;
    }
    .flash-sales-track .product-card {
        flex: 0 0 calc(25% - 12px);
        min-width: calc(25% - 12px);
        margin-bottom: 0;
    }
    @media (max-width: 992px) {
        .flash-sales-track .product-card { flex: 0 0 calc(33.33% - 10px); min-width: calc(33.33% - 10px); }
    }
    @media (max-width: 768px) {
        .flash-sales-track .product-card { flex: 0 0 calc(50% - 8px); min-width: calc(50% - 8px); }
        .flash-sales-track { gap: 10px; }
    }
    @media (max-width: 576px) {
        .flash-sales-track .product-card { flex: 0 0 calc(50% - 6px); min-width: calc(50% - 6px); }
        .flash-sales-track { gap: 8px; }
    }
    .flash-nav-btn {
        width: 30px; height: 30px; border-radius: 50%; border: 1px solid #ddd; background: #fff;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.3s; z-index: 10; flex-shrink: 0;
    }
    .flash-nav-btn:hover { background: #db4444; color: #fff; border-color: #db4444; }
    .flash-nav-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    .flash-nav-btn i { font-size: 11px; color: #333; }
    .flash-nav-btn:hover i { color: #fff; }

.category-sidebar { 
    border-right: 1px solid #e0e0e0; 
    padding-right: 25px; 
    height: 450px;              /* ← Fixed height (image ke barabar) */
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    overflow-y: auto;           /* ← Agar categories zyada hain toh scroll */
}

@media (max-width: 992px) { .category-sidebar { border-right: none; padding-right: 0; margin-bottom: 20px; } }
    .category-list { list-style: none; padding: 0; margin: 0; }
    .category-list li { margin-bottom: 12px; padding: 3px 0; border-bottom: 1px solid #f0f0f0; }
    @media (max-width: 576px) { .category-list li { margin-bottom: 8px; padding: 4px 0; } }
    .category-list li:last-child { border-bottom: none; }
    .category-list a {
        text-decoration: none; color: #000; display: flex; justify-content: space-between;
        align-items: center; font-size: 15px; transition: color 0.3s; padding: 4px 0; width: 100%;
    }
    @media (max-width: 576px) { .category-list a { font-size: 13px; } }
    .category-list a:hover { color: #ec1111; }
    .category-list a .category-icon-left { display: flex; align-items: center; gap: 10px; }
    .category-list a .category-arrow { color: #aaa; font-size: 12px; transition: color 0.3s; }
    .category-list a:hover .category-arrow { color: #ec1111; }

  
    .enhance-banner { background: #000; border-radius: 8px; overflow: hidden; margin: 20px 0; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    @media (max-width: 576px) { .enhance-banner { border-radius: 4px; margin: 15px 0; } }
    /* Summer Sale Banner */
.enhance-banner {
    background: #000;
    border-radius: 8px;
    overflow: hidden;
    margin: 20px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
@media (max-width: 576px) {
    .enhance-banner {
        border-radius: 4px;
        margin: 15px 0;
    }
}

.banner-image-wrapper {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 30px;
    min-height: 300px;
}

.banner-image-wrapper img {
    width: 100%;
    max-width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: contain;
    transition: all 0.3s ease;
}

/* Responsive */
@media (max-width: 992px) {
    .banner-image-wrapper img {
        max-height: 220px;
    }
}
@media (max-width: 768px) {
    .banner-image-wrapper {
        padding: 10px 15px;
        min-height: 150px;
    }
    .banner-image-wrapper img {
        max-height: 180px;
    }
}
@media (max-width: 576px) {
    .banner-image-wrapper {
        padding: 8px 10px;
        min-height: 120px;
    }
    .banner-image-wrapper img {
        max-height: 150px;
    }
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
@media (max-width: 768px) {
    .timer-box {
        width: 50px;
        height: 50px;
    }
}
@media (max-width: 576px) {
    .timer-box {
        width: 40px;
        height: 40px;
    }
}
.timer-number {
    font-size: 20px;
    font-weight: 700;
    color: #000;
    line-height: 1;
}
@media (max-width: 768px) {
    .timer-number {
        font-size: 16px;
    }
}
@media (max-width: 576px) {
    .timer-number {
        font-size: 13px;
    }
}
.timer-label {
    font-size: 7px;
    color: #666;
    margin-top: 2px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}
@media (max-width: 576px) {
    .timer-label {
        font-size: 5px;
    }
}

.timer-label {
    font-size: 6px;
    color: #666;
    margin-top: 1px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}
@media (max-width: 576px) {
    .timer-label {
        font-size: 5px;
    }
}

    .timer-number { font-size: 22px; font-weight: 700; color: #000; line-height: 1; }
    @media (max-width: 768px) { .timer-number { font-size: 18px; } }
    @media (max-width: 576px) { .timer-number { font-size: 14px; } }
    .timer-label { font-size: 7px; color: #666; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }
    @media (max-width: 576px) { .timer-label { font-size: 6px; } }

    .new-arrival-card { background: #000; border-radius: 8px; overflow: hidden; position: relative; min-height: 200px; height: 100%; }
    @media (max-width: 768px) { .new-arrival-card { min-height: 160px; } }
    @media (max-width: 576px) {
        .new-arrival-card { min-height: 150px !important; border-radius: 4px !important; }
        .new-arrival-card h3 { font-size: 14px !important; }
        .new-arrival-card h4 { font-size: 12px !important; }
        .new-arrival-card h5 { font-size: 11px !important; }
        .new-arrival-card p { font-size: 9px !important; margin-bottom: 2px !important; }
        .new-arrival-card .shop-now-btn { font-size: 9px !important; padding-bottom: 1px !important; }
        .new-arrival-card .arrival-img { max-width: 45% !important; }
    }
    @media (max-width: 400px) {
        .new-arrival-card { min-height: 120px !important; }
        .new-arrival-card h3 { font-size: 12px !important; }
        .new-arrival-card h4 { font-size: 10px !important; }
        .new-arrival-card h5 { font-size: 9px !important; }
        .new-arrival-card p { font-size: 8px !important; }
        .new-arrival-card .shop-now-btn { font-size: 8px !important; }
        .new-arrival-card .arrival-img { max-width: 40% !important; }
    }

  
    .best-selling-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .best-selling-header .view-all-btn-sm { background: #db4444; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600; font-size: 13px; transition: all 0.3s; text-decoration: none; flex-shrink: 0; }
    .best-selling-header .view-all-btn-sm:hover { background: #c0392b; color: #fff; }

  
    .section-header { position: relative; padding-left: 15px; }
    .section-header::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: #db4444; border-radius: 2px; }
    .section-tag { color: #db4444; font-size: 14px; font-weight: 600; margin-bottom: 5px; display: block; }
    @media (max-width: 576px) { .section-tag { font-size: 12px; } }
    .section-title { font-size: 28px; font-weight: 700; color: #000; margin: 0; }
    @media (max-width: 768px) { .section-title { font-size: 22px; } }
    @media (max-width: 576px) { .section-title { font-size: 18px; } }

  
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background-color: #fff; color: #333; }

    .product-card {
        border: none; border-radius: 12px; background: #fff; transition: all 0.3s;
        position: relative; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    @media (max-width: 576px) { .product-card { margin-bottom: 15px; border-radius: 8px; } }
    .product-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateY(-5px); }

    .product-image-wrapper { position: relative; width: 100%; aspect-ratio: 1 / 1; overflow: hidden; background: #f5f5f5; }
    .product-image { width: 100%; height: 100%; object-fit: contain; transition: transform 0.3s ease; padding: 10px; }
    @media (max-width: 576px) { .product-image { padding: 5px; } }
    .product-card:hover .product-image { transform: scale(1.05); }

    .discount-badge { position: absolute; top: 10px; left: 10px; background: #db4444; color: #fff; padding: 3px 10px; font-size: 11px; font-weight: 600; border-radius: 4px; z-index: 10; }
    @media (max-width: 576px) { .discount-badge { top: 6px; left: 6px; font-size: 9px; padding: 2px 8px; } }

    .action-icons { position: absolute; top: 10px; right: 10px; display: flex; flex-direction: column; gap: 6px; z-index: 10; }
    @media (max-width: 576px) { .action-icons { top: 6px; right: 6px; gap: 4px; } }
    .action-icon {
        background: #fff; width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; text-decoration: none;
        color: #333; transition: all 0.3s; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    @media (max-width: 576px) { .action-icon { width: 26px; height: 26px; } .action-icon i { font-size: 12px; } }
    .action-icon:hover { background: #db4444; color: #fff !important; transform: scale(1.1); }
    .action-icon:hover i { color: #fff !important; }
    .action-icon i { font-size: 14px; transition: all 0.3s ease; color: #333; }
    @media (max-width: 576px) { .action-icon i { font-size: 12px; } }

    .product-info { padding: 10px 12px; text-align: left; }
    @media (max-width: 576px) { .product-info { padding: 8px 10px; } }
    .product-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    @media (max-width: 576px) { .product-title { font-size: 12px; } }
    .product-price { color: #db4444; font-weight: 700; font-size: 16px; }
    @media (max-width: 576px) { .product-price { font-size: 14px; } }
    .old-price { text-decoration: line-through; color: #aaa; font-size: 12px; margin-left: 6px; }
    @media (max-width: 576px) { .old-price { font-size: 10px; } }
    .product-rating { font-size: 11px; color: #ffc107; margin-top: 4px; }
    @media (max-width: 576px) { .product-rating { font-size: 10px; } }
    .rating-count { color: #888; margin-left: 5px; font-size: 11px; }
    @media (max-width: 576px) { .rating-count { font-size: 9px; } }

    .add-to-cart-btn {
        background: #000; color: #fff; border: none; padding: 6px; border-radius: 4px;
        font-size: 12px; font-weight: 600; transition: all 0.3s ease; width: 100%; margin-top: 6px; cursor: pointer;
    }
    .add-to-cart-btn:hover { background: #db4444; transform: translateY(-2px); }
    @media (max-width: 576px) { .add-to-cart-btn { font-size: 10px; padding: 5px; } }

    .shop-now-btn { color: #fff; border-bottom: 2px solid #fff; padding-bottom: 3px; text-decoration: none; font-size: 13px; display: inline-block; }
    @media (max-width: 768px) { .shop-now-btn { font-size: 12px; } }
    @media (max-width: 576px) { .shop-now-btn { font-size: 10px; padding-bottom: 2px; } }
    .shop-now-btn:hover { color: #db4444; border-bottom-color: #db4444; }

    .footer-services { background: #f8f8f8; padding: 40px 0; width: 100%; }
    @media (max-width: 768px) { .footer-services { padding: 30px 0; } }
    @media (max-width: 576px) { .footer-services { padding: 20px 0; } }
    .footer-services .service-card { text-align: center; padding: 15px 10px; }
    .footer-services .service-img img { width: 60px; height: 60px; max-width: 60px; object-fit: contain; transition: transform 0.3s ease; margin-bottom: 15px; }
    @media (max-width: 768px) { .footer-services .service-img img { width: 50px; height: 50px; max-width: 50px; margin-bottom: 10px; } }
    @media (max-width: 576px) { .footer-services .service-img img { width: 40px; height: 40px; max-width: 40px; margin-bottom: 8px; } }
    .footer-services .service-title { font-size: 16px; font-weight: 700; color: #000; margin-bottom: 8px; letter-spacing: 0.5px; }
    @media (max-width: 768px) { .footer-services .service-title { font-size: 14px; } }
    @media (max-width: 576px) { .footer-services .service-title { font-size: 12px; } }
    .footer-services .service-desc { font-size: 13px; color: #666; line-height: 1.5; max-width: 250px; margin: 0 auto; }
    @media (max-width: 768px) { .footer-services .service-desc { font-size: 12px; max-width: 200px; } }
    @media (max-width: 576px) { .footer-services .service-desc { font-size: 10px; max-width: 150px; } }

    .view-all-btn { background: #db4444; color: #fff; border: none; padding: 10px 30px; border-radius: 4px; font-weight: 600; transition: all 0.3s; font-size: 14px; cursor: pointer; }
    @media (max-width: 576px) { .view-all-btn { padding: 8px 20px; font-size: 12px; } }
    .view-all-btn:hover { background: #c0392b; color: #fff; }

    .countdown-days, .countdown-hours, .countdown-minutes, .countdown-seconds { font-size: 18px; font-weight: 700; line-height: 1.2; }
    @media (max-width: 768px) { .countdown-days, .countdown-hours, .countdown-minutes, .countdown-seconds { font-size: 16px; } }
    @media (max-width: 576px) { .countdown-days, .countdown-hours, .countdown-minutes, .countdown-seconds { font-size: 14px; } }

    .new-badge { position: absolute; top: 10px; left: 10px; background: #00a651; color: #fff; padding: 3px 10px; font-size: 10px; border-radius: 4px; z-index: 10; font-weight: 600; }
    @media (max-width: 576px) { .new-badge { top: 6px; left: 6px; font-size: 8px; padding: 2px 8px; } }

    .product-category-tag {
        font-size: 10px;
        color: #db4444;
        display: block;
        margin-bottom: 2px;
        font-weight: 500;
    }
    .product-category-tag i {
        margin-right: 3px;
    }

   
    .category-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 6px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 85px;
    }
    .category-card:hover {
        background: #db4444 !important;
        border-color: #db4444 !important;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(219, 68, 68, 0.25);
    }
    .category-card:hover .category-icon {
        color: #fff !important;
        transform: scale(1.05);
    }
    .category-card:hover .category-name {
        color: #fff !important;
    }

    .category-icon {
        font-size: 1.6rem;
        color: #333;
        transition: all 0.3s ease;
    }
    .category-name {
        color: #333;
        transition: color 0.3s ease;
        font-size: 11px;
        font-weight: 500;
        margin-top: 3px;
        text-align: center;
        line-height: 1.2;
    }

    .category-slider-wrapper {
        position: relative;
        overflow: hidden;
        margin-top: 5px;
        padding: 5px 0;
    }
    .category-slider-track {
        display: flex;
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        gap: 12px;
        will-change: transform;
    }
    .category-slide-item {
        flex: 0 0 calc(12.5% - 11px);
        min-width: calc(12.5% - 11px);
    }

    .category-nav-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid #ddd;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
    }
    .category-nav-btn:hover {
        background: #db4444 !important;
        border-color: #db4444 !important;
    }
    .category-nav-btn:hover i {
        color: #fff !important;
    }
    .category-nav-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed !important;
    }
    .category-nav-btn:disabled:hover {
        background: #fff !important;
        border-color: #ddd !important;
    }
    .category-nav-btn:disabled:hover i {
        color: #333 !important;
    }
    .category-nav-btn i {
        font-size: 14px;
        color: #333;
    }

  
    @media (min-width: 993px) {
        .category-slide-item {
            flex: 0 0 calc(12.5% - 11px) !important;
            min-width: calc(12.5% - 11px) !important;
        }
        .category-card {
            min-height: 95px !important;
            padding: 14px 6px !important;
        }
        .category-icon {
            font-size: 1.8rem !important;
        }
        .category-name {
            font-size: 12px !important;
        }
    }
    @media (min-width: 769px) and (max-width: 992px) {
        .category-slide-item {
            flex: 0 0 calc(25% - 9px) !important;
            min-width: calc(25% - 9px) !important;
        }
        .category-card {
            min-height: 90px !important;
            padding: 12px 6px !important;
        }
        .category-icon {
            font-size: 1.6rem !important;
        }
        .category-name {
            font-size: 12px !important;
        }
        .category-nav-btn {
            width: 32px !important;
            height: 32px !important;
        }
        .category-nav-btn i {
            font-size: 12px !important;
        }
    }
    @media (min-width: 577px) and (max-width: 768px) {
        .category-slide-item {
            flex: 0 0 calc(33.333% - 8px) !important;
            min-width: calc(33.333% - 8px) !important;
        }
        .category-card {
            padding: 12px 5px !important;
            min-height: 80px !important;
            border-radius: 6px !important;
        }
        .category-icon {
            font-size: 1.5rem !important;
        }
        .category-name {
            font-size: 11px !important;
            margin-top: 3px !important;
        }
        .category-nav-btn {
            width: 28px !important;
            height: 28px !important;
        }
        .category-nav-btn i {
            font-size: 11px !important;
        }
        .category-slider-track {
            gap: 10px !important;
        }
    }
    @media (max-width: 576px) {
        .category-slide-item {
            flex: 0 0 calc(33.333% - 6px) !important;
            min-width: calc(33.333% - 6px) !important;
        }
        .category-card {
            padding: 10px 4px !important;
            min-height: 65px !important;
            border-radius: 4px !important;
        }
        .category-icon {
            font-size: 1.3rem !important;
        }
        .category-name {
            font-size: 10px !important;
            margin-top: 2px !important;
        }
        .category-nav-btn {
            width: 24px !important;
            height: 24px !important;
        }
        .category-nav-btn i {
            font-size: 10px !important;
        }
        .category-slider-track {
            gap: 6px !important;
        }
        .category-header-text {
            font-size: 18px !important;
        }
        .category-header-label {
            font-size: 12px !important;
        }
    }
    @media (max-width: 400px) {
        .category-slide-item {
            flex: 0 0 calc(50% - 4px) !important;
            min-width: calc(50% - 4px) !important;
        }
        .category-card {
            padding: 8px 3px !important;
            min-height: 55px !important;
            border-radius: 4px !important;
        }
        .category-icon {
            font-size: 1rem !important;
        }
        .category-name {
            font-size: 8px !important;
            margin-top: 2px !important;
        }
        .category-nav-btn {
            width: 22px !important;
            height: 22px !important;
        }
        .category-nav-btn i {
            font-size: 8px !important;
        }
        .category-header-text {
            font-size: 15px !important;
        }
        .category-header-label {
            font-size: 10px !important;
        }
        .category-slider-track {
            gap: 4px !important;
        }
    }

    @media (max-width: 576px) {
        .fs-1 { font-size: 1.8rem !important; }
        .fs-2 { font-size: 1.5rem !important; }
        .fs-6 { font-size: 0.8rem !important; }
        .gap-3 { gap: 8px !important; }
        .p-4 { padding: 1rem !important; }
        .p-5 { padding: 1.5rem !important; }
        .m-4 { margin: 1rem !important; }
        .mb-4 { margin-bottom: 1rem !important; }
        .mt-5 { margin-top: 2rem !important; }
        .pt-4 { padding-top: 1rem !important; }
        .section-title { font-size: 16px !important; }
        .section-tag { font-size: 11px !important; }
        .flash-nav-btn { width: 26px !important; height: 26px !important; }
        .flash-nav-btn i { font-size: 9px !important; }
    }
    @media (max-width: 768px) {
        .gap-4 { gap: 12px !important; }
        .ms-4 { margin-left: 1rem !important; }
        .me-3 { margin-right: 0.8rem !important; }
    }
</style>


<div class="container py-3">
    <div class="row g-4 align-items-stretch">   <!-- ← align-items-stretch ADD KAREIN -->
        <div class="col-lg-3 category-sidebar d-none d-lg-block">
            <ul class="category-list">
                @php
                    $categoryIcons = [
                        'Joggers' => 'fa-walking',
                        'Casual Shoes' => 'fa-shoe-prints',
                        'Sports Shoes' => 'fa-running',
                        'Watches' => 'fa-clock',
                        'Smart Watches' => 'fa-clock',
                        'Earbuds' => 'fa-headphones',
                        'Sunglasses' => 'fa-glasses',
                        'Mobile Accessories' => 'fa-mobile-alt',
                        'Power Banks' => 'fa-battery-full',
                        'Chargers' => 'fa-bolt',
                        'Laptops' => 'fa-laptop',
                        'Gaming' => 'fa-gamepad',
                        'Women' => 'fa-female',
                        'Speakers' => 'fa-volume-up',
                        'Perfume' => 'fa-spray-can',
                        'Fashion' => 'fa-tshirt',
                    ];
                @endphp
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}">
                        <span class="category-icon-left">
                            <i class="fas {{ $categoryIcons[$category->name] ?? 'fa-tag' }}"></i> 
                            {{ $category->name }}
                        </span>
                        <span class="category-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="col-lg-9">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="hero-slide-wrapper">
                            <img src="{{ asset('images/banner2.png') }}" alt="Banner 1" class="hero-slide-image">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="hero-slide-wrapper">
                            <img src="{{ asset('images/banner1.png') }}" alt="Banner 2" class="hero-slide-image">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="hero-slide-wrapper">
                            <img src="{{ asset('images/bluetooth.png') }}" alt="Banner 3" class="hero-slide-image">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="hero-slide-wrapper">
                            <img src="{{ asset('images/banner casual shoes.png') }}" alt="Banner 4" class="hero-slide-image">
                        </div>
                    </div>
                </div>
                
                <!-- Indicators - Image ke upar -->
                <div class="carousel-indicators" style="bottom: 15px; gap: 6px; z-index: 5;">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="width: 10px; height: 10px; border-radius: 50%; background-color: #fff; border: 2px solid rgba(255,255,255,0.5); margin: 0 3px; padding: 0; opacity: 0.8; transition: all 0.3s ease;"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2" style="width: 10px; height: 10px; border-radius: 50%; background-color: #fff; border: 2px solid rgba(255,255,255,0.5); margin: 0 3px; padding: 0; opacity: 0.8; transition: all 0.3s ease;"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3" style="width: 10px; height: 10px; border-radius: 50%; background-color: #fff; border: 2px solid rgba(255,255,255,0.5); margin: 0 3px; padding: 0; opacity: 0.8; transition: all 0.3s ease;"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4" style="width: 10px; height: 10px; border-radius: 50%; background-color: #fff; border: 2px solid rgba(255,255,255,0.5); margin: 0 3px; padding: 0; opacity: 0.8; transition: all 0.3s ease;"></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: nowrap; gap: 8px; width: 100%;">
                <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 6px 12px; flex: 1; min-width: 0;">
                    <div style="position: relative; padding-left: 14px; flex-shrink: 0;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: #db4444; border-radius: 2px;"></div>
                        <span style="color: #db4444; font-size: 13px; font-weight: 600; display: block;">Today's</span>
                        <h2 style="font-size: 22px; font-weight: 700; color: #000; margin: 0; line-height: 1.2;">Flash Sales</h2>
                    </div>
                    <div style="display: flex; align-items: center; gap: 2px 5px; flex-wrap: wrap; background: #f5f5f5; padding: 3px 12px; border-radius: 30px;">
                        <div style="text-align: center;"><span style="display: block; font-size: 7px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Days</span><span class="countdown-days" style="font-size: 18px; font-weight: 700; color: #000; line-height: 1.2;">03</span></div>
                        <span style="font-size: 16px; font-weight: 700; color: #db4444;">:</span>
                        <div style="text-align: center;"><span style="display: block; font-size: 7px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Hours</span><span class="countdown-hours" style="font-size: 18px; font-weight: 700; color: #000; line-height: 1.2;">12</span></div>
                        <span style="font-size: 16px; font-weight: 700; color: #db4444;">:</span>
                        <div style="text-align: center;"><span style="display: block; font-size: 7px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Mins</span><span class="countdown-minutes" style="font-size: 18px; font-weight: 700; color: #000; line-height: 1.2;">23</span></div>
                        <span style="font-size: 16px; font-weight: 700; color: #db4444;">:</span>
                        <div style="text-align: center;"><span style="display: block; font-size: 7px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Secs</span><span class="countdown-seconds" style="font-size: 18px; font-weight: 700; color: #000; line-height: 1.2;">23</span></div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 5px; flex-shrink: 0;">
                    <button class="flash-nav-btn" id="flashPrev" disabled><i class="fas fa-chevron-left"></i></button>
                    <button class="flash-nav-btn" id="flashNext"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Sales Products -->
<div class="container">
    <div class="flash-sales-wrapper mt-2">
        <div class="flash-sales-track" id="flashTrack">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <div class="product-image-wrapper">
                    @php
                        $discount = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                    @endphp
                    @if($discount > 0)<span class="discount-badge">-{{ $discount }}%</span>@endif
                    <div class="action-icons">
                        <a href="#" class="action-icon wishlist-heart" data-product-id="{{ $product->id }}"><i class="far fa-heart"></i></a>
                        <a href="#" class="action-icon" data-product-id="{{ $product->id }}"><i class="far fa-eye"></i></a>
                    </div>
                    <img src="{{ asset($product->images->first()->image_url ?? 'images/products/default.jpg') }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                </div>
                <div class="product-info">
                    <span class="product-category-tag"><i class="fas fa-tag"></i> {{ $product->category->name ?? 'Product' }}</span>
                    <h6 class="product-title">{{ $product->name }}</h6>
                    <div class="product-price">
                        ${{ number_format($product->sale_price ?? $product->price, 2) }} 
                        @if($product->sale_price) 
                            <span class="old-price">${{ number_format($product->price, 2) }}</span> 
                        @endif
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="rating-count">(88)</span>
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>



<div class="container mt-4 pt-2">
    <div class="row">
        <div class="col-12">
          
            <div style="width: 100%; margin-bottom: 2px;">
                <span class="text-danger fw-semibold category-header-label" style="font-size: 14px;">Categories</span>
            </div>
           
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: nowrap; width: 100%; margin-bottom: 15px;">
                <h2 class="fw-bold category-header-text" style="font-size: 22px; color: #000; margin: 0; line-height: 1.2; flex: 1; min-width: 0;">Browse By Category</h2>
                <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                    <button class="category-nav-btn" id="catPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="category-nav-btn" id="catNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="category-slider-wrapper">
        <div class="category-slider-track" id="categoryTrack">
            @php
                $categoryIconMap = [
    'Joggers' => 'fa-walking',
    'Casual Shoes' => 'fa-shoe-prints',
    'Sports Shoes' => 'fa-running',  // ← ADD
    'Watches' => 'fa-clock',
    'Smart Watches' => 'fa-clock',
    'Earbuds' => 'fa-headphones',
    'Sunglasses' => 'fa-glasses',
    'Mobile Accessories' => 'fa-mobile-alt',
    'Mobile' => 'fa-mobile-alt',
    'Power Banks' => 'fa-battery-full',
    'Chargers' => 'fa-bolt',
    'Laptops' => 'fa-laptop',
    'Gaming' => 'fa-gamepad',
    'Women' => 'fa-female',
    'Speakers' => 'fa-volume-up',
    'Perfume' => 'fa-spray-can',
    'Fashion' => 'fa-tshirt',
];
            @endphp
            @foreach($categories as $category)
            <div class="category-slide-item">
                <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="mb-1">
                            <i class="fas {{ $categoryIconMap[$category->name] ?? 'fa-tag' }} category-icon"></i>
                        </div>
                        <h6 class="category-name">{{ $category->name }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="container mt-4 pt-3">
    <div class="row">
        <div class="col-12">
            <div class="best-selling-header">
                <div>
                    <span class="text-danger fw-semibold fs-6">This Month</span>
                    <h2 class="fw-bold fs-2 mt-1 mb-0">Best Selling Products</h2>
                </div>
                <a href="{{ route('shop.index') }}" class="view-all-btn-sm">View All</a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($topRated as $product)
        <div class="col-6 col-md-3">
            <div class="product-card">
                <div class="product-image-wrapper">
                    @php
                        $discount = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                    @endphp
                    @if($discount > 0)<span class="discount-badge">-{{ $discount }}%</span>@endif
                    <div class="action-icons">
                        <a href="#" class="action-icon wishlist-heart" data-product-id="{{ $product->id }}"><i class="far fa-heart"></i></a>
                        <a href="#" class="action-icon" data-product-id="{{ $product->id }}"><i class="far fa-eye"></i></a>
                    </div>
                    <img src="{{ asset($product->images->first()->image_url ?? 'images/products/default.jpg') }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                </div>
                <div class="product-info">
                    <span class="product-category-tag"><i class="fas fa-tag"></i> {{ $product->category->name ?? 'Product' }}</span>
                    <h6 class="product-title">{{ $product->name }}</h6>
                    <div class="product-price">
                        ${{ number_format($product->sale_price ?? $product->price, 2) }} 
                        @if($product->sale_price) 
                            <span class="old-price">${{ number_format($product->price, 2) }}</span> 
                        @endif
                    </div>
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($product->reviews_avg_rating ?? 0) ? '' : '-o' }} text-warning"></i>
                        @endfor
                        <span class="rating-count">({{ $product->reviews_count ?? 0 }})</span>
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- ========================================
     SUMMER SALE BANNER - FIXED
     ======================================== -->
<div class="container mt-4 pt-2">
    <div class="row">
        <div class="col-12">
            <div class="enhance-banner" style="border-radius: 8px; overflow: hidden; margin: 20px 0; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <div class="row align-items-center g-0">
                    <!-- Left Side - Text (thoda right shift) -->
                    <div class="col-md-6" style="padding: 30px 40px;">
                        <span class="text-success fw-semibold d-inline-block px-3 py-1 rounded-pill" style="color: #00ff00 !important; background: rgba(0,255,0,0.1); font-size: 13px;">🔥 Summer Sale</span>
                        <h2 class="text-white fw-bold mt-2" style="font-size: 32px; line-height: 1.1;">Step Into<br>Casual Comfort</h2>
                        <p class="text-white-50 mt-2 mb-3" style="font-size: 14px;">Premium quality casual shoes for everyday comfort</p>
                        <div class="d-flex gap-2 mt-3 mb-3 flex-wrap">
                            <div class="timer-box">
                                <span class="timer-number" id="timerDays">04</span>
                                <span class="timer-label">DAYS</span>
                            </div>
                            <div class="timer-box">
                                <span class="timer-number" id="timerHours">19</span>
                                <span class="timer-label">HOURS</span>
                            </div>
                            <div class="timer-box">
                                <span class="timer-number" id="timerMinutes">17</span>
                                <span class="timer-label">MINS</span>
                            </div>
                            <div class="timer-box">
                                <span class="timer-number" id="timerSeconds">54</span>
                                <span class="timer-label">SECS</span>
                            </div>
                        </div>
                        <a href="{{ route('shop.index', ['category' => 'shoes']) }}" class="btn btn-success px-4 py-2 rounded-pill fw-semibold" style="background: #00ff00; border: none; color: #000; font-size: 14px;">Buy Now! <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                    
                    <!-- Right Side - Image (badhi hui) -->
                    <div class="col-md-6" style="padding: 20px 30px; display: flex; align-items: center; justify-content: center; min-height: 300px;">
                        <img src="{{ asset('images/summer sale.png') }}" alt="Casual Shoes" style="width: 100%; max-width: 90%; height: auto; max-height: 350px; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-4 pt-2">
    <div class="row">
        <div class="col-12">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: nowrap; gap: 10px; width: 100%; margin-bottom: 20px;">
                <div style="flex: 1; min-width: 0;">
                    <span class="text-danger fw-semibold fs-6">Our Products</span>
                    <h2 class="fw-bold fs-2 mt-1 mb-0">Explore Our Products</h2>
                </div>
                <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                    <button class="explore-nav-btn" style="width:30px; height:30px; border-radius:50%; border:1px solid #ddd; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.3s;"><i class="fas fa-chevron-left" style="font-size:11px; color:#333;"></i></button>
                    <button class="explore-nav-btn" style="width:30px; height:30px; border-radius:50%; border:1px solid #ddd; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.3s;"><i class="fas fa-chevron-right" style="font-size:11px; color:#333;"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($newArrivals as $product)
        <div class="col-6 col-md-3">
            <div class="product-card">
                <div class="product-image-wrapper">
                    @php
                        $discount = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                    @endphp
                    @if($loop->first)<span class="new-badge">NEW</span>@endif
                    @if($discount > 0)<span class="discount-badge">-{{ $discount }}%</span>@endif
                    <div class="action-icons">
                        <a href="#" class="action-icon wishlist-heart" data-product-id="{{ $product->id }}"><i class="far fa-heart"></i></a>
                        <a href="#" class="action-icon" data-product-id="{{ $product->id }}"><i class="far fa-eye"></i></a>
                    </div>
                    <img src="{{ asset($product->images->first()->image_url ?? 'images/products/default.jpg') }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                </div>
                <div class="product-info">
                    <span class="product-category-tag"><i class="fas fa-tag"></i> {{ $product->category->name ?? 'Product' }}</span>
                    <h6 class="product-title">{{ $product->name }}</h6>
                    <div class="product-price">
                        ${{ number_format($product->sale_price ?? $product->price, 2) }} 
                        @if($product->sale_price) 
                            <span class="old-price">${{ number_format($product->price, 2) }}</span> 
                        @endif
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="rating-count">(88)</span>
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-3 mb-4">
        <div class="col-12 text-center">
            <a href="{{ route('shop.index') }}" class="btn btn-danger px-4 py-2 rounded" style="background: #db4444; border: none; font-size: 14px;">View All Products</a>
        </div>
    </div>
</div>

<div class="container mt-4 pt-2">
    <div class="row">
        <div class="col-12">
            <div class="section-header" style="margin-bottom: 20px;">
                <span class="text-danger fw-semibold fs-6">Featured</span>
                <h2 class="fw-bold fs-2 mt-1 mb-3">New Arrival</h2>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="new-arrival-card" style="min-height: 220px;">
                <div style="position:absolute; bottom:15px; left:15px; z-index:2;">
                    <h3 style="color:#fff; font-weight:700; margin-bottom:3px; font-size:18px;">PlayStation 5</h3>
                    <p style="color:rgba(255,255,255,0.6); margin-bottom:4px; font-size:12px;">Black and White version of the PS5 coming out on sale.</p>
                    <a href="{{ route('shop.index', ['category' => 'gaming']) }}" class="shop-now-btn" style="color:#fff; border-bottom:2px solid #fff; padding-bottom:2px; text-decoration:none; font-size:12px;">Shop Now →</a>
                </div>
                <img src="{{ asset('images/feature.png') }}" alt="PlayStation 5" style="position:absolute; bottom:0; right:0; max-width:55%; height:auto; object-fit:contain; background:transparent; z-index:0;">
            </div>
        </div>

        <div class="col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <div class="new-arrival-card" style="min-height: 150px;">
                        <div style="position:absolute; bottom:12px; left:12px; z-index:2;">
                            <h4 style="color:#fff; font-weight:700; margin-bottom:2px; font-size:15px;">Women's Collections</h4>
                            <p style="color:rgba(255,255,255,0.6); margin-bottom:3px; font-size:11px;">Featured women collections that give you another view.</p>
                            <a href="{{ route('shop.index', ['category' => 'women']) }}" class="shop-now-btn" style="color:#fff; border-bottom:2px solid #fff; padding-bottom:2px; text-decoration:none; font-size:11px;">Shop Now →</a>
                        </div>
                        <img src="{{ asset('images/women.png') }}" alt="Women Collection" style="position:absolute; bottom:0; right:0; max-width:45%; height:auto; object-fit:contain; background:transparent; z-index:0;">
                    </div>
                </div>
                <div class="col-6">
                    <div class="new-arrival-card" style="min-height: 150px;">
                        <div style="position:absolute; bottom:8px; left:10px; z-index:2;">
                            <h5 style="color:#fff; font-weight:700; margin-bottom:1px; font-size:13px;">Speakers</h5>
                            <p style="color:rgba(255,255,255,0.6); margin-bottom:2px; font-size:9px;">Amazon wireless</p>
                            <a href="{{ route('shop.index', ['category' => 'speakers']) }}" class="shop-now-btn" style="color:#fff; border-bottom:2px solid #fff; padding-bottom:1px; text-decoration:none; font-size:9px;">Shop Now →</a>
                        </div>
                        <img src="{{ asset('images/speaker.png') }}" alt="Speakers" style="position:absolute; bottom:0; right:0; max-width:50%; height:auto; object-fit:contain; background:transparent; z-index:0;">
                    </div>
                </div>
                <div class="col-6">
                    <div class="new-arrival-card" style="min-height: 150px;">
                        <div style="position:absolute; bottom:8px; left:10px; z-index:2;">
                            <h5 style="color:#fff; font-weight:700; margin-bottom:1px; font-size:13px;">Perfume</h5>
                            <p style="color:rgba(255,255,255,0.6); margin-bottom:2px; font-size:9px;">GUCCI INTENSE</p>
                            <a href="{{ route('shop.index', ['category' => 'perfume']) }}" class="shop-now-btn" style="color:#fff; border-bottom:2px solid #fff; padding-bottom:1px; text-decoration:none; font-size:9px;">Shop Now →</a>
                        </div>
                        <img src="{{ asset('images/perfume.png') }}" alt="Perfume" style="position:absolute; bottom:0; right:0; max-width:50%; height:auto; object-fit:contain; background:transparent; z-index:0;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="footer-services">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <div class="service-card">
                    <div class="service-img"><img src="{{ asset('images/footer1.png') }}" alt="Fast Delivery"></div>
                    <h5 class="service-title">FREE AND FAST DELIVERY</h5>
                    <p class="service-desc">Free delivery for all orders over $140</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-3">
                <div class="service-card">
                    <div class="service-img"><img src="{{ asset('images/footer2.png') }}" alt="Customer Service"></div>
                    <h5 class="service-title">24/7 CUSTOMER SERVICE</h5>
                    <p class="service-desc">Friendly 24/7 customer support</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-3">
                <div class="service-card">
                    <div class="service-img"><img src="{{ asset('images/footer3.png') }}" alt="Money Back"></div>
                    <h5 class="service-title">MONEY BACK GUARANTEE</h5>
                    <p class="service-desc">We return money within 30 days</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
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

    // ===== Summer Sale Countdown =====
    function startCountdown() {
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 5);
        targetDate.setHours(13, 36, 55, 0);
        function updateTimer() {
            const now = new Date();
            const diff = targetDate - now;
            if (diff > 0) {
                document.getElementById('timerDays').textContent = String(Math.floor(diff / 86400000)).padStart(2, '0');
                document.getElementById('timerHours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
                document.getElementById('timerMinutes').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                document.getElementById('timerSeconds').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            }
        }
        updateTimer();
        setInterval(updateTimer, 1000);
    }
    startCountdown();

    // ===== FLASH SALES SCROLL =====
    $(document).ready(function() {
        const track = document.getElementById('flashTrack');
        const prevBtn = document.getElementById('flashPrev');
        const nextBtn = document.getElementById('flashNext');

        function getVisibleCount() {
            if (window.innerWidth <= 576) return 3;
            if (window.innerWidth <= 768) return 3;
            if (window.innerWidth <= 992) return 3;
            return 4;
        }

        let currentIndex = 0;
        const totalCards = track.children.length;
        let visibleCount = getVisibleCount();
        let maxIndex = Math.max(0, totalCards - visibleCount);

        function updateButtons() {
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
        }

        function slideTo(index) {
            if (index < 0) index = 0;
            if (index > maxIndex) index = maxIndex;
            currentIndex = index;
            const cardWidth = track.children[0].offsetWidth + 15;
            track.style.transform = 'translateX(-' + (currentIndex * cardWidth) + 'px)';
            updateButtons();
        }

        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) slideTo(currentIndex + 1);
        });

        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) slideTo(currentIndex - 1);
        });

        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const newVisible = getVisibleCount();
                if (newVisible !== visibleCount) {
                    visibleCount = newVisible;
                    maxIndex = Math.max(0, totalCards - visibleCount);
                    if (currentIndex > maxIndex) currentIndex = maxIndex;
                    slideTo(currentIndex);
                }
            }, 250);
        });

        slideTo(0);
    });

    // ===== CATEGORY SLIDER =====
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('categoryTrack');
        const prevBtn = document.getElementById('catPrev');
        const nextBtn = document.getElementById('catNext');
        
        function getVisibleCount() {
            const width = window.innerWidth;
            if (width <= 400) return 2;
            if (width <= 576) return 3;
            if (width <= 768) return 3;
            if (width <= 992) return 4;
            return 8;  // 8 categories visible on desktop
        }
        
        let currentIndex = 0;
        const totalItems = track.children.length;
        let visibleCount = getVisibleCount();
        let maxIndex = Math.max(0, totalItems - visibleCount);
        
        function updateButtons() {
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
            prevBtn.style.opacity = currentIndex === 0 ? '0.4' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.4' : '1';
        }
        
        function slideTo(index) {
            if (index < 0) index = 0;
            if (index > maxIndex) index = maxIndex;
            currentIndex = index;
            
            const firstItem = track.children[0];
            if (firstItem) {
                const gap = 12;
                const itemWidth = firstItem.offsetWidth + gap;
                track.style.transform = 'translateX(-' + (currentIndex * itemWidth) + 'px)';
            }
            updateButtons();
        }
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) {
                slideTo(currentIndex + 1);
            }
        });
        
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                slideTo(currentIndex - 1);
            }
        });
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const newVisible = getVisibleCount();
                if (newVisible !== visibleCount) {
                    visibleCount = newVisible;
                    maxIndex = Math.max(0, totalItems - visibleCount);
                    if (currentIndex > maxIndex) {
                        currentIndex = maxIndex;
                    }
                    track.style.transition = 'none';
                    track.style.transform = 'translateX(0)';
                    setTimeout(function() {
                        track.style.transition = 'transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                        slideTo(currentIndex);
                    }, 50);
                }
            }, 200);
        });
        
        setTimeout(function() {
            visibleCount = getVisibleCount();
            maxIndex = Math.max(0, totalItems - visibleCount);
            slideTo(0);
        }, 100);
    });

    // ===== WISHLIST HEART =====
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

    // ===== Cart & Wishlist Count =====
    $.get('{{ url("/cart/count") }}', function(data) { $('#cartCount').text(data.count || 0); });
    $.get('{{ url("/wishlist/count") }}', function(data) { $('#wishlistCount').text(data.count || 0); });

    // ===== Search =====
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            window.location.href = '{{ route("shop.index") }}?search=' + $(this).val();
        }
    });
</script>
@endsection