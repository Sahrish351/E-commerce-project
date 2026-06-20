@extends('layouts.app')

@section('title', isset($selectedCategory) ? $selectedCategory->name . ' - StyleHub' : 'Shop - StyleHub')

@section('content')
<div class="container py-4">

   
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

   
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center">
                <form action="{{ route('shop.index') }}" method="GET" class="d-flex gap-2 align-items-center">
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
                    <label style="font-size: 14px; color: #666; margin-right: 8px; margin-bottom: 10px;">Sort by:</label>
                    <select name="sort" class="form-select form-select-sm rounded-0" style="border: 1px solid #ddd; width: 180px; margin-bottom: 10px;" onchange="this.form.submit()">
                        <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    
    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start; margin: 0;">
        
        
        <div class="col-lg-3" style="flex: 0 0 25%; max-width: 25%; align-self: flex-start; padding-left: 0; padding-right: 15px;">
           
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px; color: #333;">Categories</h5>
                
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

            
            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <h5 class="fw-bold mb-3" style="font-size: 16px;">Price Range</h5>
                <form action="{{ route('shop.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                    @if(request()->has('category'))
                        <input type="hidden" name="category" value="{{ request()->category }}">
                    @endif
                    <input type="number" name="min_price" class="form-control form-control-sm rounded-0" placeholder="Min" value="{{ request()->min_price }}" style="width: 60px; border: 1px solid #ddd;">
                    <span>—</span>
                    <input type="number" name="max_price" class="form-control form-control-sm rounded-0" placeholder="Max" value="{{ request()->max_price }}" style="width: 60px; border: 1px solid #ddd;">
                    <button type="submit" class="btn btn-danger btn-sm rounded-0 px-3" style="background: #db4444; border: none; margin-left: 10px;">Go</button>
                </form>
            </div>

           
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

            <div class="sidebar-section mb-4" style="border: 1px solid #eee; padding: 20px; background: #fff; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">Brands</h5>
                    <a href="#" class="text-decoration-none text-danger" style="font-size: 13px;">See all</a>
                </div>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Nokia</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Lenovo</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Pocco</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Samsung</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Apple</a></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-9" style="flex: 0 0 75%; max-width: 75%; align-self: flex-start; padding-left: 15px; padding-right: 0;">
            
            
            @if(isset($products) && count($products) > 0)
                @foreach($products as $product)
                <div class="product-card mb-4" style="border: 1px solid #eee; padding: 20px; display: flex; gap: 20px; flex-wrap: wrap; background: #fff; border-radius: 4px; transition: all 0.3s; align-items: flex-start;">
                    
                    <div style="width: 180px; height: 180px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 4px;">
                        @php
                            $image = $product->images->first();
                        @endphp
                        <img src="{{ $image->image_url ?? asset('images/products/default.jpg') }}" 
                             alt="{{ $product->name }}" 
                             style="max-width: 100%; max-height: 180px; object-fit: contain;">
                    </div>
                    
                   
                    <div style="flex: 1; min-width: 200px;">
                        <h5 class="fw-bold" style="font-size: 16px;">{{ $product->name }}</h5>
                    
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
                        
                        
                        <div class="d-flex align-items-center gap-2 mt-1" style="font-size: 13px; flex-wrap: wrap;">
                            <span>
                                @php
                                    $rating = $product->rating ?? 4.5;
                                    $fullStars = (int)floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                @endphp
                                @for($i = 1; $i <= $fullStars; $i++)
                                    <i class="fas fa-star" style="color: #ffb800;"></i>
                                @endfor
                                @if($halfStar)
                                    <i class="fas fa-star-half-alt" style="color: #ffb800;"></i>
                                @endif
                                @for($i = 1; $i <= $emptyStars; $i++)
                                    <i class="far fa-star" style="color: #ddd;"></i>
                                @endfor
                            </span>
                            <span style="font-weight: 600; color: #333;">{{ number_format($product->rating ?? 4.5, 1) }}</span>
                            <span class="text-muted">|</span>
                            <span style="font-weight: 500;">{{ number_format($product->sold_count ?? 0) }} orders</span>
                            <span class="text-muted">|</span>
                            <span style="color: #28a745; font-weight: 500;">Free Shipping</span>
                        </div>
                        
                        
                        <p class="mt-2" style="font-size: 14px; color: #666; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $product->short_description ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua' }}
                        </p>
                        
                       
                        <div class="d-flex gap-2 mt-2 flex-wrap">
                            @if(Route::has('product.detail'))
                                <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" class="btn btn-outline-danger btn-sm rounded-0 px-4" style="border-color: #db4444; color: #db4444;">
                                    View details
                                </a>
                            @else
                                <a href="#" class="btn btn-outline-danger btn-sm rounded-0 px-4" style="border-color: #db4444; color: #db4444;" onclick="alert('Product detail page coming soon!')">
                                    View details
                                </a>
                            @endif
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
                
                <div class="text-center py-5" style="background: #f8f9fa; border-radius: 8px;">
                    <i class="fas fa-box-open" style="font-size: 48px; color: #ddd;"></i>
                    <h4 class="fw-bold mt-3">No Products Found</h4>
                    <p class="text-muted">No products available in this category.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger rounded-0 px-4" style="background: #db4444;">
                        Browse All Products
                    </a>
                </div>
            @endif

           
@if(isset($products) && method_exists($products, 'links') && $products->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
    <div>
        <label style="font-size: 14px; margin-right: 8px;">Show</label>
        <select class="form-select form-select-sm d-inline-block" style="width: 80px; border: 1px solid #ddd; border-radius: 0;" onchange="window.location.href=this.value">
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 5]) }}" {{ request()->per_page == 5 ? 'selected' : '' }}>5</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request()->per_page == 10 ? 'selected' : '' }}>10</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}" {{ request()->per_page == 20 ? 'selected' : '' }}>20</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request()->per_page == 50 ? 'selected' : '' }}>50</option>
        </select>
        <span style="font-size: 14px; color: #666; margin-left: 10px;">
            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} results
        </span>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mb-0" style="gap: 4px;">
           
            @if ($products->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 0; color: #999; border: 1px solid #ddd; padding: 6px 12px;">&lt;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" style="border-radius: 0; color: #333; border: 1px solid #ddd; padding: 6px 12px;">&lt;</a>
                </li>
            @endif

          
            @if($products->lastPage() >= 1)
                <li class="page-item {{ $products->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $products->url(1) }}" style="border-radius: 0; {{ $products->currentPage() == 1 ? 'background: #db4444; border-color: #db4444; color: #fff;' : 'color: #333; border: 1px solid #ddd;' }} padding: 6px 12px;">1</a>
                </li>
            @endif

        
            @if($products->lastPage() >= 2)
                <li class="page-item {{ $products->currentPage() == 2 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $products->url(2) }}" style="border-radius: 0; {{ $products->currentPage() == 2 ? 'background: #db4444; border-color: #db4444; color: #fff;' : 'color: #333; border: 1px solid #ddd;' }} padding: 6px 12px;">2</a>
                </li>
            @endif

            
            @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" style="border-radius: 0; color: #333; border: 1px solid #ddd; padding: 6px 12px;">&gt;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 0; color: #999; border: 1px solid #ddd; padding: 6px 12px;">&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif
        </div>
    </div>
</div>

<style>
   
    .row {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: flex-start !important;
        margin: 0 !important;
    }
    
    .row > .col-lg-3,
    .row > .col-lg-9 {
        align-self: flex-start !important;
    }

    .pagination .page-link {
        border-radius: 0 !important;
        border-color: #ddd;
        color: #333;
        padding: 6px 14px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .pagination .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination .page-item.active .page-link {
        background: #db4444;
        border-color: #db4444;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        color: #999;
        background: #f5f5f5;
        border-color: #ddd;
    }
    .pagination {
        gap: 4px;
    }
    
   
    @media (min-width: 992px) {
        .row > .col-lg-3 {
            flex: 0 0 25% !important;
            max-width: 25% !important;
        }
        .row > .col-lg-9 {
            flex: 0 0 75% !important;
            max-width: 75% !important;
        }
    }
    
   
    @media (max-width: 991px) {
        .row > .col-lg-3,
        .row > .col-lg-9 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
    
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

    
    const sortSelect = document.querySelector('select[name="sort"]');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});
</script>

@endsection