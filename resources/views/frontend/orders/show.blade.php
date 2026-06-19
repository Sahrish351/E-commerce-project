@extends('layouts.app')

@section('title', 'Order Detail - StyleHub')

@section('content')
<div class="container py-4">
   
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile.dashboard') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">My Orders</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Order #{{ $order->order_number }}</li>
                </ol>
            </nav>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div>
                    <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
                    <p class="text-muted small mb-0">Placed on {{ $order->created_at->format('l, d M Y') }}</p>
                </div>
                <div>
                    @php
                        $statusClass = 'secondary';
                        if($order->order_status == 'delivered') $statusClass = 'success';
                        elseif($order->order_status == 'pending') $statusClass = 'warning';
                        elseif($order->order_status == 'cancelled') $statusClass = 'danger';
                        elseif($order->order_status == 'processing') $statusClass = 'info';
                        elseif($order->order_status == 'shipped') $statusClass = 'primary';
                        elseif($order->order_status == 'return_requested') $statusClass = 'warning';
                    @endphp
                    <span class="badge bg-{{ $statusClass }} px-3 py-2 rounded-pill">
                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
       
        <div class="col-lg-8">
            <div class="order-items p-3 rounded-3" style="background: #fff; border: 1px solid #e8e8e8;">
                <h6 class="fw-bold mb-3">🛍️ Order Items</h6>
                
                @foreach($order->items as $item)
                <div class="order-item d-flex align-items-center gap-3 py-2 border-bottom">
                    <div class="order-item-image" style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                        @php
                            $image = $item->product->images->first();
                            $imageName = $image ? $image->image_url : 'default.jpg';
                        @endphp
                        <img src="{{ asset('images/products/' . $imageName) }}" alt="{{ $item->product->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="order-item-info flex-grow-1">
                        <h6 class="mb-0 small fw-semibold">{{ $item->product->name }}</h6>
                        <p class="text-muted small mb-0">Qty: {{ $item->quantity }}</p>
                    </div>
                    <div class="order-item-price text-end">
                        <span class="fw-bold small">${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                </div>
                @endforeach

              
                <div class="order-totals mt-3 pt-2">
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Subtotal</span>
                        <span>${{ number_format($order->subtotal ?? $order->total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Shipping</span>
                        <span>${{ number_format($order->shipping ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mt-1 pt-1 border-top">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            
            <div class="mt-3 d-flex gap-2 flex-wrap">
                @if(in_array($order->order_status, ['pending', 'processing']))
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4" 
                                onclick="return confirm('Are you sure you want to cancel this order?')">
                            <i class="fas fa-times me-2"></i> Cancel Order
                        </button>
                    </form>
                @endif

                @if($order->order_status == 'delivered')
                    <form action="{{ route('orders.return.request', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning rounded-pill px-4" 
                                onclick="return confirm('Are you sure you want to request a return?')">
                            <i class="fas fa-undo me-2"></i> Request Return
                        </button>
                    </form>
                @endif

                <form action="{{ route('orders.reorder', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark rounded-pill px-4">
                        <i class="fas fa-redo me-2"></i> Reorder
                    </button>
                </form>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="order-details p-3 rounded-3" style="background: #fff; border: 1px solid #e8e8e8;">
                <h6 class="fw-bold mb-3">📋 Order Details</h6>
                
                <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Order ID</span>
                    <span class="small fw-semibold">#{{ $order->order_number }}</span>
                </div>
                <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Date</span>
                    <span class="small">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Payment Method</span>
                    <span class="small">{{ $order->payment_method ?? 'N/A' }}</span>
                </div>
                <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Total Items</span>
                    <span class="small">{{ $order->items->count() }}</span>
                </div>
                <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Total Amount</span>
                    <span class="small fw-bold">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="detail-row d-flex justify-content-between py-2">
                    <span class="text-muted small">Status</span>
                    <span class="badge bg-{{ $statusClass }} rounded-pill">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>

             
                @if($order->address)
                <div class="mt-3 pt-3 border-top">
                    <h6 class="fw-bold small mb-2">📍 Shipping Address</h6>
                    <p class="small text-muted mb-0">
                        {{ $order->address->address_line1 }}<br>
                        {{ $order->address->city }}, {{ $order->address->state }}<br>
                        {{ $order->address->postal_code }}<br>
                        {{ $order->address->country }}
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .order-item:last-child {
        border-bottom: none !important;
    }
    .order-item-image img {
        object-fit: cover;
    }
    .detail-row {
        font-size: 13px;
    }
</style>
@endpush