@extends('layouts.app')

@section('title', 'About Us - StyleHub')

@section('content')
<style>
    /* ===== HERO ===== */
    .about-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
        padding: 80px 0 60px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .about-hero h1 {
        font-weight: 800;
        font-size: 42px;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .about-hero h1 span {
        color: #db4444;
    }
    .about-hero p {
        color: rgba(255,255,255,0.7);
        font-size: 17px;
        max-width: 550px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ===== SECTION TITLE ===== */
    .section-title {
        font-weight: 700;
        font-size: 30px;
        color: #1a1a2e;
        text-align: center;
        margin-bottom: 6px;
    }
    .section-title span {
        color: #db4444;
    }
    .section-subtitle {
        color: #8c8c9c;
        text-align: center;
        font-size: 15px;
        margin-bottom: 32px;
    }

    /* ===== STORY ===== */
    .story-section {
        padding: 60px 0;
        background: #fff;
    }
    .story-section .story-text {
        font-size: 15px;
        color: #555;
        line-height: 1.9;
    }
    .story-section .story-text p {
        margin-bottom: 14px;
    }
    .story-section .story-text strong {
        color: #1a1a2e;
    }
    .story-section .story-image {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        height: 380px;
        background: #f5f5f5;
        width: 100%;
    }
    .story-section .story-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ===== VALUES ===== */
    .values-section {
        background: #f8f9fa;
        padding: 60px 0;
    }
    .value-card {
        background: #fff;
        border-radius: 14px;
        padding: 28px 20px;
        text-align: center;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        height: 100%;
    }
    .value-card:hover {
        border-color: #db4444;
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }
    .value-card .icon-wrap {
        width: 60px;
        height: 60px;
        background: #fef0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    .value-card .icon-wrap i {
        font-size: 26px;
        color: #db4444;
    }
    .value-card h5 {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .value-card p {
        color: #8c8c9c;
        font-size: 13px;
        margin: 0;
    }

    /* ===== STATS ===== */
    .stats-section {
        background: #1a1a2e;
        padding: 10px 0;
        overflow: hidden;
        position: relative;
    }
    .stats-track {
        display: flex;
        gap: 60px;
        animation: scrollStats 25s linear infinite;
        white-space: nowrap;
    }
    .stats-track .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fff;
        flex-shrink: 0;
    }
    .stats-track .stat-item .number {
        font-size: 32px;
        font-weight: 600;
        color: #db4444;
    }
    .stats-track .stat-item .label {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        font-weight: 500;
    }
    .stats-track .stat-item .divider {
        width: 1px;
        height: 30px;
        background: rgba(255,255,255,0.1);
        margin-left: 20px;
    }
    @keyframes scrollStats {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* ===== TEAM - BIGGER & BETTER ===== */
    .team-section {
        padding: 60px 0;
        background: #fff;
    }
    .team-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 16px;
        text-align: center;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        height: 100%;
    }
    .team-card:hover {
        border-color: #db4444;
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .team-card .avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        margin: 0 auto 14px;
        overflow: hidden;
        border: 4px solid #f0f0f0;
        transition: all 0.3s;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .team-card .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .team-card:hover .avatar {
        border-color: #db4444;
        transform: scale(1.05);
    }
    .team-card .avatar .fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #db4444;
        background: #fef0f0;
    }
    .team-card h5 {
        font-weight: 700;
        font-size: 17px;
        color: #1a1a2e;
        margin-bottom: 2px;
    }
    .team-card p {
        color: #8c8c9c;
        font-size: 14px;
        margin: 0;
    }

    /* ===== CTA ===== */
    .cta-section {
        background: linear-gradient(135deg, #1a1a2e, #2d2d44);
        padding: 50px 0;
        text-align: center;
        color: #fff;
    }
    .cta-section h2 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .cta-section h2 span {
        color: #db4444;
    }
    .cta-section p {
        color: rgba(255,255,255,0.6);
        font-size: 15px;
        margin-bottom: 20px;
    }
    .cta-section .btn-cta {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 11px 40px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .cta-section .btn-cta:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(219,68,68,0.2);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .story-section .story-image {
            height: 300px;
        }
        .team-card .avatar {
            width: 110px;
            height: 110px;
        }
    }
    @media (max-width: 768px) {
        .about-hero { padding: 50px 0 40px; }
        .about-hero h1 { font-size: 30px; }
        .about-hero p { font-size: 15px; padding: 0 15px; }
        .section-title { font-size: 24px; }
        .story-section { padding: 40px 0; }
        .story-section .story-image { height: 220px; }
        .values-section { padding: 40px 0; }
        .team-section { padding: 40px 0; }
        .team-card .avatar { width: 90px; height: 90px; }
        .cta-section h2 { font-size: 24px; }
        .stats-track .stat-item .number { font-size: 24px; }
        .stats-track .stat-item .label { font-size: 12px; }
        .stats-track { gap: 30px; }
        .story-section .story-text {
            text-align: center;
        }
        .section-title {
            text-align: center !important;
        }
    }
    @media (max-width: 480px) {
        .about-hero h1 { font-size: 24px; }
        .section-title { font-size: 20px; }
        .value-card { padding: 18px 14px; }
        .value-card .icon-wrap { width: 48px; height: 48px; }
        .value-card .icon-wrap i { font-size: 20px; }
        .stats-track .stat-item .number { font-size: 18px; }
        .stats-track .stat-item .label { font-size: 10px; }
        .stats-track { gap: 20px; }
        .team-card .avatar { width: 70px; height: 70px; }
        .team-card .avatar .fallback { font-size: 30px; }
        .cta-section h2 { font-size: 20px; }
        .cta-section .btn-cta { padding: 10px 28px; font-size: 14px; }
        .story-section .story-image { height: 180px; }
    }
</style>

<!-- ===== HERO ===== -->
<section class="about-hero">
    <div class="container">
        <h1>About <span>StyleHub</span></h1>
        <p>Your trusted destination for premium fashion and tech accessories</p>
    </div>
</section>

<!-- ===== OUR STORY ===== -->
<section class="story-section">
    <div class="container">
        <h2 class="section-title" style="text-align:left;">Our <span>Story</span></h2>
        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <div class="story-text">
                    <p>
                        <strong>StyleHub</strong> was born from a simple idea: to make premium 
                        fashion and tech accessories accessible to everyone. What started as a 
                        small passion project has grown into a trusted online destination.
                    </p>
                    <p>
                        We believe that quality and style shouldn't be complicated. That's why 
                        we carefully curate each product — from classic watches to modern tech 
                        accessories — ensuring they meet our high standards.
                    </p>
                    <p>
                        Today, we're proud to serve thousands of happy customers who trust us 
                        for their style needs. Our commitment to quality and customer satisfaction 
                        remains at the heart of everything we do.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="story-image">
                    <img src="{{ asset('images/login.jpg') }}" alt="About StyleHub">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== VALUES ===== -->
<section class="values-section">
    <div class="container">
        <h2 class="section-title">Our <span>Values</span></h2>
        <p class="section-subtitle">What drives us every day</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <div class="icon-wrap"><i class="fas fa-gem"></i></div>
                    <h5>Quality</h5>
                    <p>We never compromise</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <div class="icon-wrap"><i class="fas fa-heart"></i></div>
                    <h5>Trust</h5>
                    <p>Your satisfaction matters</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <div class="icon-wrap"><i class="fas fa-leaf"></i></div>
                    <h5>Sustainability</h5>
                    <p>Eco-friendly choices</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="value-card">
                    <div class="icon-wrap"><i class="fas fa-bolt"></i></div>
                    <h5>Innovation</h5>
                    <p>Always improving</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS ===== -->
<section class="stats-section">
    <div class="container-fluid px-0">
        <div class="stats-track">
            <span class="stat-item">
                <span class="number">50K+</span>
                <span class="label">Happy Customers</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">10K+</span>
                <span class="label">Products Sold</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">4.8★</span>
                <span class="label">Average Rating</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">24/7</span>
                <span class="label">Customer Support</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">50+</span>
                <span class="label">Brands</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">20+</span>
                <span class="label">Countries</span>
                <span class="divider"></span>
            </span>
            <!-- Duplicate for infinite scroll -->
            <span class="stat-item">
                <span class="number">50K+</span>
                <span class="label">Happy Customers</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">10K+</span>
                <span class="label">Products Sold</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">4.8★</span>
                <span class="label">Average Rating</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">24/7</span>
                <span class="label">Customer Support</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">50+</span>
                <span class="label">Brands</span>
                <span class="divider"></span>
            </span>
            <span class="stat-item">
                <span class="number">20+</span>
                <span class="label">Countries</span>
                <span class="divider"></span>
            </span>
        </div>
    </div>
</section>

<!-- ===== TEAM ===== -->
<section class="team-section">
    <div class="container">
        <h2 class="section-title">Meet the <span>Team</span></h2>
        <p class="section-subtitle">The passionate people behind StyleHub</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-6">
                <div class="team-card">
                    <div class="avatar">
                        <img src="{{ asset('images/sahrish.jpg') }}" alt="Sahrish Yaseen"
                             onerror="this.parentElement.innerHTML='<div class=fallback>👩</div>'">
                    </div>
                    <h5>Sahrish Yaseen</h5>
                    <p>CEO & Founder</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="team-card">
                    <div class="avatar">
                        <img src="{{ asset('images/ali.jpg') }}" alt="Ali Khan"
                             onerror="this.parentElement.innerHTML='<div class=fallback>👨</div>'">
                    </div>
                    <h5>Ali Khan</h5>
                    <p>Head of Operations</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="team-card">
                    <div class="avatar">
                        <img src="{{ asset('images/maria.jpg') }}" alt="Maira Hassan"
                             onerror="this.parentElement.innerHTML='<div class=fallback>👩</div>'">
                    </div>
                    <h5>Maira Hassan</h5>
                    <p>Product Curator</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="team-card">
                    <div class="avatar">
                        <img src="{{ asset('images/usman.jpg') }}" alt="Usman Raza"
                             onerror="this.parentElement.innerHTML='<div class=fallback>👨</div>'">
                    </div>
                    <h5>Usman Raza</h5>
                    <p>Customer Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Explore <span>StyleHub</span>?</h2>
        <p>Discover our curated collection of premium products.</p>
        <a href="{{ route('shop.index') }}" class="btn-cta">
            <i class="fas fa-store me-2"></i> Shop Now
        </a>
    </div>
</section>
@endsection