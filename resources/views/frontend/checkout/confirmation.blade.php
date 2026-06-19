@extends('layouts.app')

@section('title', 'Order Confirmation - StyleHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <!-- Success Header -->
                <div style="background: linear-gradient(135deg, #28a745, #20c997); padding: 40px 30px; text-align: center; color: #fff;">
                    <i class="fas fa-check-circle" style="font-size: 72px; margin-bottom: 15px;"></i>
                    <h2 class="fw-bold" style="font-size: 32px;">Order Placed Successfully!</h2>
                    <p class="mb-0" style="font-size: 18px; opacity: 0.9;">Thank you for your order</p>
                </div>
                
                <!-- Body -->
                <div style="padding: 30px;">
                    <!-- Order Number -->
                    <div style="background: #f8f9fa; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
                        <p class="mb-0" style="font-size: 14px; color: #666;">Order Number</p>
                        <h4 class="fw-bold mb-0" style="color: #333;">
                            #{{ $orderNumber ?? $order->order_number ?? 'N/A' }}
                        </h4>
                    </div>
                    
                    <!-- Order Details -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div style="border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                                <h6 class="fw-bold mb-2" style="font-size: 14px; color: #666;">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size: 14px;">Subtotal:</span>
                                    <span style="font-size: 14px; font-weight: 600;">${{ number_format($order->subtotal ?? 0, 2) }}</span>
                                </div>
                                @if(($order->discount_amount ?? 0) > 0)
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size: 14px;">Discount:</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #28a745;">-${{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size: 14px;">Shipping:</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #28a745;">
                                        @if($order->shipping_charge > 0)
                                            ${{ number_format($order->shipping_charge, 2) }}
                                        @else
                                            Free
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size: 14px;">Tax:</span>
                                    <span style="font-size: 14px; font-weight: 600;">${{ number_format($order->tax_amount ?? 0, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between pt-2" style="border-top: 2px solid #eee;">
                                    <span style="font-size: 16px; font-weight: 700;">Total:</span>
                                    <span style="font-size: 16px; font-weight: 700; color: #db4444;">${{ number_format($order->grand_total ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                                <h6 class="fw-bold mb-2" style="font-size: 14px; color: #666;">Shipping Details</h6>
                                <p style="font-size: 14px; margin-bottom: 2px; font-weight: 500;">{{ $order->shipping_name ?? 'N/A' }}</p>
                                <p style="font-size: 14px; margin-bottom: 2px; color: #666;">{{ $order->shipping_address ?? 'N/A' }}</p>
                                <p style="font-size: 14px; margin-bottom: 2px; color: #666;">{{ $order->shipping_city ?? 'N/A' }}</p>
                                <p style="font-size: 14px; margin-bottom: 0; color: #666;">{{ $order->shipping_phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div style="background: #f8f9fa; padding: 15px 20px; border-radius: 8px; margin-top: 20px;">
                        <p class="mb-0" style="font-size: 14px; color: #666;">Payment Method</p>
                        <p class="fw-bold mb-0" style="color: #333; text-transform: capitalize;">
                            @if($order->payment_method == 'cod')
                                Cash on Delivery
                            @elseif($order->payment_method == 'bank')
                                Bank Transfer
                            @elseif($order->payment_method == 'card')
                                Credit/Debit Card
                            @else
                                {{ $order->payment_method ?? 'N/A' }}
                            @endif
                        </p>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-0 px-5 py-2" style="background: #db4444; font-weight: 600;">
                            <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-0 px-5 py-2" style="border-color: #ddd; font-weight: 600;">
                            <i class="fas fa-home me-2"></i> Go to Home
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Order Items Table -->
            @if($order && $order->items && $order->items->count() > 0)
            <div style="margin-top: 30px;">
                <h5 class="fw-bold mb-3">Order Items</h5>
                <div style="border: 1px solid #eee; border-radius: 8px; overflow: hidden;">
                    <table class="table table-bordered mb-0" style="border-color: #eee;">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="padding: 12px 15px; font-size: 14px;">Product</th>
                                <th style="padding: 12px 15px; font-size: 14px; text-align: center;">Quantity</th>
                                <th style="padding: 12px 15px; font-size: 14px; text-align: right;">Price</th>
                                <th style="padding: 12px 15px; font-size: 14px; text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="padding: 10px 15px; font-size: 14px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>🛒</span>
                                        <span>{{ $item->product_name ?? 'Product' }}</span>
                                    </div>
                                </td>
                                <td style="padding: 10px 15px; font-size: 14px; text-align: center;">{{ $item->quantity }}</td>
                                <td style="padding: 10px 15px; font-size: 14px; text-align: right;">${{ number_format($item->price, 2) }}</td>
                                <td style="padding: 10px 15px; font-size: 14px; text-align: right; font-weight: 600;">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr style="background: #f8f9fa; font-weight: 700;">
                                <td colspan="3" style="padding: 10px 15px; font-size: 14px; text-align: right;">Total:</td>
                                <td style="padding: 10px 15px; font-size: 14px; text-align: right; color: #db4444; font-weight: 700;">
                                    ${{ number_format($order->grand_total ?? 0, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
    }
    .btn-danger {
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        background: #c0392b !important;
        transform: translateY(-2px);
    }
    .btn-outline-dark:hover {
        background: #000 !important;
        color: #fff !important;
    }
    .table-bordered td, .table-bordered th {
        border-color: #eee;
    }
</style>
@endsection