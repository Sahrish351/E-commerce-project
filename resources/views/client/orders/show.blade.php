@extends('client.layouts.app')

@section('title', 'Order Details')

@section('content')
<style>
    .order-detail-card {
        background: #fff;
        border-radius: 14px;
        padding: 24px 28px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        margin-bottom: 16px;
    }
    .order-detail-card .title {
        font-weight: 700;
        font-size: 18px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f5f5f5;
    }
    .order-detail-card .title i {
        color: #db4444;
        margin-right: 8px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .info-grid .info-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #f0f0f0;
    }
    .info-grid .info-item .label {
        font-size: 11px;
        text-transform: uppercase;
        color: #8c8c9c;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .info-grid .info-item .value {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 2px;
    }
    .info-grid .info-item .value .badge-status {
        font-size: 12px;
        font-weight: 500;
        padding: 2px 12px;
        border-radius: 30px;
        display: inline-block;
    }
    .info-grid .info-item .value .badge-status.pending { background: #fff3cd; color: #856404; }
    .info-grid .info-item .value .badge-status.processing { background: #cce5ff; color: #004085; }
    .info-grid .info-item .value .badge-status.shipped { background: #d4edda; color: #155724; }
    .info-grid .info-item .value .badge-status.delivered { background: #28a745; color: #fff; }
    .info-grid .info-item .value .badge-status.cancelled { background: #f8d7da; color: #721c24; }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table thead th {
        background: #f8f9fa;
        padding: 10px 14px;
        font-size: 12px;
        text-transform: uppercase;
        color: #8c8c9c;
        font-weight: 600;
        border-bottom: 2px solid #f0f0f0;
        text-align: left;
    }
    .items-table tbody td {
        padding: 10px 14px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
        color: #1a1a2e;
        vertical-align: middle;
    }
    .items-table tbody tr:last-child td {
        border-bottom: none;
    }
    .items-table .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .items-table .product-cell .icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #999;
    }
    .items-table .product-cell .name {
        font-weight: 500;
    }
    .items-table .product-cell .sku {
        font-size: 12px;
        color: #8c8c9c;
    }
    .items-table .text-right {
        text-align: right;
    }

    .totals-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 16px 20px;
        border: 1px solid #f0f0f0;
        max-width: 350px;
        margin-left: auto;
    }
    .totals-box .row-item {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 14px;
    }
    .totals-box .row-item .label {
        color: #8c8c9c;
    }
    .totals-box .row-item .value {
        font-weight: 500;
        color: #1a1a2e;
    }
    .totals-box .total {
        border-top: 2px solid #e0e0e0;
        padding-top: 10px;
        margin-top: 6px;
    }
    .totals-box .total .label {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a2e;
    }
    .totals-box .total .value {
        font-weight: 700;
        font-size: 18px;
        color: #db4444;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .action-buttons .btn {
        padding: 8px 24px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
    }
    .action-buttons .btn-back {
        background: #f0f0f0;
        color: #1a1a2e;
    }
    .action-buttons .btn-back:hover {
        background: #e0e0e0;
    }
    .action-buttons .btn-cancel {
        background: #f8d7da;
        color: #721c24;
    }
    .action-buttons .btn-cancel:hover {
        background: #dc3545;
        color: #fff;
    }
    .action-buttons .btn-reorder {
        background: #d4edda;
        color: #155724;
    }
    .action-buttons .btn-reorder:hover {
        background: #28a745;
        color: #fff;
    }

    .address-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 14px 18px;
        border: 1px solid #f0f0f0;
        font-size: 14px;
        line-height: 1.7;
        color: #555;
        border-left: 3px solid #db4444;
    }
    .address-box strong {
        color: #1a1a2e;
        display: block;
        font-size: 13px;
        margin-bottom: 2px;
    }

    @media (max-width: 768px) {
        .order-detail-card { padding: 16px 18px; }
        .info-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .info-grid .info-item { padding: 10px 14px; }
        .totals-box { max-width: 100%; }
        .action-buttons { flex-wrap: wrap; }
        .action-buttons .btn { flex: 1; justify-content: center; }
        .items-table thead th { font-size: 10px; padding: 6px 8px; }
        .items-table tbody td { font-size: 12px; padding: 6px 8px; }
        .items-table .product-cell .icon { width: 28px; height: 28px; font-size: 10px; }
    }
    @media (max-width: 480px) {
        .order-detail-card { padding: 12px 14px; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-receipt text-danger me-2"></i> Order #{{ $order->order_number }}</h4>
    <a href="{{ route('client.orders') }}" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>

<!-- ===== INFO GRID ===== -->
<div class="order-detail-card">
    <div class="title"><i class="fas fa-info-circle"></i> Order Information</div>
    <div class="info-grid">
        <div class="info-item">
            <div class="label">Order Date</div>
            <div class="value">{{ $order->created_at->format('F d, Y') }}</div>
        </div>
        <div class="info-item">
            <div class="label">Status</div>
            <div class="value">
                <span class="badge-status {{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <div class="info-item">
            <div class="label">Payment Method</div>
            <div class="value">
                @if($order->payment_method == 'cod') Cash on Delivery
                @elseif($order->payment_method == 'bank') Bank Transfer
                @elseif($order->payment_method == 'card') Card (****{{ $order->card_last4 ?? '' }})
                @else {{ ucfirst($order->payment_method) }}
                @endif
            </div>
        </div>
        <div class="info-item">
            <div class="label">Payment Status</div>
            <div class="value">
                <span class="badge bg-{{ $order->payment_status == 'completed' ? 'success' : 'warning' }}">
                    {{ ucfirst($order->payment_status ?? 'pending') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ===== ORDER ITEMS ===== -->
<div class="order-detail-card">
    <div class="title"><i class="fas fa-box"></i> Order Items</div>
    <div class="table-responsive">
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="product-cell">
                            <div class="icon"><i class="fas fa-box"></i></div>
                            <div>
                                <div class="name">{{ $item->product_name }}</div>
                                <div class="sku">SKU: {{ $item->sku ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ===== TOTALS + ADDRESS + ACTIONS ===== -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="order-detail-card">
            <div class="title"><i class="fas fa-map-marker-alt"></i> Shipping Address</div>
            @php
                $shipping = is_string($order->shipping_address) ? json_decode($order->shipping_address, true) : $order->shipping_address;
            @endphp
            <div class="address-box">
                <strong>{{ $shipping['name'] ?? $order->shipping_name ?? 'N/A' }}</strong>
                {{ $shipping['address'] ?? $order->shipping_address ?? '' }}<br>
                {{ $shipping['city'] ?? $order->shipping_city ?? '' }},
                {{ $shipping['state'] ?? $order->shipping_state ?? '' }}
                {{ $shipping['postal_code'] ?? $order->shipping_postal_code ?? '' }}<br>
                📞 {{ $shipping['phone'] ?? $order->shipping_phone ?? '' }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="order-detail-card">
            <div class="title"><i class="fas fa-calculator"></i> Order Summary</div>
            <div class="totals-box">
                <div class="row-item">
                    <span class="label">Subtotal</span>
                    <span class="value">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if(($order->discount_amount ?? 0) > 0)
                <div class="row-item">
                    <span class="label" style="color:#28a745;">Discount</span>
                    <span class="value" style="color:#28a745;">-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="row-item">
                    <span class="label">Shipping</span>
                    <span class="value">
                        @if(($order->shipping_cost ?? 0) > 0)
                            ${{ number_format($order->shipping_cost, 2) }}
                        @else
                            <span style="color:#28a745;">Free</span>
                        @endif
                    </span>
                </div>
                <div class="row-item">
                    <span class="label">Tax</span>
                    <span class="value">${{ number_format($order->tax_amount ?? 0, 2) }}</span>
                </div>
                <div class="row-item total">
                    <span class="label">Total</span>
                    <span class="value">${{ number_format($order->grand_total ?? $order->total_amount ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ACTIONS ===== -->
<div class="order-detail-card">
    <div class="title"><i class="fas fa-cog"></i> Actions</div>
    <div class="action-buttons">
        <a href="{{ route('client.orders') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        @if(in_array($order->status, ['pending', 'processing']))
        <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-cancel" onclick="return confirm('Are you sure you want to cancel this order?')">
                <i class="fas fa-times"></i> Cancel Order
            </button>
        </form>
        @endif
        @if($order->status == 'delivered')
        <form action="{{ route('client.orders.reorder', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-reorder">
                <i class="fas fa-redo"></i> Reorder
            </button>
        </form>
        @endif
    </div>
</div>
@endsection