@extends('admin.layouts.app')

@section('title', 'Products - StyleHub Admin')

@section('content')
<style>
    /* ----- Product Page Styles ----- */
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

    .product-img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        background: #f5f5f5;
        border-radius: 8px;
        padding: 4px;
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
    .badge-status.stock-low {
        background: #fff3cd;
        color: #856404;
    }
    .badge-status.stock-out {
        background: #f8d7da;
        color: #721c24;
    }
    .badge-status.stock-in {
        background: #d4edda;
        color: #155724;
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
        font-size: 28px;
        color: #ddd;
        margin-bottom: 4px;
        margin-top: 4px;
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
        .product-img {
            width: 35px;
            height: 35px;
        }
        .empty-state {
            padding: 30px 15px;
        }
        .empty-state i {
            font-size: 16px;
        }
    }
</style>

<!-- ========================================
     PAGE HEADER
     ======================================== -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-box"></i> Products</h4>
        <p>Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary-custom">
        <i class="fas fa-plus-circle"></i> Add Product
    </a>
</div>

<!-- ========================================
     FILTERS
     ======================================== -->
<div class="filter-card">
    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="stock" class="form-select">
                <option value="">All Stock</option>
                <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- ========================================
     PRODUCTS TABLE
     ======================================== -->
<div class="table-card">
    <div class="table-header">
        <span class="title"><i class="fas fa-list"></i> All Products</span>
        <span style="font-size: 13px; color: #8c8c9c;">Total: {{ $products->total() ?? 0 }} products</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th style="white-space: nowrap;">Stock</th>
                    <th>Status</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                <tr>
                    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $image = $product->images->first();
                            @endphp
                            <img src="{{ $image ? asset($image->image_url) : asset('images/products/default.jpg') }}"
                                 alt="{{ $product->name }}"
                                 class="product-img">
                            <div>
                                <div style="font-weight: 600; font-size: 14px;">{{ $product->name }}</div>
                                <small style="color: #999; font-size: 12px;">SKU: {{ $product->sku }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>
                        <span style="font-weight: 600; color: #1a1a2e;">${{ number_format($product->price, 2) }}</span>
                        @if($product->sale_price)
                            <br><small style="color: #db4444; text-decoration: line-through; font-size: 12px;">${{ number_format($product->price, 2) }}</small>
                        @endif
                    </td>
                    <td style="white-space: nowrap;">
                        @if($product->stock_quantity <= 0)
                            <span class="badge-status stock-out">Out of Stock</span>
                        @elseif($product->stock_quantity <= 5)
                            <span class="badge-status stock-low">{{ $product->stock_quantity }} left</span>
                        @else
                            <span class="badge-status stock-in">{{ $product->stock_quantity }} in stock</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status {{ $product->is_active ? 'active' : 'inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn edit" title="Edit">
                                <i class="fas fa-edit" style="font-size: 13px;"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash" style="font-size: 13px;"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.products.show', $product->id) }}" class="action-btn" title="View">
                                <i class="fas fa-eye" style="font-size: 13px;"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <!-- ✅ NEW (Chhota button) -->
<div class="empty-state">
    <i class="fas fa-box-open"></i>
    <h5>No Products Found</h5>
    <p>Start adding products to your catalog.</p>
    <a href="{{ route('admin.products.create') }}" class="btn-primary-custom" style="display: inline-flex; padding: 4px 10px; font-size: 13px;">
        <i class="fas fa-plus-circle"></i> Add Product
    </a>
</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($products) && method_exists($products, 'links') && $products->hasPages())
    <div class="pagination-wrapper">
        <span class="info">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} products</span>
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection