@extends('layouts.app')

@section('title', 'Privacy Policy - StyleHub')

@section('content')
<style>
    /* ========================================
       PRIVACY POLICY - FULLY RESPONSIVE
       ======================================== */
    .privacy-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .privacy-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        overflow: hidden;
        background: #fff;
    }
    
    /* ===== HEADER ===== */
    .privacy-card .card-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 35px 40px;
        border-bottom: none;
    }
    .privacy-card .card-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        color: #fff;
        margin: 0;
    }
    .privacy-card .card-header p {
        color: rgba(255,255,255,0.6);
        margin: 5px 0 0;
        font-size: 14px;
    }
    .privacy-badge {
        display: inline-block;
        background: #00a651;
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
    .privacy-card .card-body {
        padding: 40px;
    }
    .privacy-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
    }
    .privacy-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .privacy-section h5 {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 17px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .privacy-section h5 .icon {
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
    .privacy-section p {
        color: #555;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 8px;
    }
    .privacy-section ul {
        padding-left: 20px;
        margin-bottom: 5px;
    }
    .privacy-section ul li {
        color: #555;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 4px;
    }
    .privacy-section ul li::marker {
        color: #e94560;
    }
    
    /* ===== FOOTER ===== */
    .privacy-footer {
        background: #f8f9fc;
        padding: 25px 40px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .privacy-footer .btn-back {
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
    .privacy-footer .btn-back:hover {
        background: #c23152;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(233, 69, 96, 0.3);
        color: #fff;
    }
    .privacy-footer .btn-print {
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
    .privacy-footer .btn-print:hover {
        border-color: #e94560;
        color: #e94560;
    }
    
    /* ========================================
       RESPONSIVE - TABLET
       ======================================== */
    @media (max-width: 992px) {
        .privacy-wrapper {
            padding: 15px;
        }
        .privacy-card .card-header {
            padding: 30px 30px;
        }
        .privacy-card .card-header h1 {
            font-size: 28px;
        }
        .privacy-card .card-body {
            padding: 30px;
        }
        .privacy-footer {
            padding: 20px 30px;
        }
    }
    
    /* ========================================
       RESPONSIVE - MOBILE LANDSCAPE
       ======================================== */
    @media (max-width: 768px) {
        .privacy-wrapper {
            padding: 12px;
        }
        .privacy-card {
            border-radius: 16px;
        }
        .privacy-card .card-header {
            padding: 25px 20px;
        }
        .privacy-card .card-header h1 {
            font-size: 24px;
        }
        .privacy-card .card-header p {
            font-size: 13px;
        }
        .privacy-card .card-body {
            padding: 25px 20px;
        }
        .privacy-section {
            margin-bottom: 22px;
            padding-bottom: 20px;
        }
        .privacy-section h5 {
            font-size: 16px;
        }
        .privacy-section h5 .icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        .privacy-section p,
        .privacy-section ul li {
            font-size: 14px;
        }
        .privacy-footer {
            padding: 18px 20px;
            flex-direction: column;
            text-align: center;
        }
        .privacy-footer .btn-back,
        .privacy-footer .btn-print {
            width: 100%;
            justify-content: center;
        }
        .privacy-badge {
            font-size: 9px;
            padding: 2px 10px;
        }
    }
    
    /* ========================================
       RESPONSIVE - MOBILE PORTRAIT
       ======================================== */
    @media (max-width: 576px) {
        .privacy-wrapper {
            padding: 8px;
        }
        .privacy-card {
            border-radius: 12px;
        }
        .privacy-card .card-header {
            padding: 20px 16px;
        }
        .privacy-card .card-header h1 {
            font-size: 20px;
        }
        .privacy-card .card-header p {
            font-size: 12px;
        }
        .privacy-card .card-body {
            padding: 18px 14px;
        }
        .privacy-section {
            margin-bottom: 18px;
            padding-bottom: 16px;
        }
        .privacy-section h5 {
            font-size: 14px;
            gap: 10px;
        }
        .privacy-section h5 .icon {
            width: 24px;
            height: 24px;
            font-size: 11px;
        }
        .privacy-section p,
        .privacy-section ul li {
            font-size: 13px;
            line-height: 1.6;
        }
        .privacy-section ul {
            padding-left: 16px;
        }
        .privacy-footer {
            padding: 15px 14px;
            gap: 10px;
        }
        .privacy-footer .btn-back,
        .privacy-footer .btn-print {
            padding: 10px 20px;
            font-size: 13px;
        }
        .privacy-badge {
            font-size: 8px;
            padding: 2px 8px;
        }
        .privacy-card .card-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px;
        }
    }
    
    /* ========================================
       RESPONSIVE - VERY SMALL MOBILE
       ======================================== */
    @media (max-width: 400px) {
        .privacy-wrapper {
            padding: 5px;
        }
        .privacy-card {
            border-radius: 10px;
        }
        .privacy-card .card-header {
            padding: 16px 12px;
        }
        .privacy-card .card-header h1 {
            font-size: 17px;
        }
        .privacy-card .card-header p {
            font-size: 11px;
        }
        .privacy-card .card-body {
            padding: 14px 10px;
        }
        .privacy-section {
            margin-bottom: 14px;
            padding-bottom: 12px;
        }
        .privacy-section h5 {
            font-size: 13px;
            gap: 8px;
        }
        .privacy-section h5 .icon {
            width: 22px;
            height: 22px;
            font-size: 10px;
        }
        .privacy-section p,
        .privacy-section ul li {
            font-size: 12px;
            line-height: 1.5;
        }
        .privacy-section ul {
            padding-left: 14px;
        }
        .privacy-footer {
            padding: 12px 10px;
            gap: 8px;
        }
        .privacy-footer .btn-back,
        .privacy-footer .btn-print {
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 30px;
        }
        .privacy-footer .btn-back i,
        .privacy-footer .btn-print i {
            font-size: 12px;
        }
        .privacy-badge {
            font-size: 7px;
            padding: 2px 6px;
        }
    }
</style>

<div class="privacy-wrapper">
    <div class="card privacy-card">
        
        <!-- Header -->
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1><i class="fas fa-shield-alt me-2"></i> Privacy Policy</h1>
                    <p>Last updated: {{ date('F d, Y') }}</p>
                </div>
                <span class="privacy-badge"><i class="fas fa-check-circle me-1"></i> GDPR Compliant</span>
            </div>
        </div>
        
        <!-- Body -->
        <div class="card-body">
            
            <div class="privacy-section">
                <h5><span class="icon">1</span> Information We Collect</h5>
                <p>We collect information you provide directly to us, including:</p>
                <ul>
                    <li><strong>Personal Information:</strong> Name, email address, phone number, shipping and billing addresses</li>
                    <li><strong>Account Information:</strong> Username, password, account preferences</li>
                    <li><strong>Payment Information:</strong> Payment details (processed securely through our payment partners)</li>
                    <li><strong>Order History:</strong> Products you have purchased, browsing history, and preferences</li>
                    <li><strong>Device Information:</strong> IP address, browser type, device type, and operating system</li>
                </ul>
            </div>
            
            <div class="privacy-section">
                <h5><span class="icon">2</span> How We Use Your Information</h5>
                <p>We use your information for the following purposes:</p>
                <ul>
                    <li><strong>Order Processing:</strong> To process, fulfill, and deliver your orders</li>
                    <li><strong>Communication:</strong> To send order updates, shipping confirmations, and customer support</li>
                    <li><strong>Marketing:</strong> To send promotional offers, newsletters, and personalized recommendations (with your consent)</li>
                    <li><strong>Improvement:</strong> To analyze and improve our products, services, and website experience</li>
                    <li><strong>Security:</strong> To detect and prevent fraud, abuse, and security incidents</li>
                </ul>
            </div>
            
            <div class="privacy-section">
                <h5><span class="icon">3</span> Information Sharing</h5>
                <p>We respect your privacy and do not sell or rent your personal information. We may share your information with:</p>
                <ul>
                    <li><strong>Payment Processors:</strong> To securely process your payments</li>
                    <li><strong>Shipping Partners:</strong> To deliver your orders</li>
                    <li><strong>Service Providers:</strong> To help us operate our business</li>
                    <li><strong>Legal Authorities:</strong> When required by law</li>
                </ul>
            </div>
            
            <div class="privacy-section">
                <h5><span class="icon">4</span> Data Security</h5>
                <p>We implement industry-standard security measures to protect your personal information, including:</p>
                <ul>
                    <li><strong>Encryption:</strong> SSL/TLS encryption for data transmission</li>
                    <li><strong>Access Control:</strong> Restricted access to personal data</li>
                    <li><strong>Monitoring:</strong> Regular security audits and monitoring</li>
                    <li><strong>Data Minimization:</strong> We only collect necessary information</li>
                </ul>
                <p>While we strive to protect your data, no method of transmission over the internet is 100% secure.</p>
            </div>
            
            <div class="privacy-section">
                <h5><span class="icon">5</span> Your Rights</h5>
                <p>You have the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Access:</strong> Request a copy of your personal data</li>
                    <li><strong>Correction:</strong> Request corrections to inaccurate information</li>
                    <li><strong>Deletion:</strong> Request deletion of your personal data</li>
                    <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications</li>
                    <li><strong>Portability:</strong> Request a copy of your data in a portable format</li>
                </ul>
                <p>To exercise these rights, please <a href="{{ route('contact') }}" class="text-danger">contact us</a>.</p>
            </div>
            
            <div class="privacy-section">
                <h5><span class="icon">6</span> Contact Us</h5>
                <p>If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us:</p>
                <ul>
                    <li><i class="fas fa-envelope text-danger me-2"></i> <a href="mailto:support@stylehub.com" class="text-decoration-none">support@stylehub.com</a></li>
                    <li><i class="fas fa-phone-alt text-danger me-2"></i> +91-98765-43210</li>
                    <li><i class="fas fa-map-marker-alt text-danger me-2"></i> 123 Fashion Street, Mumbai, India</li>
                </ul>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="privacy-footer">
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