@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - E-Commerce Store')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Order {{ $order->order_number }}</h1>
        <p class="text-muted">Placed on {{ $order->created_at->format('F d, Y \a\t H:i A') }}</p>

        <!-- Order Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Status:</strong></p>
                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Payment Status:</strong></p>
                        <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }} fs-6">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                @if($order->tracking_number)
                    <div class="mt-3">
                        <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div>
                                        <p class="mb-1">{{ $item->product_name }}</p>
                                        <small class="text-muted">SKU: {{ $item->sku }}</small>
                                        @if($item->variant)
                                            <br><small class="text-muted">{{ $item->variant->name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping & Billing Address -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Billing Address</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->billing_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Notes</h5>
                </div>
                <div class="card-body">
                    <p>{{ $order->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Order Summary Sidebar -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong>${{ number_format($order->subtotal, 2) }}</strong>
                </div>
                @if($order->tax_amount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <strong>${{ number_format($order->tax_amount, 2) }}</strong>
                    </div>
                @endif
                @if($order->shipping_cost > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <strong>${{ number_format($order->shipping_cost, 2) }}</strong>
                    </div>
                @endif
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount:</span>
                        <strong>-${{ number_format($order->discount_amount, 2) }}</strong>
                    </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="h5">Total:</span>
                    <h5 class="text-primary">${{ number_format($order->total_amount, 2) }}</h5>
                </div>

                @if($order->payment)
                    <div class="alert alert-info">
                        <strong>Payment Method:</strong> {{ ucfirst($order->payment->payment_method) }}
                    </div>
                @endif

                @if($order->isPending() && !$order->isPaid())
                    <button class="btn btn-primary w-100 mb-2">Complete Payment</button>
                @endif

                @if($order->isPending())
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Cancel this order?')">
                            Cancel Order
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Applied Coupons -->
        @if($order->coupons->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Applied Coupons</h5>
                </div>
                <div class="card-body">
                    @foreach($order->coupons as $coupon)
                        <div class="mb-2">
                            <strong>{{ $coupon->coupon->code }}</strong>
                            <span class="badge bg-success">-${{ number_format($coupon->discount_applied, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
</div>
@endsection
