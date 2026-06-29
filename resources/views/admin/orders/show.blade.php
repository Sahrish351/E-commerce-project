@extends('admin.layouts.app')

@section('title', 'Order Details - StyleHub Admin')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }
    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }
    .btn-back:hover {
        background: #e0e0e0;
    }

    .detail-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        overflow: hidden;
        padding: 24px 28px;
        margin-bottom: 24px;
    }
    .detail-card .section-title {
        font-weight: 600;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-card .section-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .detail-card .info-row {
        display: flex;
        padding: 6px 0;
    }
    .detail-card .info-row .label {
        width: 120px;
        flex-shrink: 0;
        font-size: 13px;
        color: #8c8c9c;
        font-weight: 500;
    }
    .detail-card .info-row .value {
        font-size: 14px;
        font-weight: 500;
        color: #1a1a2e;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
        white-space: nowrap;
        display: inline-block;
    }
    .badge-status.pending { background: #fff3cd; color: #856404; }
    .badge-status.processing { background: #cce5ff; color: #004085; }
    .badge-status.shipped { background: #d4edda; color: #155724; }
    .badge-status.delivered { background: #28a745; color: #fff; }
    .badge-status.cancelled { background: #f8d7da; color: #721c24; }

    .btn-update {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-update:hover {
        background: #c0392b;
    }

    .order-items-table {
        width: 100%;
        font-size: 14px;
    }
    .order-items-table th {
        background: #f8f9fa;
        color: #666;
        font-weight: 600;
        padding: 10px 15px;
        border-bottom: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .order-items-table td {
        padding: 10px 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    .order-items-table tr:last-child td {
        border-bottom: none;
    }
    .order-items-table .total-row td {
        font-weight: 700;
        border-top: 2px solid #e0e0e0;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .detail-card {
            padding: 16px;
        }
        .detail-card .info-row {
            flex-direction: column;
        }
        .detail-card .info-row .label {
            width: 100%;
        }
    }
</style>


<div class="page-header">
    <div>
        <h4><i class="fas fa-eye"></i> Order #{{ $order->order_number }}</h4>
        <p>View order details</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="detail-card">
            <div class="section-title"><i class="fas fa-box"></i> Order Items</div>
            <div class="table-responsive">
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name ?? $item->product->name ?? 'Product' }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Subtotal</td>
                            <td>${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        @if($order->discount_amount > 0)
                        <tr>
                            <td colspan="3" style="text-align: right;">Discount</td>
                            <td>-${{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" style="text-align: right;">Shipping</td>
                            <td>${{ number_format($order->shipping_charge ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;">Tax</td>
                            <td>${{ number_format($order->tax_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right; font-size: 16px;">Grand Total</td>
                            <td style="font-size: 18px; color: #db4444;">${{ number_format($order->grand_total ?? $order->total_amount ?? 0, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
       
        <div class="detail-card">
            <div class="section-title"><i class="fas fa-sync"></i> Update Status</div>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <select name="status" class="form-select" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn-update w-100">
                    <i class="fas fa-save me-2"></i> Update Status
                </button>
            </form>
        </div>

     
        <div class="detail-card">
            <div class="section-title"><i class="fas fa-user"></i> Customer Details</div>
            <div class="info-row">
                <span class="label">Name</span>
                <span class="value">{{ $order->user->name ?? 'Guest' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email</span>
                <span class="value">{{ $order->user->email ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Phone</span>
                <span class="value">{{ $order->shipping_phone ?? 'N/A' }}</span>
            </div>
        </div>

     
        <div class="detail-card">
            <div class="section-title"><i class="fas fa-truck"></i> Shipping Details</div>
            <div class="info-row">
                <span class="label">Address</span>
                <span class="value">{{ $order->shipping_address ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">City</span>
                <span class="value">{{ $order->shipping_city ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">State</span>
                <span class="value">{{ $order->shipping_state ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Postal Code</span>
                <span class="value">{{ $order->shipping_postal_code ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection