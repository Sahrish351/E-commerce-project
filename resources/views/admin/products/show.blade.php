@extends('admin.layouts.app')

@section('title', $product->name . ' - StyleHub Admin')

@section('content')
<style>
    /* ========================================
       PRODUCT SHOW PAGE STYLES
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
    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }
    .btn-back:hover {
        background: #e0e0e0;
    }
    .btn-edit {
        background: #0d6efd;
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
        font-size: 14px;
    }
    .btn-edit:hover {
        background: #0b5ed7;
        color: #fff;
    }
    .btn-delete {
        background: #dc3545;
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
        font-size: 14px;
        cursor: pointer;
    }
    .btn-delete:hover {
        background: #c0392b;
        color: #fff;
    }

    /* ----- Detail Card ----- */
    .detail-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        overflow: hidden;
        padding: 28px 30px;
    }
    .detail-card .section-title {
        font-weight: 600;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-card .section-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .detail-card .info-row {
        display: flex;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .detail-card .info-row:last-child {
        border-bottom: none;
    }
    .detail-card .info-row .label {
        width: 140px;
        flex-shrink: 0;
        font-size: 13px;
        color: #8c8c9c;
        font-weight: 500;
    }
    .detail-card .info-row .value {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
    }
    .detail-card .info-row .value .price {
        color: #db4444;
        font-size: 18px;
    }
    .detail-card .info-row .value .sale-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-left: 10px;
    }
    .detail-card .info-row .value .discount-badge {
        background: #db4444;
        color: #fff;
        padding: 1px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    /* ----- Badges ----- */
    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
    }
    .badge-status.active {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .badge-status.stock-in {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.stock-low {
        background: #fff3cd;
        color: #856404;
    }
    .badge-status.stock-out {
        background: #f8d7da;
        color: #721c24;
    }
    .badge-status.featured {
        background: #db4444;
        color: #fff;
    }

    /* ----- Images ----- */
    .product-images {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 4px;
    }
    .product-images .img-wrapper {
        width: 100px;
        height: 100px;
        background: #f5f5f5;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 6px;
        position: relative;
    }
    .product-images .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .product-images .img-wrapper .primary-badge {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        background: #db4444;
        color: #fff;
        font-size: 9px;
        padding: 1px 10px;
        border-radius: 30px;
        font-weight: 600;
        white-space: nowrap;
    }
    .product-images .no-images {
        color: #999;
        font-size: 14px;
        padding: 20px;
        text-align: center;
        width: 100%;
    }
    .product-images .no-images i {
        font-size: 32px;
        display: block;
        margin-bottom: 8px;
    }

    /* ----- Description Box ----- */
    .description-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px 20px;
        line-height: 1.8;
        color: #555;
        font-size: 14px;
        margin-top: 4px;
    }

    /* ----- Responsive ----- */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .detail-card {
            padding: 18px;
        }
        .detail-card .info-row {
            flex-direction: column;
            padding: 10px 0;
        }
        .detail-card .info-row .label {
            width: 100%;
            margin-bottom: 2px;
        }
        .product-images .img-wrapper {
            width: 70px;
            height: 70px;
        }
    }
</style>

<!-- ========================================
     PAGE HEADER
     ======================================== -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-eye"></i> {{ $product->name }}</h4>
        <p>View product details</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
        <a href="{{ route('admin.products.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- ========================================
     PRODUCT DETAILS
     ======================================== -->
<div class="detail-card">
    <div class="row g-4">
        <!-- ========== LEFT COLUMN ========== -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="section-title"><i class="fas fa-info-circle"></i> Basic Information</div>
            
            <div class="info-row">
                <span class="label">Product Name</span>
                <span class="value">{{ $product->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Category</span>
                <span class="value">{{ $product->category->name ?? 'Uncategorized' }}</span>
            </div>
            <div class="info-row">
                <span class="label">SKU</span>
                <span class="value">{{ $product->sku ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Price</span>
                <span class="value">
                    <span class="price">${{ number_format($product->price, 2) }}</span>
                    @if($product->sale_price)
                        <span class="sale-price">${{ number_format($product->price, 2) }}</span>
                        <span class="discount-badge">
                            {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                        </span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">Stock</span>
                <span class="value">
                    @if($product->stock_quantity <= 0)
                        <span class="badge-status stock-out">Out of Stock</span>
                    @elseif($product->stock_quantity <= 5)
                        <span class="badge-status stock-low">{{ $product->stock_quantity }} left</span>
                    @else
                        <span class="badge-status stock-in">{{ $product->stock_quantity }} in stock</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="badge-status {{ $product->is_active ? 'active' : 'inactive' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($product->is_featured)
                        <span class="badge-status featured">Featured</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">Rating</span>
                <span class="value">
                    <span style="color: #ffb800;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->rating ?? 0))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <span style="margin-left: 6px; font-weight: 400;">{{ number_format($product->rating ?? 0, 1) }}</span>
                </span>
            </div>
            <div class="info-row">
                <span class="label">Sold</span>
                <span class="value">{{ number_format($product->sold_count ?? 0) }} orders</span>
            </div>

            <!-- Descriptions -->
            <div class="section-title mt-4"><i class="fas fa-align-left"></i> Descriptions</div>
            
            <div class="info-row">
                <span class="label">Short Description</span>
                <span class="value" style="font-weight: 400; color: #666;">
                    {{ $product->short_description ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="label">Full Description</span>
                <span class="value" style="font-weight: 400; color: #666; display: block; width: 100%;">
                    <div class="description-box">
                        {{ $product->description ?? 'No description available.' }}
                    </div>
                </span>
            </div>
        </div>

        <!-- ========== RIGHT COLUMN ========== -->
        <div class="col-md-4">
            <!-- Images -->
            <div class="section-title"><i class="fas fa-images"></i> Product Images</div>
            <div class="product-images">
                @forelse($product->images as $image)
                    <div class="img-wrapper">
                        <img src="{{ asset($image->image_url) }}" alt="{{ $product->name }}">
                        @if($image->is_primary)
                            <span class="primary-badge">Primary</span>
                        @endif
                    </div>
                @empty
                    <div class="no-images">
                        <i class="fas fa-image"></i>
                        No images uploaded
                    </div>
                @endforelse
            </div>

            <!-- Quick Actions -->
            <div class="section-title mt-4"><i class="fas fa-bolt"></i> Quick Actions</div>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit" style="justify-content: center;">
                    <i class="fas fa-edit"></i> Edit Product
                </a>
                <a href="{{ route('product.detail', $product->slug) }}" target="_blank" class="btn-back" style="justify-content: center; background: #0d6efd; color: #fff;">
                    <i class="fas fa-external-link-alt"></i> View on Store
                </a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" style="justify-content: center; width: 100%;" onclick="return confirm('Are you sure you want to delete this product?')">
                        <i class="fas fa-trash"></i> Delete Product
                    </button>
                </form>
            </div>

            <!-- Product Stats -->
            <div class="section-title mt-4"><i class="fas fa-chart-simple"></i> Product Stats</div>
            <div style="background: #f8f9fa; border-radius: 8px; padding: 16px;">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #8c8c9c; font-size: 13px;">Total Sales</span>
                    <span style="font-weight: 600;">{{ number_format($product->sold_count ?? 0) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #8c8c9c; font-size: 13px;">Total Reviews</span>
                    <span style="font-weight: 600;">{{ $product->reviews->count() ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span style="color: #8c8c9c; font-size: 13px;">Average Rating</span>
                    <span style="font-weight: 600; color: #ffb800;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->rating ?? 0))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        {{ number_format($product->rating ?? 0, 1) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection