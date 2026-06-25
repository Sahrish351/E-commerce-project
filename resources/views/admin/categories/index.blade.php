@extends('admin.layouts.app')

@section('title', 'Categories - StyleHub Admin')

@section('content')
<style>
    /* ========================================
       CATEGORIES PAGE STYLES
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
    .btn-primary-custom {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }
    .btn-primary-custom:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.3);
        color: #fff;
    }
    .btn-primary-custom i {
        font-size: 13px;
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
    .badge-status.active {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.inactive {
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
    .action-btn.edit:hover {
        background: #0d6efd;
        border-color: #0d6efd;
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
    .btn-primary-custom-sm {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }
    .btn-primary-custom-sm:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.3);
        color: #fff;
    }
    .btn-primary-custom-sm i {
        font-size: 12px;
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
        .empty-state {
            padding: 30px 15px;
        }
        .empty-state i {
            font-size: 36px;
        }
    }
</style>

<!-- ========================================
     PAGE HEADER
     ======================================== -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-tags"></i> Categories</h4>
        <p>Manage your product categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary-custom">
        <i class="fas fa-plus-circle"></i> Add Category
    </a>
</div>

<!-- ========================================
     FILTERS
     ======================================== -->
<div class="filter-card">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-5 d-flex gap-2">
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- ========================================
     CATEGORIES TABLE
     ======================================== -->
<div class="table-card">
    <div class="table-header">
        <span class="title"><i class="fas fa-list"></i> All Categories</span>
        <span style="font-size: 13px; color: #8c8c9c;">Total: {{ $categories->total() ?? 0 }} categories</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories ?? [] as $category)
                <tr>
                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                    <td>
                        <div>
                            <div style="font-weight: 600; font-size: 14px;">{{ $category->name }}</div>
                            @if($category->parent)
                                <small style="color: #999; font-size: 12px;">Parent: {{ $category->parent->name }}</small>
                            @endif
                        </div>
                    </td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        <span class="badge bg-info" style="background: #0d6efd; color: #fff; padding: 4px 12px; border-radius: 30px; font-size: 12px;">
                            {{ $category->products_count ?? 0 }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-status {{ $category->is_active ? 'active' : 'inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit" title="Edit">
                                <i class="fas fa-edit" style="font-size: 13px;"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure? This will also delete all sub-categories.')">
                                    <i class="fas fa-trash" style="font-size: 13px;"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.categories.toggle', $category->id) }}" class="action-btn" title="Toggle Status" onclick="event.preventDefault(); document.getElementById('toggle-form-{{ $category->id }}').submit();">
                                <i class="fas fa-sync" style="font-size: 13px;"></i>
                            </a>
                            <form id="toggle-form-{{ $category->id }}" action="{{ route('admin.categories.toggle', $category->id) }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-tags"></i>
                            <h5>No Categories Found</h5>
                            <p>Start adding categories to organize your products.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn-primary-custom-sm">
                                <i class="fas fa-plus-circle"></i> Add Category
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($categories) && method_exists($categories, 'links') && $categories->hasPages())
    <div class="pagination-wrapper">
        <span class="info">Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() ?? 0 }} categories</span>
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection