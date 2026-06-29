@extends('layouts.app')

@section('title', 'Order Confirmation - StyleHub')

@section('content')
<style>
    .confirm-wrap {
        max-width: 720px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .confirm-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px 45px 35px;
        box-shadow: 0 10px 60px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
    }
    .confirm-card:hover {
        box-shadow: 0 15px 70px rgba(0,0,0,0.07);
    }

    /* ===== HEADER ===== */
    .header {
        text-align: center;
        padding-bottom: 24px;
        border-bottom: 2px dashed #f0f0f0;
        position: relative;
    }
    .header .icon-wrap {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        box-shadow: 0 8px 30px rgba(40, 167, 69, 0.15);
    }
    .header .icon-wrap i {
        font-size: 40px;
        color: #28a745;
    }
    .header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #1a1a2e;
        margin: 0;
    }
    .header h2 span {
        color: #db4444;
    }
    .header p {
        font-size: 14px;
        color: #8c8c9c;
        margin: 4px 0 10px;
    }
    .header .order-badge {
        display: inline-block;
        background: #f5f5f5;
        padding: 6px 24px;
        border-radius: 30px;
        font-size: 14px;
        color: #555;
        border: 1px solid #e8e8e8;
    }
    .header .order-badge strong {
        color: #1a1a2e;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* ===== INFO GRID ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        padding: 18px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-item {
        text-align: center;
        padding: 6px 0;
    }
    .info-item .lbl {
        font-size: 11px;
        color: #8c8c9c;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
    }
    .info-item .val {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 3px;
    }
    .info-item .val .tag {
        font-size: 12px;
        font-weight: 600;
        padding: 3px 16px;
        border-radius: 30px;
        display: inline-block;
    }
    .info-item .val .tag.pending { background: #fff3cd; color: #856404; }
    .info-item .val .tag.processing { background: #cce5ff; color: #004085; }
    .info-item .val .tag.shipped { background: #d4edda; color: #155724; }
    .info-item .val .tag.delivered { background: #28a745; color: #fff; }
    .info-item .val .tag.cancelled { background: #f8d7da; color: #721c24; }
    .info-item .val .payment-method {
        font-weight: 600;
        color: #1a1a2e;
    }
    .info-item .val .payment-method .card-icon {
        margin-right: 4px;
    }

    /* ===== ITEMS SECTION ===== */
    .items-section {
        margin: 16px 0 12px;
    }
    .section-label {
        font-size: 15px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-label i {
        color: #db4444;
        font-size: 18px;
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 14px;
        transition: all 0.2s;
    }
    .item:hover {
        background: #fafafa;
        margin: 0 -6px;
        padding: 10px 6px;
        border-radius: 8px;
    }
    .item:last-child {
        border-bottom: none;
    }
    .item .left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .item .left .product-icon {
        width: 32px;
        height: 32px;
        background: #f5f5f5;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #999;
    }
    .item .left .name {
        font-weight: 500;
        color: #1a1a2e;
    }
    .item .left .qty {
        color: #8c8c9c;
        font-size: 13px;
        background: #f5f5f5;
        padding: 0 8px;
        border-radius: 12px;
    }
    .item .price {
        font-weight: 600;
        color: #1a1a2e;
    }

    /* ===== TOTALS ===== */
    .totals {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 16px 22px;
        margin: 14px 0 16px;
        border: 1px solid #f0f0f0;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 5px 0;
    }
    .total-row .lbl {
        color: #8c8c9c;
    }
    .total-row .val {
        color: #1a1a2e;
        font-weight: 500;
    }
    .total-row.grand {
        border-top: 2px solid #e8e8e8;
        padding-top: 12px;
        margin-top: 6px;
    }
    .total-row.grand .lbl {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 16px;
    }
    .total-row.grand .val {
        font-size: 20px;
        font-weight: 800;
        color: #db4444;
    }

    /* ===== ADDRESS ===== */
    .address-box {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 16px 20px;
        font-size: 14px;
        line-height: 1.7;
        color: #555;
        margin: 10px 0 16px;
        border-left: 4px solid #db4444;
        transition: all 0.3s;
    }
    .address-box:hover {
        background: #f5f5f5;
    }
    .address-box strong {
        color: #1a1a2e;
        display: block;
        font-size: 14px;
        margin-bottom: 3px;
    }
    .address-box i {
        color: #db4444;
        margin-right: 6px;
    }

    /* ===== BUTTONS ===== */
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 22px;
    }
    .btn-group a {
        flex: 1;
        text-align: center;
        padding: 12px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-group .btn-primary {
        background: #db4444;
        color: #fff;
        border: none;
        box-shadow: 0 4px 15px rgba(219, 68, 68, 0.2);
    }
    .btn-group .btn-primary:hover {
        background: #b33232;
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(219, 68, 68, 0.25);
    }
    .btn-group .btn-outline {
        background: transparent;
        color: #1a1a2e;
        border: 1.5px solid #e0e0e0;
    }
    .btn-group .btn-outline:hover {
        border-color: #db4444;
        color: #db4444;
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 600px) {
        .confirm-card { padding: 24px 18px; border-radius: 18px; }
        .confirm-wrap { margin: 20px auto; padding: 0 12px; }
        .info-grid { grid-template-columns: 1fr; gap: 4px; }
        .info-item { text-align: left; display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f5f5f5; }
        .info-item:last-child { border-bottom: none; }
        .info-item .lbl { font-size: 12px; }
        .info-item .val { font-size: 14px; }
        .header h2 { font-size: 20px; }
        .header .icon-wrap { width: 64px; height: 64px; }
        .header .icon-wrap i { font-size: 32px; }
        .item { flex-wrap: wrap; gap: 4px; }
        .btn-group { flex-direction: column; gap: 8px; }
        .btn-group a { padding: 14px; }
        .totals { padding: 14px 16px; }
        .address-box { padding: 14px 16px; }
    }
</style>

<div class="confirm-wrap">
    <div class="confirm-card">

        <!-- ===== HEADER ===== -->
        <div class="header">
            <div class="icon-wrap">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Order Confirmed! <span>🎉</span></h2>
            <p>We've received your order and will process it soon</p>
            <span class="order-badge">
                🧾 Order # <strong>{{ $order->order_number ?? $orderNumber ?? 'N/A' }}</strong>
            </span>
        </div>

        <!-- ===== INFO GRID ===== -->
        <div class="info-grid">
            <div class="info-item">
                <div class="lbl">📅 Order Date</div>
                <div class="val">{{ $order->created_at->format('M d, Y') }}</div>
            </div>
            <div class="info-item">
                <div class="lbl">💳 Payment</div>
                <div class="val">
                    @if(($order->payment_method ?? '') == 'cod')
                        <span class="payment-method"><i class="fas fa-truck card-icon"></i> Cash on Delivery</span>
                    @elseif(($order->payment_method ?? '') == 'bank')
                        <span class="payment-method"><i class="fas fa-university card-icon"></i> Bank Transfer</span>
                    @elseif(($order->payment_method ?? '') == 'card')
                        <span class="payment-method"><i class="fas fa-credit-card card-icon"></i> Card (****{{ $order->card_last4 ?? '0000' }})</span>
                    @elseif(($order->payment_method ?? '') == 'easypaisa')
                        <span class="payment-method"><i class="fas fa-mobile-alt card-icon"></i> EasyPaisa</span>
                    @else
                        <span class="payment-method">N/A</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="lbl">📦 Order Status</div>
                <div class="val">
                    <span class="tag {{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- ===== ITEMS ===== -->
        <div class="items-section">
            <div class="section-label">
                <i class="fas fa-box"></i> Order Items
                <span style="font-size:12px; color:#8c8c9c; font-weight:400; margin-left:4px;">({{ $order->items->count() }} items)</span>
            </div>

            @foreach($order->items as $item)
            <div class="item">
                <div class="left">
                    <div class="product-icon"><i class="fas fa-box"></i></div>
                    <span class="name">{{ $item->product_name ?? 'Product' }}</span>
                    <span class="qty">x{{ $item->quantity }}</span>
                </div>
                <span class="price">${{ number_format($item->unit_price ?? $item->price ?? 0, 2) }}</span>
            </div>
            @endforeach
        </div>

        <!-- ===== TOTALS ===== -->
        <div class="totals">
            <div class="total-row">
                <span class="lbl">Subtotal</span>
                <span class="val">${{ number_format($order->subtotal ?? 0, 2) }}</span>
            </div>
            @if(($order->discount_amount ?? 0) > 0)
            <div class="total-row">
                <span class="lbl" style="color:#28a745;">Discount</span>
                <span class="val" style="color:#28a745;">-${{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span class="lbl">Shipping</span>
                <span class="val">
                    @if(($order->shipping_cost ?? 0) > 0)
                        ${{ number_format($order->shipping_cost, 2) }}
                    @else
                        <span style="color:#28a745;">Free</span>
                    @endif
                </span>
            </div>
            <div class="total-row">
                <span class="lbl">Tax</span>
                <span class="val">${{ number_format($order->tax_amount ?? 0, 2) }}</span>
            </div>
            <div class="total-row grand">
                <span class="lbl">Total</span>
                <span class="val">${{ number_format($order->total_amount ?? $order->grand_total ?? 0, 2) }}</span>
            </div>
        </div>

        <!-- ===== ADDRESS ===== -->
        @php
            $shipping = is_string($order->shipping_address) ? json_decode($order->shipping_address, true) : $order->shipping_address;
        @endphp
        <div class="address-box">
            <strong><i class="fas fa-map-marker-alt"></i> Shipping Address</strong>
            @if($shipping && is_array($shipping))
                {{ $shipping['name'] ?? '' }}<br>
                {{ $shipping['address'] ?? '' }}, {{ $shipping['city'] ?? '' }}<br>
                📞 {{ $shipping['phone'] ?? '' }}
            @else
                {{ $order->shipping_address ?? 'N/A' }}
            @endif
        </div>

        <!-- ===== BUTTONS ===== -->
        <div class="btn-group">
            <a href="{{ route('shop.index') }}" class="btn-primary">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="btn-outline">
                <i class="fas fa-list"></i> My Orders
            </a>
        </div>

    </div>
</div>
@endsection