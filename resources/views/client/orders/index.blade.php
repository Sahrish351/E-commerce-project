@extends('client.layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0"><i class="fas fa-shopping-bag text-danger me-2"></i> My Orders</h5>
    </div>
    <div class="card-body">
        @forelse($orders as $order)
        <div class="border rounded-3 p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong>#{{ $order->order_number ?? $order->id }}</strong>
                    <div style="font-size:12px; color:#999;">{{ $order->created_at->format('M d, Y') }}</div>
                </div>
                <span class="badge-status {{ $order->status ?? 'pending' }}">
                    {{ ucfirst($order->status ?? 'pending') }}
                </span>
                <div>
                    <strong>${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</strong>
                    <div style="font-size:12px; color:#999;">{{ $order->items_count ?? 0 }} items</div>
                </div>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-eye"></i> View
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-4">
            <i class="fas fa-inbox" style="font-size:40px; color:#ddd; display:block; margin-bottom:10px;"></i>
            <p class="text-muted">You haven't placed any orders yet</p>
            <a href="{{ route('shop.index') }}" class="btn btn-danger">Start Shopping</a>
        </div>
        @endforelse

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection