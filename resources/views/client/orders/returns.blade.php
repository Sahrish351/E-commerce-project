@extends('client.layouts.app')

@section('title', 'My Returns - StyleHub')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="fas fa-undo-alt text-danger me-2"></i> My Returns</h4>
    
    @if($returns->count() > 0)
        @foreach($returns as $order)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold">#{{ $order->order_number ?? $order->id }}</h6>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                    </div>
                    <div>
                        <span class="badge bg-warning">Returned</span>
                        <span class="fw-bold ms-2">${{ number_format($order->total_amount ?? $order->grand_total ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{ $returns->links() }}
    @else
        <div class="text-center py-5">
            <i class="fas fa-undo-alt fa-3x text-muted mb-3"></i>
            <h5>No returns found</h5>
        </div>
    @endif
</div>
@endsection