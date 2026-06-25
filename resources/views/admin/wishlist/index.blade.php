@extends('admin.layouts.app')

@section('title', 'Wishlist - StyleHub Admin')

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
    .filter-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px 22px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .filter-card .form-control {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 8px 14px;
        font-size: 14px;
        height: 42px;
    }
    .filter-card .form-control:focus {
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
    .action-btn.delete:hover {
        background: #dc3545;
        border-color: #dc3545;
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
        .table-responsive {
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-heart"></i> Wishlist</h4>
        <p>Manage customer wishlists</p>
    </div>
</div>

<div class="filter-card">
    <form action="{{ route('admin.wishlist.index') }}" method="GET" class="row g-3">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search by customer or product..." value="{{ request('search') }}">
        </div>
        <div class="col-md-6 d-flex gap-2">
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.wishlist.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="title"><i class="fas fa-list"></i> All Wishlist Items</span>
        <span style="font-size: 13px; color: #8c8c9c;">Total: {{ $wishlistItems->total() ?? 0 }} items</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Added</th>
                    <th style="width: 60px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wishlistItems ?? [] as $item)
                <tr>
                    <td>{{ ($wishlistItems->currentPage() - 1) * $wishlistItems->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->user->name ?? 'Guest' }}</td>
                    <td>
                        <div style="font-weight: 600; font-size: 14px;">{{ $item->product->name ?? 'Product' }}</div>
                    </td>
                    <td>
                        <span style="font-weight: 700; color: #db4444;">${{ number_format($item->product->price ?? 0, 2) }}</span>
                    </td>
                    <td style="color: #999; font-size: 13px;">{{ $item->created_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.wishlist.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Remove" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash" style="font-size: 13px;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-heart"></i>
                            <h5>No Wishlist Items Found</h5>
                            <p>Wishlist items will appear here once customers add products to their wishlist.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($wishlistItems) && method_exists($wishlistItems, 'links') && $wishlistItems->hasPages())
    <div class="pagination-wrapper">
        <span class="info">Showing {{ $wishlistItems->firstItem() ?? 0 }} to {{ $wishlistItems->lastItem() ?? 0 }} of {{ $wishlistItems->total() ?? 0 }} items</span>
        {{ $wishlistItems->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection