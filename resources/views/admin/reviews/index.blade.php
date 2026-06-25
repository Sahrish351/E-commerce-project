@extends('admin.layouts.app')

@section('title', 'Reviews - StyleHub Admin')

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
    .badge-status.approved {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.pending {
        background: #fff3cd;
        color: #856404;
    }
    .badge-status.rejected {
        background: #f8d7da;
        color: #721c24;
    }
    .rating-stars {
        color: #ffb800;
        font-size: 14px;
    }
    .rating-stars .empty {
        color: #ddd;
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
    .action-btn.approve:hover {
        background: #28a745;
        border-color: #28a745;
    }
    .action-btn.reject:hover {
        background: #dc3545;
        border-color: #dc3545;
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
        .filter-card .row {
            gap: 10px;
        }
        .table-responsive {
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-star"></i> Reviews</h4>
        <p>Manage product reviews</p>
    </div>
</div>

<div class="filter-card">
    <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by product or customer..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-5 d-flex gap-2">
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.reviews.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="title"><i class="fas fa-list"></i> All Reviews</span>
        <span style="font-size: 13px; color: #8c8c9c;">Total: {{ $reviews->total() ?? 0 }} reviews</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews ?? [] as $review)
                <tr>
                    <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                    <td>
                        <div style="font-weight: 600; font-size: 14px;">{{ $review->product->name ?? 'Product' }}</div>
                    </td>
                    <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                    <td>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star empty"></i>
                                @endif
                            @endfor
                        </div>
                    </td>
                    <td>
                        <div style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #666; font-size: 13px;">
                            {{ $review->comment }}
                        </div>
                    </td>
                    <td>
                        @if($review->trashed())
                            <span class="badge-status rejected">Rejected</span>
                        @elseif($review->is_approved)
                            <span class="badge-status approved">Approved</span>
                        @else
                            <span class="badge-status pending">Pending</span>
                        @endif
                    </td>
                    <td style="color: #999; font-size: 13px;">{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            @if(!$review->is_approved && !$review->trashed())
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn approve" title="Approve">
                                    <i class="fas fa-check" style="font-size: 13px;"></i>
                                </button>
                            </form>
                            @endif
                            @if(!$review->trashed())
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn reject" title="Reject">
                                    <i class="fas fa-times" style="font-size: 13px;"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash" style="font-size: 13px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h5>No Reviews Found</h5>
                            <p>Reviews will appear here once customers submit them.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($reviews) && method_exists($reviews, 'links') && $reviews->hasPages())
    <div class="pagination-wrapper">
        <span class="info">Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() ?? 0 }} reviews</span>
        {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection