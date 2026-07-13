@extends('layouts.app')

@section('title', 'Terms & Conditions - StyleHub')

@section('content')
<style>
    /* ========================================
       TERMS & CONDITIONS - FULLY RESPONSIVE
       ======================================== */
    .terms-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .terms-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        overflow: hidden;
        background: #fff;
    }
    
    /* ===== HEADER ===== */
    .terms-card .card-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 35px 40px;
        border-bottom: none;
    }
    .terms-card .card-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        color: #fff;
        margin: 0;
    }
    .terms-card .card-header p {
        color: rgba(255,255,255,0.6);
        margin: 5px 0 0;
        font-size: 14px;
    }
    .terms-badge {
        display: inline-block;
        background: #e94560;
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    
    /* ===== BODY ===== */
    .terms-card .card-body {
        padding: 40px;
    }
    .terms-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
    }
    .terms-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .terms-section h5 {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 17px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .terms-section h5 .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #e94560;
        color: #fff;
        border-radius: 50%;
        font-size: 14px;
        flex-shrink: 0;
    }
    .terms-section p {
        color: #555;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 8px;
    }
    .terms-section ul {
        padding-left: 20px;
        margin-bottom: 5px;
    }
    .terms-section ul li {
        color: #555;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 4px;
    }
    .terms-section ul li::marker {
        color: #e94560;
    }
    
    /* ===== FOOTER ===== */
    .terms-footer {
        background: #f8f9fc;
        padding: 25px 40px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .terms-footer .btn-back {
        background: #e94560;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .terms-footer .btn-back:hover {
        background: #c23152;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(233, 69, 96, 0.3);
        color: #fff;
    }
    .terms-footer .btn-print {
        background: transparent;
        border: 2px solid #e8e8f0;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 14px;
        color: #555;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .terms-footer .btn-print:hover {
        border-color: #e94560;
        color: #e94560;
    }
    
    /* ========================================
       RESPONSIVE - TABLET
       ======================================== */
    @media (max-width: 992px) {
        .terms-wrapper {
            padding: 15px;
        }
        .terms-card .card-header {
            padding: 30px 30px;
        }
        .terms-card .card-header h1 {
            font-size: 28px;
        }
        .terms-card .card-body {
            padding: 30px;
        }
        .terms-footer {
            padding: 20px 30px;
        }
    }
    
    /* ========================================
       RESPONSIVE - MOBILE LANDSCAPE
       ======================================== */
    @media (max-width: 768px) {
        .terms-wrapper {
            padding: 12px;
        }
        .terms-card {
            border-radius: 16px;
        }
        .terms-card .card-header {
            padding: 25px 20px;
        }
        .terms-card .card-header h1 {
            font-size: 24px;
        }
        .terms-card .card-header p {
            font-size: 13px;
        }
        .terms-card .card-body {
            padding: 25px 20px;
        }
        .terms-section {
            margin-bottom: 22px;
            padding-bottom: 20px;
        }
        .terms-section h5 {
            font-size: 16px;
        }
        .terms-section h5 .icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        .terms-section p,
        .terms-section ul li {
            font-size: 14px;
        }
        .terms-footer {
            padding: 18px 20px;
            flex-direction: column;
            text-align: center;
        }
        .terms-footer .btn-back,
        .terms-footer .btn-print {
            width: 100%;
            justify-content: center;
        }
        .terms-badge {
            font-size: 9px;
            padding: 2px 10px;
        }
    }
    
    /* ========================================
       RESPONSIVE - MOBILE PORTRAIT
       ======================================== */
    @media (max-width: 576px) {
        .terms-wrapper {
            padding: 8px;
        }
        .terms-card {
            border-radius: 12px;
        }
        .terms-card .card-header {
            padding: 20px 16px;
        }
        .terms-card .card-header h1 {
            font-size: 20px;
        }
        .terms-card .card-header p {
            font-size: 12px;
        }
        .terms-card .card-body {
            padding: 18px 14px;
        }
        .terms-section {
            margin-bottom: 18px;
            padding-bottom: 16px;
        }
        .terms-section h5 {
            font-size: 14px;
            gap: 10px;
        }
        .terms-section h5 .icon {
            width: 24px;
            height: 24px;
            font-size: 11px;
        }
        .terms-section p,
        .terms-section ul li {
            font-size: 13px;
            line-height: 1.6;
        }
        .terms-section ul {
            padding-left: 16px;
        }
        .terms-footer {
            padding: 15px 14px;
            gap: 10px;
        }
        .terms-footer .btn-back,
        .terms-footer .btn-print {
            padding: 10px 20px;
            font-size: 13px;
        }
        .terms-badge {
            font-size: 8px;
            padding: 2px 8px;
        }
        .terms-card .card-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px;
        }
    }
    
    /* ========================================
       RESPONSIVE - VERY SMALL MOBILE
       ======================================== */
    @media (max-width: 400px) {
        .terms-wrapper {
            padding: 5px;
        }
        .terms-card {
            border-radius: 10px;
        }
        .terms-card .card-header {
            padding: 16px 12px;
        }
        .terms-card .card-header h1 {
            font-size: 17px;
        }
        .terms-card .card-header p {
            font-size: 11px;
        }
        .terms-card .card-body {
            padding: 14px 10px;
        }
        .terms-section {
            margin-bottom: 14px;
            padding-bottom: 12px;
        }
        .terms-section h5 {
            font-size: 13px;
            gap: 8px;
        }
        .terms-section h5 .icon {
            width: 22px;
            height: 22px;
            font-size: 10px;
        }
        .terms-section p,
        .terms-section ul li {
            font-size: 12px;
            line-height: 1.5;
        }
        .terms-section ul {
            padding-left: 14px;
        }
        .terms-footer {
            padding: 12px 10px;
            gap: 8px;
        }
        .terms-footer .btn-back,
        .terms-footer .btn-print {
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 30px;
        }
        .terms-footer .btn-back i,
        .terms-footer .btn-print i {
            font-size: 12px;
        }
        .terms-badge {
            font-size: 7px;
            padding: 2px 6px;
        }
    }
</style>

<div class="terms-wrapper">
    <div class="card terms-card">
        
        <!-- Header -->
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1><i class="fas fa-file-contract me-2"></i> Terms & Conditions</h1>
                    <p>Last updated: {{ date('F d, Y') }}</p>
                </div>
                <span class="terms-badge"><i class="fas fa-check-circle me-1"></i> Version 2.0</span>
            </div>
        </div>
        
        <!-- Body -->
        <div class="card-body">
            
            <div class="terms-section">
                <h5><span class="icon">1</span> Introduction</h5>
                <p>Welcome to <strong>StyleHub</strong>. By accessing or using our website, mobile application, and services, you agree to be bound by these Terms & Conditions. If you do not agree with any part of these terms, please do not use our services.</p>
                <p>These terms constitute a legally binding agreement between you and StyleHub regarding your use of our platform.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">2</span> Use of Website</h5>
                <p>You agree to use our website only for lawful purposes and in a manner that does not infringe the rights of others. You must not:</p>
                <ul>
                    <li>Use the website for any fraudulent or unlawful purpose</li>
                    <li>Copy, modify, distribute, or reproduce any content without permission</li>
                    <li>Attempt to gain unauthorized access to our systems</li>
                    <li>Use automated systems to access or scrape data from the website</li>
                    <li>Interfere with the security or performance of the website</li>
                </ul>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">3</span> Account Registration</h5>
                <p>To access certain features, you may need to create an account. You agree to:</p>
                <ul>
                    <li>Provide accurate, current, and complete information</li>
                    <li>Maintain the confidentiality of your account credentials</li>
                    <li>Notify us immediately of any unauthorized use of your account</li>
                    <li>Be responsible for all activities that occur under your account</li>
                </ul>
                <p>We reserve the right to suspend or terminate accounts that violate these terms.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">4</span> Products and Pricing</h5>
                <p>All products displayed on our website are subject to availability. We strive to provide accurate product descriptions and pricing, but errors may occur. We reserve the right to:</p>
                <ul>
                    <li>Modify or discontinue any product at any time</li>
                    <li>Correct pricing errors even after an order has been placed</li>
                    <li>Limit the quantity of products available for purchase</li>
                </ul>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">5</span> Orders and Payment</h5>
                <p>When you place an order, you agree to provide accurate and complete information. All orders are subject to acceptance and verification. We may:</p>
                <ul>
                    <li>Refuse or cancel any order at our discretion</li>
                    <li>Require additional verification before processing an order</li>
                    <li>Limit the quantity of items that can be purchased</li>
                </ul>
                <p>Payment must be made at the time of order placement. We accept various payment methods as indicated on our website.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">6</span> Shipping and Delivery</h5>
                <p>We strive to deliver your orders within the estimated time frames. However, we are not responsible for delays caused by:</p>
                <ul>
                    <li>Customs clearance procedures</li>
                    <li>Weather conditions or natural disasters</li>
                    <li>Carrier or shipping partner delays</li>
                    <li>Incorrect shipping information provided by you</li>
                </ul>
                <p>Risk of loss and title for products pass to you upon delivery.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">7</span> Returns and Refunds</h5>
                <p>We offer a <strong>30-day return policy</strong> on most products. To be eligible for a return:</p>
                <ul>
                    <li>Items must be in their original condition and packaging</li>
                    <li>Items must be unworn, unused, and with all tags attached</li>
                    <li>Proof of purchase must be provided</li>
                </ul>
                <p>Refunds will be processed within 7-10 business days after we receive and inspect the returned item. Shipping costs are non-refundable.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">8</span> Intellectual Property</h5>
                <p>All content on this website, including text, images, logos, graphics, and software, is the property of StyleHub and protected by copyright and intellectual property laws. You may not:</p>
                <ul>
                    <li>Reproduce, distribute, or create derivative works from our content</li>
                    <li>Use our trademarks or branding without permission</li>
                    <li>Copy or imitate our website design or layout</li>
                </ul>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">9</span> Limitation of Liability</h5>
                <p>To the fullest extent permitted by law, StyleHub shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our services. Our total liability shall not exceed the amount you paid for the products in question.</p>
                <p>We provide our services on an "AS IS" and "AS AVAILABLE" basis without warranties of any kind.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">10</span> Changes to Terms</h5>
                <p>We reserve the right to update or modify these Terms & Conditions at any time without prior notice. Changes will be effective immediately upon posting on this page. Your continued use of our services constitutes acceptance of the updated terms.</p>
                <p>We encourage you to review these terms periodically to stay informed of any changes.</p>
            </div>
            
            <div class="terms-section">
                <h5><span class="icon">11</span> Contact Us</h5>
                <p>If you have any questions, concerns, or feedback about these Terms & Conditions, please don't hesitate to reach out to us:</p>
                <ul>
                    <li><i class="fas fa-envelope text-danger me-2"></i> <a href="mailto:support@stylehub.com" class="text-decoration-none">support@stylehub.com</a></li>
                    <li><i class="fas fa-phone-alt text-danger me-2"></i> +91-98765-43210</li>
                    <li><i class="fas fa-map-marker-alt text-danger me-2"></i> 123 Fashion Street, Mumbai, India</li>
                </ul>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="terms-footer">
            <a href="{{ route('register') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Register
            </a>
            <a href="javascript:window.print()" class="btn-print">
                <i class="fas fa-print"></i> Print Page
            </a>
        </div>
        
    </div>
</div>
@endsection