@extends('layouts.app')

@section('title', 'Order Confirmation - StyleHub')

@section('content')
<style>
    .confirm-wrap {
        max-width: 650px;
        margin: 30px auto;
        padding: 0 16px;
    }
    .confirm-card {
        background: #fff;
        border-radius: 20px;
        padding: 32px 34px 28px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
    }
    .confirm-card:hover {
        box-shadow: 0 12px 50px rgba(0,0,0,0.08);
    }

    /* ===== HEADER ===== */
    .header {
        text-align: center;
        padding-bottom: 18px;
        border-bottom: 2px dashed #f0f0f0;
    }
    .header .icon-wrap {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }
    .header .icon-wrap i {
        font-size: 32px;
        color: #28a745;
    }
    .header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .header p {
        font-size: 13px;
        color: #8c8c9c;
        margin: 2px 0 6px;
    }
    .header .order-badge {
        display: inline-block;
        background: #f0f0f0;
        padding: 4px 18px;
        border-radius: 30px;
        font-size: 13px;
        color: #555;
    }
    .header .order-badge strong {
        color: #1a1a2e;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* ===== INFO ROW ===== */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-item {
        text-align: center;
    }
    .info-item .lbl {
        font-size: 11px;
        color: #8c8c9c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .info-item .val {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 2px;
    }
    .info-item .val .tag {
        font-size: 12px;
        font-weight: 500;
        padding: 2px 12px;
        border-radius: 30px;
        display: inline-block;
    }
    .info-item .val .tag.pending { background: #fff3cd; color: #856404; }
    .info-item .val .tag.processing { background: #cce5ff; color: #004085; }
    .info-item .val .tag.shipped { background: #d4edda; color: #155724; }
    .info-item .val .tag.delivered { background: #28a745; color: #fff; }
    .info-item .val .tag.cancelled { background: #f8d7da; color: #721c24; }

    /* ===== ITEMS ===== */
    .section-label {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 14px 0 8px;
    }
    .section-label i {
        color: #db4444;
        margin-right: 6px;
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 14px;
    }
    .item:last-child {
        border-bottom: none;
    }
    .item .left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .item .left .dot {
        width: 8px;
        height: 8px;
        background: #db4444;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .item .left .name {
        font-weight: 500;
        color: #1a1a2e;
    }
    .item .left .qty {
        color: #8c8c9c;
        font-size: 13px;
    }
    .item .price {
        font-weight: 600;
        color: #1a1a2e;
    }

    /* ===== TOTALS ===== */
    .totals {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 14px 18px;
        margin: 12px 0;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 4px 0;
    }
    .total-row .lbl {
        color: #8c8c9c;
    }
    .total-row .val {
        color: #1a1a2e;
        font-weight: 500;
    }
    .total-row.grand {
        border-top: 2px solid #e0e0e0;
        padding-top: 10px;
        margin-top: 4px;
    }
    .total-row.grand .lbl {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 15px;
    }
    .total-row.grand .val {
        font-size: 18px;
        font-weight: 700;
        color: #db4444;
    }

    /* ===== ADDRESS ===== */
    .address-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 14px;
        line-height: 1.6;
        color: #555;
        margin: 8px 0 12px;
        border-left: 3px solid #db4444;
    }
    .address-box strong {
        color: #1a1a2e;
        display: block;
        font-size: 13px;
        margin-bottom: 2px;
    }
    .address-box i {
        color: #db4444;
        margin-right: 4px;
    }

    /* ===== BUTTONS ===== */
    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 18px;
    }
    .btn-group a {
        flex: 1;
        text-align: center;
        padding: 10px 18px;
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
    }
    .btn-group .btn-primary:hover {
        background: #b33232;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.2);
    }
    .btn-group .btn-outline {
        background: transparent;
        color: #1a1a2e;
        border: 1px solid #e0e0e0;
    }
    .btn-group .btn-outline:hover {
        border-color: #db4444;
        color: #db4444;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 600px) {
        .confirm-card { padding: 20px 16px; }
        .info-grid { grid-template-columns: 1fr; gap: 6px; }
        .info-item { text-align: left; display: flex; justify-content: space-between; padding: 3px 0; border-bottom: 1px solid #f5f5f5; }
        .info-item:last-child { border-bottom: none; }
        .info-item .lbl { font-size: 12px; }
        .info-item .val { font-size: 13px; }
        .item { flex-wrap: wrap; gap: 4px; }
        .btn-group { flex-direction: column; }
        .btn-group a { padding: 12px; }
    }
</style>

<div class="confirm-wrap">
    <div class="confirm-card">

        <!-- ===== HEADER ===== -->
        <div class="header">
            <div class="icon-wrap">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Order Confirmed! 🎉</h2>
            <p>We've received your order and will process it soon</p>
            <span class="order-badge">
                Order # <strong>{{ $order->order_number ?? $orderNumber ?? 'N/A' }}</strong>
            </span>
        </div>

        <!-- ===== INFO ===== -->
        <div class="info-grid">
            <div class="info-item">
                <div class="lbl">📅 Date</div>
                <div class="val">{{ $order->created_at->format('M d, Y') }}</div>
            </div>
            <div class="info-item">
                <div class="lbl">💳 Payment</div>
                <div class="val">
                    @if(($order->payment_method ?? '') == 'cod') Cash on Delivery
                    @elseif(($order->payment_method ?? '') == 'bank') Bank Transfer
                    @elseif(($order->payment_method ?? '') == 'card') Credit Card
                    @else {{ $order->payment_method ?? 'N/A' }}
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="lbl">📦 Status</div>
                <div class="val">
                    <span class="tag {{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- ===== ITEMS ===== -->
        <div class="section-label"><i class="fas fa-box"></i> Order Items</div>
        @foreach($order->items as $item)
        <div class="item">
            <div class="left">
                <span class="dot"></span>
                <span class="name">{{ $item->product_name ?? 'Product' }}</span>
                <span class="qty">x{{ $item->quantity }}</span>
            </div>
            <span class="price">${{ number_format($item->unit_price ?? $item->price ?? 0, 2) }}</span>
        </div>
        @endforeach

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