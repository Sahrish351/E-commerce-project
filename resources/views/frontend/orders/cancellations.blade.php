@extends('layouts.app')

@section('title', 'My Cancellations - StyleHub')

@section('content')
<div class="container py-4">
    
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile.dashboard') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">My Cancellations</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">❌ My Cancellations</h4>
            <p class="text-muted small">View all your cancelled orders.</p>
        </div>
    </div>

    @if($cancellations->count() > 0)
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
                    @foreach($cancellations as $order)
                    <tr>
                        <td class="fw-semibold small">#{{ $order->order_number }}</td>
                        <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="small">{{ $order->items->count() }}</td>
                        
                        <td class="fw-semibold small">${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-danger px-2 py-1 rounded-pill" style="font-size: 10px;">
                                Cancelled ❌
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
        {{ $cancellations->links() }}
    @else
    <div class="text-center py-5" style="min-height: 320px;">  
        <i class="fas fa-times-circle fa-3x text-muted mb-3 opacity-25"></i>
        <h6 class="fw-bold mb-2">No Cancellations</h6>
        <p class="text-muted small">You haven't cancelled any orders yet.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-pill px-4">
            <i class="fas fa-shopping-bag me-2"></i> Start Shopping
        </a>
    </div>
@endif
</div>
@endsection