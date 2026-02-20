@extends('layouts.master')

@section('title', $categoryInfo['title'] ?? 'Category - Products')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $categoryInfo['name'] ?? 'Category' }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Category Page Main Content -->
<section class="category-page py-4">
    <div class="container">
        <div class="row">
            <!-- ============================================
                 LEFT SIDEBAR - FILTERS SECTION
                 ============================================ -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <!-- Filter Sidebar -->
                <div class="filter-sidebar">
                    <!-- Filter Header -->
                    <div class="filter-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Filters</h5>
                        <button class="btn btn-link text-decoration-none p-0 clear-all">Clear All</button>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">CATEGORIES</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat1">
                                <label class="form-check-label" for="cat1">
                                    Fashion <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat2">
                                <label class="form-check-label" for="cat2">
                                    Electronics <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat3">
                                <label class="form-check-label" for="cat3">
                                    Home & Kitchen <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat4">
                                <label class="form-check-label" for="cat4">
                                    Books <span class="text-muted">(432)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat5">
                                <label class="form-check-label" for="cat5">
                                    Sports <span class="text-muted">(321)</span>
                                </label>
                            </div>
                            <a href="#" class="view-more-link">+ 5 more</a>
                        </div>
                    </div>
                    
                    <!-- Price Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">PRICE</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price" id="price1">
                                <label class="form-check-label" for="price1">
                                    Under ₹500 <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price" id="price2">
                                <label class="form-check-label" for="price2">
                                    ₹500 - ₹1000 <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price" id="price3">
                                <label class="form-check-label" for="price3">
                                    ₹1000 - ₹5000 <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price" id="price4">
                                <label class="form-check-label" for="price4">
                                    ₹5000 - ₹10000 <span class="text-muted">(432)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price" id="price5">
                                <label class="form-check-label" for="price5">
                                    Over ₹10000 <span class="text-muted">(321)</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Custom Price Range -->
                        <div class="price-range mt-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" placeholder="Min" min="0">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" placeholder="Max" min="0">
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary btn-sm w-100">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Brand Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">BRAND</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand1">
                                <label class="form-check-label" for="brand1">
                                    Nike <span class="text-muted">(245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand2">
                                <label class="form-check-label" for="brand2">
                                    Adidas <span class="text-muted">(193)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand3">
                                <label class="form-check-label" for="brand3">
                                    Puma <span class="text-muted">(167)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand4">
                                <label class="form-check-label" for="brand4">
                                    Levi's <span class="text-muted">(132)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand5">
                                <label class="form-check-label" for="brand5">
                                    Sony <span class="text-muted">(98)</span>
                                </label>
                            </div>
                            <a href="#" class="view-more-link">+ 10 more</a>
                        </div>
                    </div>
                    
                    <!-- Rating Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">CUSTOMER RATINGS</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="rating1">
                                <label class="form-check-label" for="rating1">
                                    4★ & above <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="rating2">
                                <label class="form-check-label" for="rating2">
                                    3★ & above <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="rating3">
                                <label class="form-check-label" for="rating3">
                                    2★ & above <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="rating4">
                                <label class="form-check-label" for="rating4">
                                    1★ & above <span class="text-muted">(432)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Discount Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">DISCOUNT</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="discount1">
                                <label class="form-check-label" for="discount1">
                                    50% or more <span class="text-muted">(445)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="discount2">
                                <label class="form-check-label" for="discount2">
                                    40% or more <span class="text-muted">(693)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="discount3">
                                <label class="form-check-label" for="discount3">
                                    30% or more <span class="text-muted">(867)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="discount4">
                                <label class="form-check-label" for="discount4">
                                    20% or more <span class="text-muted">(932)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="discount5">
                                <label class="form-check-label" for="discount5">
                                    10% or more <span class="text-muted">(1123)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Availability Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">AVAILABILITY</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="avail1" checked>
                                <label class="form-check-label" for="avail1">
                                    Include Out of Stock
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="avail2">
                                <label class="form-check-label" for="avail2">
                                    Ready to Dispatch
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Apply Filters Button (Mobile) -->
                    <div class="apply-filters-mobile d-lg-none">
                        <button class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 RIGHT SIDE - PRODUCTS GRID SECTION
                 ============================================ -->
            <div class="col-lg-9">
                <!-- Page Header -->
                <div class="category-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">{{ $categoryInfo['title'] ?? 'Category' }} ({{ number_format($categoryInfo['products_count'] ?? 0) }} Products)</h4>
                    
                    <!-- Sort By Dropdown -->
                    <div class="sort-by d-flex align-items-center">
                        <span class="text-muted me-2 d-none d-sm-inline">Sort by:</span>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Popularity</option>
                            <option>Price - Low to High</option>
                            <option>Price - High to Low</option>
                            <option>Newest First</option>
                            <option>Discount</option>
                            <option>Customer Rating</option>
                        </select>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="products-grid">
                    <div class="row g-3">
                        @forelse($products as $product)
                        <!-- Product -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="modern-product-card">
                                @if(isset($product['badge']))
                                <div class="product-badge 
                                    @if($product['badge'] == 'TRENDING') trending 
                                    @elseif($product['badge'] == 'NEW') new 
                                    @else bestseller @endif">
                                    {{ $product['badge'] }}
                                </div>
                                @endif
                                <div class="product-image">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                    <div class="product-actions">
                                        <button class="action-btn wishlist" title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn quick-view" title="Quick View">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="brand-name">{{ $product['brand'] }}</div>
                                    <a href="{{ route('product.detail', ['id' => $product['id'], 'slug' => $product['slug'] ?? Str::slug($product['name'])]) }}" class="text-decoration-none">
                                        <h3 class="product-title">{{ $product['name'] }}</h3>
                                    </a>
                                    <div class="price-section">
                                        <span class="current-price">₹{{ number_format($product['price']) }}</span>
                                        <span class="original-price">₹{{ number_format($product['original_price']) }}</span>
                                        <span class="discount">{{ $product['discount'] }}% off</span>
                                    </div>
                                    <div class="product-rating mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product['rating']))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i == ceil($product['rating']) && $product['rating'] - floor($product['rating']) >= 0.5)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="rating-count">({{ number_format($product['reviews']) }})</span>
                                    </div>
                                    <button class="add-to-cart-btn mt-3" data-id="{{ $product['id'] }}">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No products found in this category.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-section mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">10</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ============================================
   FILTER SIDEBAR STYLES
   ============================================ */
.filter-sidebar {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
    scrollbar-width: thin;
}

.filter-sidebar::-webkit-scrollbar {
    width: 5px;
}

.filter-sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.filter-sidebar::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.filter-header {
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.clear-all {
    color: #febd69;
    font-size: 13px;
    font-weight: 500;
}

.clear-all:hover {
    color: #f3a847;
}

.filter-section {
    border-bottom: 1px solid #eaeaea;
    padding: 15px 0;
}

.filter-section:last-child {
    border-bottom: none;
}

.filter-title {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
}

.filter-options {
    max-height: 200px;
    overflow-y: auto;
    scrollbar-width: thin;
}

.filter-options::-webkit-scrollbar {
    width: 3px;
}

.filter-options::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.filter-options::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.filter-options .form-check {
    margin-bottom: 8px;
}

.filter-options .form-check-label {
    font-size: 13px;
    color: #555;
    cursor: pointer;
}

.filter-options .form-check-input {
    cursor: pointer;
    margin-top: 0.15em;
}

.filter-options .form-check-input:checked {
    background-color: #febd69;
    border-color: #febd69;
}

.view-more-link {
    font-size: 12px;
    color: #febd69;
    text-decoration: none;
    display: inline-block;
    margin-top: 5px;
}

.view-more-link:hover {
    color: #f3a847;
    text-decoration: underline;
}

/* Price Range Inputs */
.price-range .form-control-sm {
    font-size: 12px;
    padding: 0.4rem 0.5rem;
}

.price-range .btn-sm {
    font-size: 12px;
    padding: 0.4rem;
    background-color: #febd69;
    border-color: #febd69;
    color: #131921;
    font-weight: 600;
}

.price-range .btn-sm:hover {
    background-color: #f3a847;
    border-color: #f3a847;
}

/* ============================================
   CATEGORY HEADER STYLES
   ============================================ */
.category-header {
    background: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.category-header h4 {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.sort-by .form-select-sm {
    border-radius: 4px;
    border: 1px solid #ddd;
    font-size: 13px;
    padding: 0.4rem 2rem 0.4rem 0.8rem;
    cursor: pointer;
}

.sort-by .form-select-sm:focus {
    border-color: #febd69;
    box-shadow: 0 0 0 0.2rem rgba(254,189,105,0.25);
}

/* ============================================
   PRODUCT GRID STYLES
   ============================================ */
.products-grid {
    margin-top: 20px;
}

/* Product Card */
.modern-product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    border: 1px solid #f0f0f0;
}

.modern-product-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transform: translateY(-3px);
    border-color: #febd69;
}

/* Product Badge */
.modern-product-card .product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff4d4d;
    color: white;
    padding: 3px 8px;
    font-size: 10px;
    font-weight: 700;
    border-radius: 3px;
    z-index: 2;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.modern-product-card .product-badge.trending {
    background: #ff8c42;
}

.modern-product-card .product-badge.new {
    background: #4caf50;
}

/* Product Image */
.modern-product-card .product-image {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    background: #fafafa;
}

.modern-product-card .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.modern-product-card:hover .product-image img {
    transform: scale(1.05);
}

/* Product Actions */
.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    z-index: 2;
}

.modern-product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: #febd69;
    color: #131921;
    transform: scale(1.1);
}

/* Product Info */
.modern-product-card .product-info {
    padding: 12px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.brand-name {
    font-size: 12px;
    font-weight: 600;
    color: #666;
    margin-bottom: 4px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.modern-product-card .product-title {
    font-size: 14px;
    font-weight: 500;
    line-height: 1.3;
    margin-bottom: 6px;
    color: #333;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 36px;
    text-decoration: none;
    transition: color 0.2s ease;
}

.modern-product-card .product-title:hover {
    color: #febd69;
}

/* Price Section */
.price-section {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 5px;
    margin-bottom: 4px;
}

.current-price {
    font-size: 16px;
    font-weight: 700;
    color: #333;
}

.original-price {
    font-size: 12px;
    color: #999;
    text-decoration: line-through;
}

.discount {
    font-size: 12px;
    color: #ff4d4d;
    font-weight: 600;
    background: #ffe6e6;
    padding: 2px 4px;
    border-radius: 3px;
}

/* Rating */
.product-rating {
    font-size: 12px;
    margin-bottom: 8px;
}

.product-rating i {
    font-size: 11px;
}

.rating-count {
    color: #666;
    margin-left: 4px;
    font-size: 11px;
}

/* Add to Cart Button */
.modern-product-card .add-to-cart-btn {
    width: 100%;
    background: transparent;
    border: 2px solid #333;
    color: #333;
    padding: 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: auto;
}

.modern-product-card .add-to-cart-btn i {
    font-size: 14px;
}

.modern-product-card .add-to-cart-btn:hover {
    background: #333;
    color: white;
    border-color: #333;
}

/* ============================================
   PAGINATION STYLES
   ============================================ */
.pagination-section {
    margin-top: 40px;
}

.pagination {
    gap: 5px;
}

.page-link {
    color: #333;
    border-radius: 4px;
    padding: 0.5rem 0.8rem;
    font-size: 13px;
    border: 1px solid #ddd;
}

.page-link:hover {
    background-color: #febd69;
    border-color: #febd69;
    color: #131921;
}

.page-item.active .page-link {
    background-color: #febd69;
    border-color: #febd69;
    color: #131921;
    font-weight: 600;
}

.page-item.disabled .page-link {
    color: #999;
    background-color: #f5f5f5;
    border-color: #ddd;
}

/* ============================================
   RESPONSIVE STYLES
   ============================================ */
@media (max-width: 992px) {
    .filter-sidebar {
        position: static;
        max-height: none;
        margin-bottom: 20px;
    }
    
    .apply-filters-mobile {
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    .category-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }
    
    .sort-by {
        width: 100%;
    }
    
    .sort-by select {
        width: 100% !important;
    }
    
    .modern-product-card .product-title {
        font-size: 13px;
        height: 34px;
    }
    
    .current-price {
        font-size: 15px;
    }
    
    .brand-name {
        font-size: 11px;
    }
}

@media (max-width: 576px) {
    .filter-sidebar {
        padding: 15px;
    }
    
    .filter-title {
        font-size: 13px;
    }
    
    .filter-options .form-check-label {
        font-size: 12px;
    }
    
    .products-grid .row {
        margin: 0 -5px;
    }
    
    .products-grid [class*="col-"] {
        padding: 0 5px;
    }
    
    .modern-product-card .product-info {
        padding: 8px;
    }
    
    .modern-product-card .add-to-cart-btn {
        padding: 6px;
        font-size: 11px;
    }
}
</style>
@endpush