@extends('layouts.app')

@section('title', 'Contact Us - StyleHub')

@section('content')
<style>
    /* ===== HERO ===== */
    .contact-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
        padding: 60px 0 50px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .contact-hero h1 {
        font-weight: 800;
        font-size: 38px;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .contact-hero h1 span {
        color: #db4444;
    }
    .contact-hero p {
        color: rgba(255,255,255,0.7);
        font-size: 16px;
        max-width: 500px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ===== CONTACT SECTION ===== */
    .contact-section {
        padding: 60px 0;
        background: #fff;
    }
    .contact-info-card {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 24px 28px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        height: 100%;
        text-align: center;
    }
    .contact-info-card:hover {
        border-color: #db4444;
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    }
    .contact-info-card .icon-wrap {
        width: 60px;
        height: 60px;
        background: #fef0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    .contact-info-card .icon-wrap i {
        font-size: 24px;
        color: #db4444;
    }
    .contact-info-card h5 {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .contact-info-card p {
        color: #8c8c9c;
        font-size: 14px;
        margin: 0;
        line-height: 1.6;
    }
    .contact-info-card a {
        color: #8c8c9c;
        text-decoration: none;
        transition: color 0.3s;
    }
    .contact-info-card a:hover {
        color: #db4444;
    }

    /* ===== FORM ===== */
    .contact-form-card {
        background: #fff;
        border-radius: 14px;
        padding: 30px 35px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.02);
    }
    .contact-form-card h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .contact-form-card h4 span {
        color: #db4444;
    }
    .contact-form-card .sub-text {
        color: #8c8c9c;
        font-size: 14px;
        margin-bottom: 24px;
    }
    .contact-form-card .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .contact-form-card .form-label .required {
        color: #db4444;
        margin-left: 2px;
    }
    .contact-form-card .form-control {
        border-radius: 10px;
        padding: 10px 16px;
        border: 1.5px solid #e8e8e8;
        font-size: 14px;
        transition: all 0.3s;
        background: #fafafa;
    }
    .contact-form-card .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.06);
        background: #fff;
    }
    .contact-form-card .form-control::placeholder {
        color: #bbb;
    }
    .contact-form-card textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 40px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit:hover {
        background: #b33232;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.2);
    }

    /* ===== MAP ===== */
    .map-section {
        padding: 0 0 60px 0;
        background: #fff;
    }
    .map-container {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        height: 320px;
        background: #f5f5f5;
    }
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* ===== TOAST ===== */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast-custom {
        background: #1a1a2e;
        color: #fff;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast-custom.success { border-left: 4px solid #28a745; }
    .toast-custom.error { border-left: 4px solid #dc3545; }
    .toast-custom .close-btn {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
    }
    .toast-custom .close-btn:hover { opacity: 1; }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .contact-hero { padding: 40px 0 30px; }
        .contact-hero h1 { font-size: 28px; }
        .contact-section { padding: 40px 0; }
        .contact-form-card { padding: 20px; }
        .contact-info-card { padding: 18px 20px; }
        .map-container { height: 220px; }
        .btn-submit { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
        .contact-hero h1 { font-size: 24px; }
        .contact-form-card h4 { font-size: 18px; }
        .contact-info-card .icon-wrap { width: 48px; height: 48px; }
        .contact-info-card .icon-wrap i { font-size: 20px; }
        .map-container { height: 180px; }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- ===== HERO ===== -->
<section class="contact-hero">
    <div class="container">
        <h1>Get in <span>Touch</span></h1>
        <p>We'd love to hear from you! Reach out to us anytime.</p>
    </div>
</section>

<!-- ===== CONTACT SECTION ===== -->
<section class="contact-section">
    <div class="container">
        <div class="row g-4">

           

        </div>
    </div>
</section>

<!-- ===== FORM & MAP ===== -->
<section class="contact-section" style="padding-top:0;">
    <div class="container">
        <div class="row g-4">
            <!-- ===== FORM ===== -->
            <div class="col-lg-6">
                <div class="contact-form-card">
                    <h4>Send us a <span>Message</span></h4>
                    <p class="sub-text">We'll get back to you within 24 hours.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="john@example.com" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject <span class="required">*</span></label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                                   placeholder="How can we help?" value="{{ old('subject') }}" required>
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message <span class="required">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                      placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- ===== MAP ===== -->
            <div class="col-lg-6">
                <div class="contact-form-card" style="height:100%; display:flex; flex-direction:column;">
                    <h4>Find Us <span>Here</span></h4>
                    <p class="sub-text">Visit our store location.</p>
                    <div class="map-container" style="flex:1;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d217441.85008229844!2d74.12860818550711!3d31.51898839253444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190483e58107d9%3A0xc23abe6c7cee8452!2sLahore%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1700000000000" 
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    });

    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-custom ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <span class="close-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session("error") }}', 'error');
    @endif
</script>
@endsection