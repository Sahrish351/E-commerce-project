@extends('client.layouts.app')

@section('title', 'My Orders')

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header-custom h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header-custom h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header-custom p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }
    .page-header-custom .badge-total {
        background: #db4444;
        color: #fff;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ===== FILTER TABS ===== */
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-tabs .tab {
        padding: 6px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        color: #555;
        background: #f5f5f5;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
    }
    .filter-tabs .tab:hover {
        background: #e8e8e8;
    }
    .filter-tabs .tab.active {
        background: #db4444;
        color: #fff;
    }

    /* ===== ORDER CARD ===== */
    .order-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #f0f0f0;
        margin-bottom: 16px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .order-card:hover {
        border-color: #db4444;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    /* Order Header */
    .order-card .order-header {
        padding: 14px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .order-card .order-header .order-id {
        font-weight: 700;
        font-size: 15px;
        color: #1a1a2e;
    }
    .order-card .order-header .order-id small {
        font-weight: 400;
        font-size: 12px;
        color: #8c8c9c;
        margin-left: 10px;
    }
    .order-card .order-header .order-date {
        font-size: 13px;
        color: #8c8c9c;
    }
    .order-card .order-header .order-date i {
        margin-right: 4px;
    }

    /* Order Body - Products */
    .order-card .order-products {
        padding: 14px 20px;
    }
    .order-card .order-products .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 14px;
    }
    .order-card .order-products .product-item:last-child {
        border-bottom: none;
    }
    .order-card .order-products .product-item .p-name {
        font-weight: 500;
        color: #1a1a2e;
    }
    .order-card .order-products .product-item .p-name small {
        font-weight: 400;
        color: #8c8c9c;
        font-size: 12px;
        margin-left: 4px;
    }
    .order-card .order-products .product-item .p-price {
        font-weight: 600;
        color: #1a1a2e;
    }
    .order-card .order-products .product-item .p-qty {
        color: #8c8c9c;
        font-size: 13px;
    }
    .order-card .order-products .show-more {
        font-size: 13px;
        color: #db4444;
        font-weight: 500;
        cursor: pointer;
        margin-top: 4px;
        display: inline-block;
    }
    .order-card .order-products .show-more:hover {
        text-decoration: underline;
    }

    /* Order Footer */
    .order-card .order-footer {
        padding: 12px 20px;
        border-top: 1px solid #f0f0f0;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .order-card .order-footer .left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .order-card .order-footer .status-badge {
        padding: 4px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .order-card .order-footer .status-badge .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .order-card .order-footer .status-badge.pending { background: #fff3cd; color: #856404; }
    .order-card .order-footer .status-badge.pending .dot { background: #ffc107; }
    .order-card .order-footer .status-badge.processing { background: #cce5ff; color: #004085; }
    .order-card .order-footer .status-badge.processing .dot { background: #0d6efd; }
    .order-card .order-footer .status-badge.shipped { background: #d4edda; color: #155724; }
    .order-card .order-footer .status-badge.shipped .dot { background: #17a2b8; }
    .order-card .order-footer .status-badge.delivered { background: #28a745; color: #fff; }
    .order-card .order-footer .status-badge.delivered .dot { background: #fff; }
    .order-card .order-footer .status-badge.cancelled { background: #f8d7da; color: #721c24; }
    .order-card .order-footer .status-badge.cancelled .dot { background: #dc3545; }

    .order-card .order-footer .total-amount {
        font-weight: 800;
        font-size: 17px;
        color: #1a1a2e;
    }
    .order-card .order-footer .total-amount span {
        font-weight: 400;
        font-size: 12px;
        color: #8c8c9c;
    }

    .order-card .order-footer .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .order-card .order-footer .actions .btn {
        padding: 5px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
    }
    .order-card .order-footer .actions .btn-view {
        background: #1a1a2e;
        color: #fff;
    }
    .order-card .order-footer .actions .btn-view:hover {
        background: #db4444;
        transform: translateY(-2px);
    }
    .order-card .order-footer .actions .btn-cancel {
        background: #f8d7da;
        color: #721c24;
    }
    .order-card .order-footer .actions .btn-cancel:hover {
        background: #dc3545;
        color: #fff;
        transform: translateY(-2px);
    }
    .order-card .order-footer .actions .btn-reorder {
        background: #d4edda;
        color: #155724;
    }
    .order-card .order-footer .actions .btn-reorder:hover {
        background: #28a745;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ===== EMPTY STATE ===== */
    .empty-orders {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
    }
    .empty-orders i {
        font-size: 56px;
        color: #ddd;
        display: block;
        margin-bottom: 16px;
    }
    .empty-orders h5 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    .empty-orders p {
        color: #8c8c9c;
        font-size: 14px;
    }
    .empty-orders .btn-shop {
        background: #db4444;
        color: #fff;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 400;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        margin-top: 12px;
        border: none;
    }
    .empty-orders .btn-shop:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
    }

    /* ===== TOAST ===== */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast-custom {
        background: #1a1a2e;
        color: #fff;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast-custom.success { border-left: 4px solid #28a745; }
    .toast-custom.error { border-left: 4px solid #dc3545; }
    .toast-custom .close-btn {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
    }
    .toast-custom .close-btn:hover { opacity: 1; }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    /* ===== PAGINATION ===== */
    .pagination-custom {
        margin-top: 20px;
    }
    .pagination-custom .pagination {
        justify-content: center;
        gap: 4px;
    }
    .pagination-custom .pagination .page-link {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 16px;
        color: #1a1a2e;
        font-size: 14px;
        transition: all 0.3s;
        background: #fff;
    }
    .pagination-custom .pagination .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-custom .pagination .active .page-link {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-custom .pagination .disabled .page-link {
        color: #999;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .order-card .order-header { padding: 10px 14px; }
        .order-card .order-products { padding: 10px 14px; }
        .order-card .order-footer { padding: 10px 14px; flex-direction: column; align-items: flex-start; }
        .order-card .order-footer .actions { width: 100%; }
        .order-card .order-footer .actions .btn { flex: 1; justify-content: center; }
        .filter-tabs .tab { font-size: 12px; padding: 4px 14px; }
        .page-header-custom { flex-direction: column; align-items: flex-start; }
        .order-card .order-footer .left { width: 100%; justify-content: space-between; }
    }
    @media (max-width: 480px) {
        .order-card .order-header .order-id { font-size: 13px; }
        .order-card .order-header .order-id small { display: block; margin-left: 0; }
        .order-card .order-products .product-item { font-size: 13px; flex-wrap: wrap; gap: 4px; }
        .order-card .order-footer .total-amount { font-size: 15px; }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header-custom">
    <div>
        <h4><i class="fas fa-shopping-bag"></i> My Orders</h4>
        <p>View and manage all your orders</p>
    </div>
    <span class="badge-total">
        <i class="fas fa-box"></i> {{ auth()->user()->orders()->count() }} Total
    </span>
</div>

<!-- ===== FILTER TABS ===== -->
<div class="filter-tabs">
    <a href="{{ route('client.orders') }}" class="tab {{ !request()->get('status') ? 'active' : '' }}">All</a>
    <a href="{{ route('client.orders', ['status' => 'pending']) }}" class="tab {{ request()->get('status') == 'pending' ? 'active' : '' }}">Pending</a>
    <a href="{{ route('client.orders', ['status' => 'processing']) }}" class="tab {{ request()->get('status') == 'processing' ? 'active' : '' }}">Processing</a>
    <a href="{{ route('client.orders', ['status' => 'shipped']) }}" class="tab {{ request()->get('status') == 'shipped' ? 'active' : '' }}">Shipped</a>
    <a href="{{ route('client.orders', ['status' => 'delivered']) }}" class="tab {{ request()->get('status') == 'delivered' ? 'active' : '' }}">Delivered</a>
    <a href="{{ route('client.orders', ['status' => 'cancelled']) }}" class="tab {{ request()->get('status') == 'cancelled' ? 'active' : '' }}">Cancelled</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($orders->count() > 0)
    @foreach($orders as $order)
    <div class="order-card">
        <!-- ===== HEADER ===== -->
        <div class="order-header">
            <div class="order-id">
                #{{ $order->order_number ?? $order->id }}
                <small><i class="far fa-calendar-alt me-1"></i> {{ $order->created_at->format('M d, Y') }}</small>
            </div>
            <div class="order-date">
                <i class="far fa-clock"></i> {{ $order->created_at->format('h:i A') }}
            </div>
        </div>

        <!-- ===== PRODUCTS ===== -->
        <div class="order-products">
            @php
                $items = $order->items;
                $displayItems = $items->take(3);
                $remaining = $items->count() - 3;
            @endphp
            @foreach($displayItems as $item)
            <div class="product-item">
                <span class="p-name">
                    {{ $item->product_name ?? 'Product' }}
                    <small>x{{ $item->quantity }}</small>
                </span>
                <span class="p-price">${{ number_format($item->unit_price ?? $item->price ?? 0, 2) }}</span>
            </div>
            @endforeach
            @if($remaining > 0)
            <div class="show-more" onclick="this.closest('.order-products').querySelectorAll('.product-item.hidden').forEach(el => el.style.display = 'flex'); this.style.display='none'">
                + Show {{ $remaining }} more items
            </div>
            @foreach($items->skip(3) as $item)
            <div class="product-item hidden" style="display:none;">
                <span class="p-name">
                    {{ $item->product_name ?? 'Product' }}
                    <small>x{{ $item->quantity }}</small>
                </span>
                <span class="p-price">${{ number_format($item->unit_price ?? $item->price ?? 0, 2) }}</span>
            </div>
            @endforeach
            @endif
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="order-footer">
            <div class="left">
                <span class="status-badge {{ $order->status ?? 'pending' }}">
                    <span class="dot"></span>
                    {{ ucfirst($order->status ?? 'pending') }}
                </span>
                <span class="total-amount">
                    ${{ number_format($order->grand_total ?? $order->total_amount ?? 0, 2) }}
                    <span>Total</span>
                </span>
            </div>
            <div class="actions">
                <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-view">
                    <i class="fas fa-eye"></i> View
                </a>
                @if(in_array($order->status, ['pending', 'processing']))
                <button onclick="cancelOrder('{{ $order->id }}')" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </button>
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
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="pagination-custom">
        {{ $orders->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="empty-orders">
        <i class="fas fa-box-open"></i>
        <h5>No Orders Found</h5>
        <p>You haven't placed any orders yet. Start shopping now!</p>
        <a href="{{ route('shop.index') }}" class="btn-shop">
            <i class="fas fa-store me-2"></i> Start Shopping
        </a>
    </div>
@endif

<script>
    // ========================================
    // CANCEL ORDER
    // ========================================
    function cancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel this order?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("client.orders.cancel", ":id") }}'.replace(':id', orderId);
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }

    // ========================================
    // TOAST SYSTEM
    // ========================================
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-custom ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <span class="close-btn" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    }

    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session("error") }}', 'error');
    @endif
</script>
@endsection