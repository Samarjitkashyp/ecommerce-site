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
                        <button class="btn btn-link text-decoration-none p-0 clear-all" id="clearAllFilters">Clear All</button>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">CATEGORIES</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="cat1" data-filter="category" data-value="fashion">
                                <label class="form-check-label" for="cat1">
                                    Fashion <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="cat2" data-filter="category" data-value="electronics">
                                <label class="form-check-label" for="cat2">
                                    Electronics <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="cat3" data-filter="category" data-value="home-kitchen">
                                <label class="form-check-label" for="cat3">
                                    Home & Kitchen <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="cat4" data-filter="category" data-value="books">
                                <label class="form-check-label" for="cat4">
                                    Books <span class="text-muted">(432)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="cat5" data-filter="category" data-value="sports">
                                <label class="form-check-label" for="cat5">
                                    Sports <span class="text-muted">(321)</span>
                                </label>
                            </div>
                            <a href="#" class="view-more-link" id="viewMoreCategories">+ 5 more</a>
                        </div>
                    </div>
                    
                    <!-- Price Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">PRICE</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price1" data-filter="price" data-value="under-500">
                                <label class="form-check-label" for="price1">
                                    Under ₹500 <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price2" data-filter="price" data-value="500-1000">
                                <label class="form-check-label" for="price2">
                                    ₹500 - ₹1000 <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price3" data-filter="price" data-value="1000-5000">
                                <label class="form-check-label" for="price3">
                                    ₹1000 - ₹5000 <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price4" data-filter="price" data-value="5000-10000">
                                <label class="form-check-label" for="price4">
                                    ₹5000 - ₹10000 <span class="text-muted">(432)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price5" data-filter="price" data-value="over-10000">
                                <label class="form-check-label" for="price5">
                                    Over ₹10000 <span class="text-muted">(321)</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Custom Price Range -->
                        <div class="price-range mt-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="minPrice" placeholder="Min" min="0">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="maxPrice" placeholder="Max" min="0">
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary btn-sm w-100" id="applyPriceRange">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Brand Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">BRAND</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="brand1" data-filter="brand" data-value="nike">
                                <label class="form-check-label" for="brand1">
                                    Nike <span class="text-muted">(245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="brand2" data-filter="brand" data-value="adidas">
                                <label class="form-check-label" for="brand2">
                                    Adidas <span class="text-muted">(193)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="brand3" data-filter="brand" data-value="puma">
                                <label class="form-check-label" for="brand3">
                                    Puma <span class="text-muted">(167)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="brand4" data-filter="brand" data-value="levis">
                                <label class="form-check-label" for="brand4">
                                    Levi's <span class="text-muted">(132)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="brand5" data-filter="brand" data-value="sony">
                                <label class="form-check-label" for="brand5">
                                    Sony <span class="text-muted">(98)</span>
                                </label>
                            </div>
                            <a href="#" class="view-more-link" id="viewMoreBrands">+ 10 more</a>
                        </div>
                    </div>
                    
                    <!-- Rating Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">CUSTOMER RATINGS</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating1" data-filter="rating" data-value="4">
                                <label class="form-check-label" for="rating1">
                                    4★ & above <span class="text-muted">(1245)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating2" data-filter="rating" data-value="3">
                                <label class="form-check-label" for="rating2">
                                    3★ & above <span class="text-muted">(893)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating3" data-filter="rating" data-value="2">
                                <label class="form-check-label" for="rating3">
                                    2★ & above <span class="text-muted">(567)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating4" data-filter="rating" data-value="1">
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
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount1" data-filter="discount" data-value="50">
                                <label class="form-check-label" for="discount1">
                                    50% or more <span class="text-muted">(445)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount2" data-filter="discount" data-value="40">
                                <label class="form-check-label" for="discount2">
                                    40% or more <span class="text-muted">(693)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount3" data-filter="discount" data-value="30">
                                <label class="form-check-label" for="discount3">
                                    30% or more <span class="text-muted">(867)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount4" data-filter="discount" data-value="20">
                                <label class="form-check-label" for="discount4">
                                    20% or more <span class="text-muted">(932)</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount5" data-filter="discount" data-value="10">
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
                                <input class="form-check-input filter-checkbox" type="checkbox" id="avail1" data-filter="availability" data-value="out-of-stock" checked>
                                <label class="form-check-label" for="avail1">
                                    Include Out of Stock
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="avail2" data-filter="availability" data-value="ready-to-dispatch">
                                <label class="form-check-label" for="avail2">
                                    Ready to Dispatch
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Apply Filters Button (Mobile) -->
                    <div class="apply-filters-mobile d-lg-none">
                        <button class="btn btn-primary w-100" id="applyMobileFilters">Apply Filters</button>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 RIGHT SIDE - PRODUCTS GRID SECTION
                 ============================================ -->
            <div class="col-lg-9">
                <!-- Page Header -->
                <div class="category-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0" id="categoryTitle">{{ $categoryInfo['title'] ?? 'Category' }} (<span id="productCount">{{ number_format($categoryInfo['products_count'] ?? 0) }}</span> Products)</h4>
                    
                    <!-- Sort By Dropdown -->
                    <div class="sort-by d-flex align-items-center">
                        <span class="text-muted me-2 d-none d-sm-inline">Sort by:</span>
                        <select class="form-select form-select-sm" id="sortBy" style="width: auto;">
                            <option value="popularity" selected>Popularity</option>
                            <option value="price-low">Price - Low to High</option>
                            <option value="price-high">Price - High to Low</option>
                            <option value="newest">Newest First</option>
                            <option value="discount">Discount</option>
                            <option value="rating">Customer Rating</option>
                        </select>
                    </div>
                </div>
                
                <!-- Active Filters -->
                <div class="active-filters mb-3" id="activeFilters" style="display: none;">
                    <span class="me-2">Active Filters:</span>
                    <div class="d-inline-flex flex-wrap gap-2" id="filterTags"></div>
                </div>
                
                <!-- Products Grid -->
                <div class="products-grid" id="productsGrid">
                    <div class="row g-3" id="productsContainer">
                        @forelse($products as $product)
                        <!-- Product -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 product-item" data-id="{{ $product['id'] }}">
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
                                        <button class="action-btn wishlist-btn" title="Add to Wishlist" data-id="{{ $product['id'] }}">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn quick-view-btn" title="Quick View" data-id="{{ $product['id'] }}">
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
                                    <button class="add-to-cart-btn mt-3" 
                                            data-id="{{ $product['id'] }}"
                                            data-name="{{ $product['name'] }}"
                                            data-brand="{{ $product['brand'] }}"
                                            data-price="{{ $product['price'] }}"
                                            data-image="{{ $product['image'] }}">
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
                        <ul class="pagination justify-content-center" id="pagination">
                            <li class="page-item disabled" id="prevPage">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#" data-page="1">1</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="3">3</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="4">4</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="5">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-page="10">10</a></li>
                            <li class="page-item" id="nextPage">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewModalLabel">Quick View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    cursor: pointer;
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
    cursor: pointer;
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

/* Active Filters */
.active-filters {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 13px;
}

.filter-tag {
    background: #e9ecef;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
}

.filter-tag .remove-filter {
    color: #666;
    cursor: pointer;
    font-size: 12px;
}

.filter-tag .remove-filter:hover {
    color: #dc3545;
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

.action-btn.active i {
    color: #ff4d4d;
    font-weight: 900;
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

.modern-product-card .add-to-cart-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
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
    cursor: pointer;
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
    cursor: not-allowed;
}

/* Quick View Modal */
.modal-content {
    border: none;
    border-radius: 12px;
}

.modal-header {
    border-bottom: 1px solid #f0f0f0;
    padding: 15px 20px;
}

.modal-body {
    padding: 20px;
}

/* Loading Spinner */
.spinner-border {
    width: 3rem;
    height: 3rem;
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

@push('scripts')
<script>
$(document).ready(function() {
    'use strict';
    
    // ============================================
    // FILTER FUNCTIONALITY
    // ============================================
    
    // Store active filters
    let activeFilters = {
        category: [],
        price: null,
        brand: [],
        rating: [],
        discount: [],
        availability: []
    };
    
    // Current sort option
    let currentSort = 'popularity';
    
    // Current page
    let currentPage = 1;
    let totalPages = 10;
    
    // Update filter tags display
    function updateFilterTags() {
        let tagsHtml = '';
        let filterCount = 0;
        
        // Category filters
        activeFilters.category.forEach(value => {
            let label = $(`input[data-filter="category"][data-value="${value}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="category" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        // Price filter
        if (activeFilters.price) {
            let label = $(`input[data-filter="price"][data-value="${activeFilters.price}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="price" data-value="${activeFilters.price}"></i></span>`;
            filterCount++;
        }
        
        // Brand filters
        activeFilters.brand.forEach(value => {
            let label = $(`input[data-filter="brand"][data-value="${value}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="brand" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        // Rating filters
        activeFilters.rating.forEach(value => {
            let label = $(`input[data-filter="rating"][data-value="${value}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="rating" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        // Discount filters
        activeFilters.discount.forEach(value => {
            let label = $(`input[data-filter="discount"][data-value="${value}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="discount" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        // Availability filters
        activeFilters.availability.forEach(value => {
            let label = $(`input[data-filter="availability"][data-value="${value}"]`).next('label').text().split(' ')[0];
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="availability" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        if (filterCount > 0) {
            $('#filterTags').html(tagsHtml);
            $('#activeFilters').show();
        } else {
            $('#activeFilters').hide();
        }
    }
    
    // Apply filters (simulated - in real app would make AJAX call)
    function applyFilters() {
        console.log('Applying filters:', activeFilters);
        console.log('Sort by:', currentSort);
        console.log('Page:', currentPage);
        
        // Show loading state
        $('#productsContainer').html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Applying filters...</p>
            </div>
        `);
        
        // Simulate AJAX call
        setTimeout(function() {
            // In real app, you would reload products here
            // For demo, just show message
            $('#productsContainer').html(`
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Filters applied! In a real application, products would be filtered here.
                    </div>
                </div>
            `);
        }, 1000);
        
        updateFilterTags();
    }
    
    // Handle checkbox filters
    $('.filter-checkbox').on('change', function() {
        let filterType = $(this).data('filter');
        let filterValue = $(this).data('value');
        let isChecked = $(this).is(':checked');
        
        if (isChecked) {
            if (filterType === 'category') {
                activeFilters.category.push(filterValue);
            } else if (filterType === 'brand') {
                activeFilters.brand.push(filterValue);
            } else if (filterType === 'rating') {
                activeFilters.rating.push(filterValue);
            } else if (filterType === 'discount') {
                activeFilters.discount.push(filterValue);
            } else if (filterType === 'availability') {
                activeFilters.availability.push(filterValue);
            }
        } else {
            if (filterType === 'category') {
                activeFilters.category = activeFilters.category.filter(v => v !== filterValue);
            } else if (filterType === 'brand') {
                activeFilters.brand = activeFilters.brand.filter(v => v !== filterValue);
            } else if (filterType === 'rating') {
                activeFilters.rating = activeFilters.rating.filter(v => v !== filterValue);
            } else if (filterType === 'discount') {
                activeFilters.discount = activeFilters.discount.filter(v => v !== filterValue);
            } else if (filterType === 'availability') {
                activeFilters.availability = activeFilters.availability.filter(v => v !== filterValue);
            }
        }
        
        applyFilters();
    });
    
    // Handle radio filters (price)
    $('.filter-radio').on('change', function() {
        if ($(this).is(':checked')) {
            activeFilters.price = $(this).data('value');
        } else {
            activeFilters.price = null;
        }
        applyFilters();
    });
    
    // Handle custom price range
    $('#applyPriceRange').on('click', function() {
        let min = $('#minPrice').val();
        let max = $('#maxPrice').val();
        
        if (min || max) {
            activeFilters.price = `custom-${min}-${max}`;
            applyFilters();
        }
    });
    
    // Remove individual filter
    $(document).on('click', '.remove-filter', function() {
        let filterType = $(this).data('filter');
        let filterValue = $(this).data('value');
        
        // Uncheck corresponding checkbox
        if (filterType === 'price') {
            $(`input[data-filter="price"][data-value="${filterValue}"]`).prop('checked', false);
            activeFilters.price = null;
        } else {
            $(`input[data-filter="${filterType}"][data-value="${filterValue}"]`).prop('checked', false);
            
            if (filterType === 'category') {
                activeFilters.category = activeFilters.category.filter(v => v !== filterValue);
            } else if (filterType === 'brand') {
                activeFilters.brand = activeFilters.brand.filter(v => v !== filterValue);
            } else if (filterType === 'rating') {
                activeFilters.rating = activeFilters.rating.filter(v => v !== filterValue);
            } else if (filterType === 'discount') {
                activeFilters.discount = activeFilters.discount.filter(v => v !== filterValue);
            } else if (filterType === 'availability') {
                activeFilters.availability = activeFilters.availability.filter(v => v !== filterValue);
            }
        }
        
        applyFilters();
    });
    
    // Clear all filters
    $('#clearAllFilters').on('click', function() {
        $('.filter-checkbox').prop('checked', false);
        $('.filter-radio').prop('checked', false);
        $('#minPrice, #maxPrice').val('');
        
        activeFilters = {
            category: [],
            price: null,
            brand: [],
            rating: [],
            discount: [],
            availability: []
        };
        
        applyFilters();
    });
    
    // View more categories
    $('#viewMoreCategories').on('click', function(e) {
        e.preventDefault();
        // In real app, load more categories
        alert('Load more categories');
    });
    
    // View more brands
    $('#viewMoreBrands').on('click', function(e) {
        e.preventDefault();
        // In real app, load more brands
        alert('Load more brands');
    });
    
    // Mobile apply filters
    $('#applyMobileFilters').on('click', function() {
        applyFilters();
    });
    
    // ============================================
    // SORT FUNCTIONALITY
    // ============================================
    $('#sortBy').on('change', function() {
        currentSort = $(this).val();
        console.log('Sort changed to:', currentSort);
        applyFilters();
    });
    
    // ============================================
    // PAGINATION FUNCTIONALITY
    // ============================================
    $('.page-link[data-page]').on('click', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        
        if (page && page !== currentPage) {
            currentPage = page;
            
            // Update active state
            $('.page-item').removeClass('active');
            $(this).parent().addClass('active');
            
            // Update prev/next buttons
            if (currentPage === 1) {
                $('#prevPage').addClass('disabled');
            } else {
                $('#prevPage').removeClass('disabled');
            }
            
            if (currentPage === totalPages) {
                $('#nextPage').addClass('disabled');
            } else {
                $('#nextPage').removeClass('disabled');
            }
            
            applyFilters();
        }
    });
    
    $('#prevPage a').on('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            $(`.page-link[data-page="${currentPage}"]`).trigger('click');
        }
    });
    
    $('#nextPage a').on('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            $(`.page-link[data-page="${currentPage}"]`).trigger('click');
        }
    });
    
    // ============================================
    // ADD TO CART FUNCTIONALITY - FIXED
    // ============================================
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let id = btn.data('id');
        let name = btn.data('name');
        let brand = btn.data('brand');
        let price = btn.data('price');
        let image = btn.data('image');
        
        console.log('Adding to cart from category:', {id, name, brand, price, image});
        
        // Button animation
        let originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            type: 'POST',
            data: {
                id: id,
                name: name,
                brand: brand,
                price: price,
                image: image,
                quantity: 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Add to cart success:', response);
                
                if (response.success) {
                    // Update cart count
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    // Show success message
                    showNotification(response.message, 'success');
                    
                    // Redirect to cart page after short delay
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Add to cart error:', error);
                console.error('Response:', xhr.responseText);
                
                btn.html(originalText);
                btn.prop('disabled', false);
                
                let errorMessage = 'Error adding to cart';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // ============================================
    // WISHLIST FUNCTIONALITY
    // ============================================
    $('.wishlist-btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let icon = btn.find('i');
        
        if (icon.hasClass('far')) {
            icon.removeClass('far').addClass('fas');
            btn.addClass('active');
            showNotification('Added to wishlist!', 'success');
            
            // Here you would typically save to database/localStorage
            saveToWishlist(btn.data('id'));
        } else {
            icon.removeClass('fas').addClass('far');
            btn.removeClass('active');
            showNotification('Removed from wishlist', 'info');
            
            // Remove from wishlist
            removeFromWishlist(btn.data('id'));
        }
    });
    
    // Wishlist functions (using localStorage)
    function saveToWishlist(productId) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        if (!wishlist.includes(productId)) {
            wishlist.push(productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
        }
    }
    
    function removeFromWishlist(productId) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        wishlist = wishlist.filter(id => id != productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
    }
    
    // Check wishlist status on load
    function checkWishlistStatus() {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        $('.wishlist-btn').each(function() {
            let id = $(this).data('id');
            if (wishlist.includes(id)) {
                $(this).find('i').removeClass('far').addClass('fas');
                $(this).addClass('active');
            }
        });
    }
    checkWishlistStatus();
    
    // ============================================
    // QUICK VIEW FUNCTIONALITY
    // ============================================
    $('.quick-view-btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let productId = $(this).data('id');
        let card = $(this).closest('.modern-product-card');
        
        // Get product details from the card
        let product = {
            id: productId,
            name: card.find('.product-title').text().trim(),
            brand: card.find('.brand-name').text().trim(),
            price: card.find('.current-price').text().trim(),
            originalPrice: card.find('.original-price').text().trim(),
            discount: card.find('.discount').text().trim(),
            image: card.find('.product-image img').attr('src'),
            rating: getRatingFromStars(card)
        };
        
        // Show modal with product details
        showQuickView(product);
    });
    
    function getRatingFromStars(card) {
        let starCount = card.find('.product-rating .fas.fa-star').length;
        let halfStar = card.find('.product-rating .fa-star-half-alt').length;
        return starCount + (halfStar ? 0.5 : 0);
    }
    
    function showQuickView(product) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <img src="${product.image}" alt="${product.name}" class="img-fluid rounded">
                </div>
                <div class="col-md-6">
                    <p class="brand-name mb-1">${product.brand}</p>
                    <h5 class="mb-2">${product.name}</h5>
                    <div class="product-rating mb-2">
                        ${generateRatingStars(product.rating)}
                        <span class="rating-count">(Based on reviews)</span>
                    </div>
                    <div class="price-section mb-3">
                        <span class="current-price h4">${product.price}</span>
                        <span class="original-price ms-2">${product.originalPrice}</span>
                        <span class="discount ms-2">${product.discount}</span>
                    </div>
                    <p class="text-success"><i class="fas fa-check-circle"></i> In Stock</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-add-to-cart quick-add-to-cart" 
                                data-id="${product.id}"
                                data-name="${product.name}"
                                data-brand="${product.brand}"
                                data-price="${product.price.replace('₹', '').replace(',', '')}"
                                data-image="${product.image}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-primary quick-buy-now">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#quickViewContent').html(content);
        $('#quickViewModal').modal('show');
    }
    
    function generateRatingStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(rating)) {
                stars += '<i class="fas fa-star text-warning"></i>';
            } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                stars += '<i class="fas fa-star-half-alt text-warning"></i>';
            } else {
                stars += '<i class="far fa-star text-warning"></i>';
            }
        }
        return stars;
    }
    
    // Quick view add to cart
    $(document).on('click', '.quick-add-to-cart', function(e) {
        e.preventDefault();
        
        let btn = $(this);
        let id = btn.data('id');
        let name = btn.data('name');
        let brand = btn.data('brand');
        let price = btn.data('price');
        let image = btn.data('image');
        
        let originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            type: 'POST',
            data: {
                id: id,
                name: name,
                brand: brand,
                price: price,
                image: image,
                quantity: 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    showNotification(response.message, 'success');
                    
                    $('#quickViewModal').modal('hide');
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                }
            },
            error: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
                showNotification('Error adding to cart', 'error');
            }
        });
    });
    
    // Quick view buy now
    $(document).on('click', '.quick-buy-now', function() {
        $('#quickViewModal').modal('hide');
        window.location.href = '{{ route("checkout") }}';
    });
    
    // ============================================
    // NOTIFICATION FUNCTION
    // ============================================
    function showNotification(message, type = 'info') {
        // Check if toastr is available
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            // Create temporary notification
            let notification = $(`
                <div class="temp-notification ${type}" style="position: fixed; top: 20px; right: 20px; background: ${type === 'success' ? '#4caf50' : '#f44336'}; color: white; padding: 12px 20px; border-radius: 4px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span style="margin-left: 8px;">${message}</span>
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    }
    
    // ============================================
    // PRODUCT COUNT UPDATE (Demo)
    // ============================================
    function updateProductCount(count) {
        $('#productCount').text(count.toLocaleString());
    }
    
    // Initialize with some demo functionality
    console.log('Category page initialized with filters');
});
</script>
@endpush