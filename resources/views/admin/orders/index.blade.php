@extends('admin.layouts.app')

@section('title', 'Orders - StyleHub Admin')

@section('content')
<style>
    /* ========================================
       ORDERS PAGE STYLES
       ======================================== */
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

    .filter-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px 22px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 8px 14px;
        font-size: 14px;
        height: 42px;
    }
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.08);
    }
    .filter-card .btn-filter {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .filter-card .btn-filter:hover {
        background: #c0392b;
    }
    .filter-card .btn-reset {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .filter-card .btn-reset:hover {
        background: #e0e0e0;
    }

    /* Status Tabs */
    .status-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .status-tabs .tab-btn {
        padding: 6px 16px;
        border-radius: 30px;
        border: 1px solid #e0e0e0;
        background: transparent;
        color: #666;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-tabs .tab-btn:hover {
        background: #f5f5f5;
    }
    .status-tabs .tab-btn.active {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .status-tabs .tab-btn .count {
        background: rgba(0,0,0,0.08);
        padding: 0 8px;
        border-radius: 30px;
        font-size: 11px;
    }
    .status-tabs .tab-btn.active .count {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }

    .table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .table-card .table-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .table-card .table-header .title {
        font-weight: 600;
        font-size: 16px;
        color: #1a1a2e;
    }
    .table-card .table-header .title i {
        color: #db4444;
        margin-right: 8px;
    }

    .table-premium {
        font-size: 14px;
        margin-bottom: 0;
    }
    .table-premium thead th {
        background: #f8f9fa;
        color: #666;
        font-weight: 600;
        padding: 10px 18px;
        border-bottom: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .table-premium tbody td {
        padding: 10px 18px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    .table-premium tbody tr:hover {
        background: #fafafa;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
        white-space: nowrap;
        display: inline-block;
    }
    .badge-status.pending {
        background: #fff3cd;
        color: #856404;
    }
    .badge-status.processing {
        background: #cce5ff;
        color: #004085;
    }
    .badge-status.shipped {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.delivered {
        background: #28a745;
        color: #fff;
    }
    .badge-status.cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background: transparent;
        color: #666;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .action-btn:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .action-btn.view:hover {
        background: #0d6efd;
        border-color: #0d6efd;
    }

    .pagination-wrapper {
        padding: 16px 22px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .pagination-wrapper .info {
        font-size: 14px;
        color: #8c8c9c;
    }
    .pagination-wrapper .pagination {
        margin: 0;
        gap: 4px;
    }
    .pagination-wrapper .page-link {
        border-radius: 8px !important;
        border: 1px solid #e0e0e0;
        color: #333;
        padding: 6px 14px;
        font-size: 14px;
    }
    .pagination-wrapper .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: #db4444;
        border-color: #db4444;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-state i {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 12px;
        display: block;
    }
    .empty-state h5 {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 4px;
        font-size: 18px;
    }
    .empty-state p {
        color: #8c8c9c;
        margin-bottom: 16px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-card .row {
            gap: 10px;
        }
        .status-tabs {
            gap: 4px;
        }
        .status-tabs .tab-btn {
            font-size: 12px;
            padding: 4px 12px;
        }
        .table-responsive {
            font-size: 13px;
        }
    }
</style>

<!-- ========================================
     PAGE HEADER
     ======================================== -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-shopping-cart"></i> Orders</h4>
        <p>Manage customer orders</p>
    </div>
</div>

<!-- ========================================
     STATUS TABS
     ======================================== -->
<div class="status-tabs">
    <a href="{{ route('admin.orders.index') }}" class="tab-btn {{ !request('status') ? 'active' : '' }}">
        All <span class="count">{{ array_sum($statusCounts ?? []) }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="tab-btn {{ request('status') == 'pending' ? 'active' : '' }}">
        Pending <span class="count">{{ $statusCounts['pending'] ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="tab-btn {{ request('status') == 'processing' ? 'active' : '' }}">
        Processing <span class="count">{{ $statusCounts['processing'] ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="tab-btn {{ request('status') == 'shipped' ? 'active' : '' }}">
        Shipped <span class="count">{{ $statusCounts['shipped'] ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="tab-btn {{ request('status') == 'delivered' ? 'active' : '' }}">
        Delivered <span class="count">{{ $statusCounts['delivered'] ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="tab-btn {{ request('status') == 'cancelled' ? 'active' : '' }}">
        Cancelled <span class="count">{{ $statusCounts['cancelled'] ?? 0 }}</span>
    </a>
</div>

<!-- ========================================
     FILTERS
     ======================================== -->
<div class="filter-card">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by order number..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-5 d-flex gap-2">
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- ========================================
     ORDERS TABLE
     ======================================== -->
<div class="table-card">
    <div class="table-header">
        <span class="title"><i class="fas fa-list"></i> All Orders</span>
        <span style="font-size: 13px; color: #8c8c9c;">Total: {{ $orders->total() ?? 0 }} orders</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width: 60px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                <tr>
                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                    <td>
                        <span style="font-weight: 600; font-size: 14px;">#{{ $order->order_number }}</span>
                    </td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>
                        <span style="font-weight: 700; color: #1a1a2e;">${{ number_format($order->grand_total ?? $order->total_amount ?? 0, 2) }}</span>
                    </td>
                    <td>
                        <span class="badge-status {{ $order->status ?? 'pending' }}">
                            {{ ucfirst($order->status ?? 'pending') }}
                        </span>
                    </td>
                    <td style="color: #999; font-size: 13px;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn view" title="View Order">
                            <i class="fas fa-eye" style="font-size: 13px;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h5>No Orders Found</h5>
                            <p>Orders will appear here once customers place them.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($orders) && method_exists($orders, 'links') && $orders->hasPages())
    <div class="pagination-wrapper">
        <span class="info">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() ?? 0 }} orders</span>
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection