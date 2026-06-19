@extends('layouts.app')

@section('title', 'My Orders - StyleHub')

@section('content')
<div class="container py-4">
   
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile.dashboard') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">My Orders</li>
                </ol>
            </nav>
        </div>
    </div>

  
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">📦 My Orders</h4>
            <p class="text-muted small">View all your orders.</p>
        </div>
    </div>

  
    <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                <i class="fas fa-list me-1"></i> All Orders
                <span class="badge bg-dark ms-1">{{ $orders->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('orders.returns') }}" class="nav-link">
                <i class="fas fa-undo me-1"></i> Returns
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('orders.cancellations') }}" class="nav-link">
                <i class="fas fa-times-circle me-1"></i> Cancellations
            </a>
        </li>
    </ul>

    <div class="tab-content" id="orderTabsContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="small text-muted fw-medium">Order ID</th>
                                <th class="small text-muted fw-medium">Date</th>
                                <th class="small text-muted fw-medium">Items</th>
                                <th class="small text-muted fw-medium">Total</th>
                                <th class="small text-muted fw-medium">Status</th>
                                <th class="small text-muted fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="fw-semibold small">#{{ $order->order_number }}</td>
                                <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="small">{{ $order->items->count() }}</td>
                                
                                <td class="fw-semibold small">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        $statusLabel = ucfirst($order->status);
                                        if($order->status == 'delivered') {
                                            $statusClass = 'success';
                                            $statusLabel = 'Delivered ✅';
                                        } elseif($order->status == 'pending') {
                                            $statusClass = 'warning';
                                            $statusLabel = 'Pending ⏳';
                                        } elseif($order->status == 'processing') {
                                            $statusClass = 'info';
                                            $statusLabel = 'Processing 🔄';
                                        } elseif($order->status == 'shipped') {
                                            $statusClass = 'primary';
                                            $statusLabel = 'Shipped 🚚';
                                        } elseif($order->status == 'cancelled') {
                                            $statusClass = 'danger';
                                            $statusLabel = 'Cancelled ❌';
                                        } elseif($order->status == 'refunded') {
                                            $statusClass = 'warning';
                                            $statusLabel = 'Refunded 🔄';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} px-2 py-1 rounded-pill" style="font-size: 10px;">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        View <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                    <h6 class="fw-bold mb-2">No Orders Yet</h6>
                    <p class="text-muted small mb-3">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        padding: 10px 20px;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link:hover {
        color: #db4444;
        background: #fff5f5;
    }
    .nav-tabs .nav-link.active {
        color: #db4444;
        background: #fff5f5;
        border-bottom: 3px solid #db4444;
        font-weight: 600;
    }
    .nav-tabs .nav-link .badge {
        font-size: 10px;
        padding: 2px 8px;
    }
    .table th {
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
        font-size: 13px;
    }
    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }
</style>
@endpush