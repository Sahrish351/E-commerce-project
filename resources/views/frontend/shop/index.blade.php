@extends('layouts.app')

@section('title', isset($selectedCategory) ? $selectedCategory->name . ' - StyleHub' : 'Shop - StyleHub')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">Home</a></li>
                    @if(isset($selectedCategory))
                        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-dark">Shop</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">{{ $selectedCategory->name }}</li>
                    @else
                        <li class="breadcrumb-item active text-dark" aria-current="page">Shop</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold" style="font-size: 28px;">
                @if(isset($selectedCategory))
                    {{ $selectedCategory->name }}
                @else
                    All Products
                @endif
            </h1>
            <p class="text-muted">
                @if(isset($selectedCategory))
                    {{ $selectedCategory->description ?? 'Browse our collection of ' . $selectedCategory->name }}
                @else
                    Browse our collection of premium products
                @endif
            </p>
        </div>
    </div>

    <div class="row">
        <!-- ==================== SIDEBAR (LEFT) ==================== -->
        <div class="col-lg-3">
            <!-- Categories -->
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px; color: #333;">Categories</h5>
                
                <!-- All Products -->
                <a href="{{ route('shop.index') }}" 
                   class="d-flex justify-content-between align-items-center text-decoration-none py-2 px-2 mb-1" 
                   style="color: {{ !isset($selectedCategory) ? '#db4444' : '#333' }}; background: {{ !isset($selectedCategory) ? '#fef0f0' : 'transparent' }}; border-radius: 4px; font-weight: {{ !isset($selectedCategory) ? '600' : '400' }};">
                    <span>📦 All Products</span>
                    <span style="font-size: 12px; color: #999;">{{ $products->total() ?? 0 }}</span>
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                       class="d-flex justify-content-between align-items-center text-decoration-none py-2 px-2 mb-1" 
                       style="color: {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? '#db4444' : '#333' }}; background: {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? '#fef0f0' : 'transparent' }}; border-radius: 4px; font-weight: {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? '600' : '400' }};">
                        <span>
                            @if(str_contains(strtolower($category->name), 'mobile') && !str_contains(strtolower($category->name), 'charger'))
                                📱
                            @elseif(str_contains(strtolower($category->name), 'watch'))
                                ⌚
                            @elseif(str_contains(strtolower($category->name), 'bluetooth'))
                                🔊
                            @elseif(str_contains(strtolower($category->name), 'shoe'))
                                👟
                            @elseif(str_contains(strtolower($category->name), 'glass'))
                                👓
                            @elseif(str_contains(strtolower($category->name), 'charger'))
                                🔋
                            @elseif(str_contains(strtolower($category->name), 'electronic'))
                                💻
                            @elseif(str_contains(strtolower($category->name), 'smartphone'))
                                📱
                            @elseif(str_contains(strtolower($category->name), 'accessorie'))
                                🎧
                            @elseif(str_contains(strtolower($category->name), 'wearable'))
                                ⌚
                            @else
                                🏷️
                            @endif
                            {{ $category->name }}
                        </span>
                        <span style="font-size: 12px; color: #999;">{{ $category->products_count }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Price Range -->
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px;">Price Range</h5>
                <form action="{{ route('shop.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                    @if(request()->has('category'))
                        <input type="hidden" name="category" value="{{ request()->category }}">
                    @endif
                    <input type="number" name="min_price" class="form-control form-control-sm rounded-0" placeholder="Min" value="{{ request()->min_price }}" style="width: 80px; border: 1px solid #ddd;">
                    <span>—</span>
                    <input type="number" name="max_price" class="form-control form-control-sm rounded-0" placeholder="Max" value="{{ request()->max_price }}" style="width: 80px; border: 1px solid #ddd;">
                    <button type="submit" class="btn btn-danger btn-sm rounded-0 px-3" style="background: #db4444; border: none;">Go</button>
                </form>
            </div>

            <!-- Condition -->
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px;">Condition</h5>
                <div class="form-check">
                    <input type="radio" name="condition" class="form-check-input" id="any" checked>
                    <label for="any" class="form-check-label" style="font-size: 14px;">Any</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="condition" class="form-check-input" id="refurbished">
                    <label for="refurbished" class="form-check-label" style="font-size: 14px;">Refurbished</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="condition" class="form-check-input" id="brandNew">
                    <label for="brandNew" class="form-check-label" style="font-size: 14px;">Brand new</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="condition" class="form-check-input" id="oldItems">
                    <label for="oldItems" class="form-check-label" style="font-size: 14px;">Old items</label>
                </div>
            </div>

            <!-- Ratings -->
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px;">Ratings</h5>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rating5">
                    <label for="rating5" class="form-check-label" style="font-size: 14px;">
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rating4">
                    <label for="rating4" class="form-check-label" style="font-size: 14px;">
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rating3">
                    <label for="rating3" class="form-check-label" style="font-size: 14px;">
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rating2">
                    <label for="rating2" class="form-check-label" style="font-size: 14px;">
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="fas fa-star" style="color: #ffb800;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                        <i class="far fa-star" style="color: #ddd;"></i>
                    </label>
                </div>
            </div>

            <!-- Brands -->
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">Brands</h5>
                    <a href="#" class="text-decoration-none text-danger" style="font-size: 13px;">See all</a>
                </div>
                <ul class="list-unstyled" style="font-size: 14px;">
                    @foreach($brands ?? [] as $brand)
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">{{ $brand }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- ==================== PRODUCTS (RIGHT) ==================== -->
        <div class="col-lg-9">
            <!-- Category Banner (if selected) -->
            @if(isset($selectedCategory) && $selectedCategory->image_url)
            <div class="category-banner mb-4" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 20px; border-left: 4px solid #db4444;">
                <img src="{{ asset('storage/' . $selectedCategory->image_url) }}" alt="{{ $selectedCategory->name }}" style="width: 80px; height: 80px; object-fit: contain;">
                <div>
                    <h4 class="fw-bold mb-0">{{ $selectedCategory->name }}</h4>
                    <p class="text-muted mb-0">{{ $selectedCategory->products_count }} products available</p>
                </div>
            </div>
            @endif

            <!-- Sort Options -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <span style="font-size: 14px; color: #666;">Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} products</span>
                </div>
                <div>
                    <form action="{{ route('shop.index') }}" method="GET" class="d-flex gap-2">
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request()->category }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request()->search }}">
                        @endif
                        @if(request()->has('min_price'))
                            <input type="hidden" name="min_price" value="{{ request()->min_price }}">
                        @endif
                        @if(request()->has('max_price'))
                            <input type="hidden" name="max_price" value="{{ request()->max_price }}">
                        @endif
                        <select name="sort" class="form-select form-select-sm rounded-0" style="border: 1px solid #ddd; width: 180px;" onchange="this.form.submit()">
                            <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request()->sort == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            @if(isset($products) && count($products) > 0)
                @foreach($products as $product)
                <div class="product-card mb-4" style="border: 1px solid #eee; padding: 20px; display: flex; gap: 20px; flex-wrap: wrap; background: #fff; border-radius: 4px; transition: all 0.3s;">
                    <!-- Product Image -->
                    <div style="width: 180px; height: 180px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 4px;">
                        @php
                            $image = $product->images->first();
                            $imageName = $image ? $image->image_url : 'default.jpg';
                        @endphp
                        <img src="{{ asset('images/products/' . $imageName) }}" 
                             alt="{{ $product->name }}" 
                             style="max-width: 100%; max-height: 180px; object-fit: contain;">
                    </div>
                    
                    <!-- Product Details -->
                    <div style="flex: 1;">
                        <h5 class="fw-bold" style="font-size: 16px;">{{ $product->name }}</h5>
                        
                        <!-- Price -->
                        <div class="d-flex align-items-center gap-3 mt-1">
                            <span class="fw-bold" style="color: #db4444; font-size: 20px;">
                                ${{ number_format($product->sale_price ?? $product->price, 2) }}
                            </span>
                            @if($product->sale_price && $product->price > $product->sale_price)
                            <span style="text-decoration: line-through; color: #999; font-size: 16px;">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            @endif
                        </div>
                        
                        <!-- Rating & Orders -->
                        <div class="d-flex align-items-center gap-2 mt-1" style="font-size: 13px; flex-wrap: wrap;">
                            <span>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->rating ?? 4))
                                        <i class="fas fa-star" style="color: #ffb800;"></i>
                                    @elseif($i - 0.5 <= ($product->rating ?? 4))
                                        <i class="fas fa-star-half-alt" style="color: #ffb800;"></i>
                                    @else
                                        <i class="far fa-star" style="color: #ddd;"></i>
                                    @endif
                                @endfor
                            </span>
                            <span>{{ number_format($product->rating ?? 4.5, 1) }}</span>
                            <span class="text-muted">|</span>
                            <span>{{ $product->sold_count ?? 0 }} orders</span>
                            <span class="text-muted">|</span>
                            <span style="color: #28a745;">Free Shipping</span>
                        </div>
                        
                        <!-- Description -->
                        <p class="mt-2" style="font-size: 14px; color: #666; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $product->short_description ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua' }}
                        </p>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2 mt-2 flex-wrap">
                            <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" class="btn btn-outline-danger btn-sm rounded-0 px-4" style="border-color: #db4444; color: #db4444;">
                                View details
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-dark btn-sm rounded-0 px-3" style="background: #000; border: none;">
                                    <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="text-center py-5" style="background: #f8f9fa; border-radius: 8px;">
                    <i class="fas fa-box-open" style="font-size: 48px; color: #ddd;"></i>
                    <h4 class="fw-bold mt-3">No Products Found</h4>
                    <p class="text-muted">No products available in this category.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-0 px-4" style="background: #db4444;">
                        Browse All Products
                    </a>
                </div>
            @endif

            <!-- ==================== PAGINATION ==================== -->
            @if(isset($products) && method_exists($products, 'links') && $products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                <div>
                    <label style="font-size: 14px; margin-right: 8px;">Show</label>
                    <select class="form-select form-select-sm d-inline-block" style="width: 80px; border: 1px solid #ddd; border-radius: 0;" onchange="window.location.href=this.value">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request()->per_page == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}" {{ request()->per_page == 20 ? 'selected' : '' }}>20</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request()->per_page == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
                <nav aria-label="Page navigation">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .sidebar-section {
        border-radius: 4px;
        transition: all 0.3s;
    }
    .sidebar-section:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .sidebar-section .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }
    .sidebar-section .form-check-input:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }
    .product-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .btn-outline-danger:hover {
        background: #db4444;
        color: #fff !important;
    }
    .btn-dark:hover {
        background: #db4444 !important;
    }
    .pagination .page-link {
        border-radius: 0 !important;
        border-color: #ddd;
    }
    .pagination .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination .page-item.active .page-link {
        background: #db4444;
        border-color: #db4444;
    }
    .breadcrumb-item a:hover {
        color: #db4444 !important;
    }
    .breadcrumb-item.active {
        color: #db4444;
    }
    @media (max-width: 768px) {
        .product-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .product-card > div:first-child {
            width: 100% !important;
            height: 200px !important;
        }
        .product-card .d-flex {
            justify-content: center;
        }
        .sidebar-section {
            padding: 15px !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category click highlight
    const categoryLinks = document.querySelectorAll('.sidebar-section a[href*="category"]');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            categoryLinks.forEach(l => {
                l.style.color = '#333';
                l.style.background = 'transparent';
                l.style.fontWeight = '400';
            });
            this.style.color = '#db4444';
            this.style.background = '#fef0f0';
            this.style.fontWeight = '600';
        });
    });

    // Sort dropdown auto-submit
    const sortSelect = document.querySelector('select[name="sort"]');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});
</script>

@endsection