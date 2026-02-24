@extends('layouts.master')

@section('title', $categoryInfo->name . ' - Products')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $categoryInfo->name }}</li>
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
                    
                    <!-- Category Description -->
                    @if($categoryInfo->description)
                    <div class="filter-section">
                        <p class="text-muted small">{{ $categoryInfo->description }}</p>
                    </div>
                    @endif
                    
                    <!-- Subcategories Filter -->
                    @if($subcategories->count() > 0)
                    <div class="filter-section">
                        <h6 class="filter-title">SUBCATEGORIES</h6>
                        <div class="filter-options">
                            @foreach($subcategories as $subcat)
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" 
                                       id="subcat{{ $subcat->id }}" 
                                       data-filter="subcategory" 
                                       data-value="{{ $subcat->id }}">
                                <label class="form-check-label" for="subcat{{ $subcat->id }}">
                                    {{ $subcat->name }} 
                                    <span class="text-muted">({{ $subcat->products_count ?? 0 }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Price Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">PRICE</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price1" data-filter="price" data-value="under-500">
                                <label class="form-check-label" for="price1">Under ₹500</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price2" data-filter="price" data-value="500-1000">
                                <label class="form-check-label" for="price2">₹500 - ₹1000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price3" data-filter="price" data-value="1000-5000">
                                <label class="form-check-label" for="price3">₹1000 - ₹5000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price4" data-filter="price" data-value="5000-10000">
                                <label class="form-check-label" for="price4">₹5000 - ₹10000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-radio" type="radio" name="price" id="price5" data-filter="price" data-value="over-10000">
                                <label class="form-check-label" for="price5">Over ₹10000</label>
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
                    @if($brands->count() > 0)
                    <div class="filter-section">
                        <h6 class="filter-title">BRAND</h6>
                        <div class="filter-options">
                            @foreach($brands as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" 
                                       id="brand{{ $loop->index }}" 
                                       data-filter="brand" 
                                       data-value="{{ $brand }}">
                                <label class="form-check-label" for="brand{{ $loop->index }}">
                                    {{ $brand }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Rating Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">CUSTOMER RATINGS</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating4" data-filter="rating" data-value="4">
                                <label class="form-check-label" for="rating4">4★ & above</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating3" data-filter="rating" data-value="3">
                                <label class="form-check-label" for="rating3">3★ & above</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating2" data-filter="rating" data-value="2">
                                <label class="form-check-label" for="rating2">2★ & above</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="rating1" data-filter="rating" data-value="1">
                                <label class="form-check-label" for="rating1">1★ & above</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Discount Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">DISCOUNT</h6>
                        <div class="filter-options">
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount50" data-filter="discount" data-value="50">
                                <label class="form-check-label" for="discount50">50% or more</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount40" data-filter="discount" data-value="40">
                                <label class="form-check-label" for="discount40">40% or more</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-checkbox" type="checkbox" id="discount30" data-filter="discount" data-value="30">
                                <label class="form-check-label" for="discount30">30% or more</label>
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
                    <div>
                        <h4 class="mb-0" id="categoryTitle">
                            {{ $categoryInfo->name }} 
                            (<span id="productCount">{{ $products->total() }}</span> Products)
                        </h4>
                    </div>
                    
                    <!-- Sort By Dropdown -->
                    <div class="sort-by d-flex align-items-center">
                        <span class="text-muted me-2 d-none d-sm-inline">Sort by:</span>
                        <select class="form-select form-select-sm" id="sortBy" style="width: auto;">
                            <option value="popularity" selected>Popularity</option>
                            <option value="price-low">Price - Low to High</option>
                            <option value="price-high">Price - High to Low</option>
                            <option value="newest">Newest First</option>
                            <option value="discount">Discount</option>
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
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 product-item" data-id="{{ $product->id }}">
                            <div class="modern-product-card">
                                @if($product->badge)
                                <div class="product-badge 
                                    @if($product->badge == 'TRENDING') trending 
                                    @elseif($product->badge == 'NEW') new 
                                    @else bestseller @endif">
                                    {{ $product->badge }}
                                </div>
                                @endif
                                <div class="product-image">
                                    <img src="{{ $product->main_image ?? 'https://picsum.photos/300/300?random='.$product->id }}" 
                                         alt="{{ $product->name }}">
                                    <div class="product-actions">
                                        <button class="action-btn wishlist-btn" title="Add to Wishlist" data-id="{{ $product->id }}">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn quick-view-btn" title="Quick View" data-id="{{ $product->id }}">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="brand-name">{{ $product->brand }}</div>
                                    <a href="{{ $product->url }}" class="text-decoration-none">
                                        <h3 class="product-title">{{ $product->name }}</h3>
                                    </a>
                                    <div class="price-section">
                                        <span class="current-price">₹{{ number_format($product->price) }}</span>
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <span class="original-price">₹{{ number_format($product->original_price) }}</span>
                                            <span class="discount">{{ $product->discount_percentage }}% off</span>
                                        @endif
                                    </div>
                                    <div class="product-rating mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i == ceil($product->rating) && $product->rating - floor($product->rating) >= 0.5)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="rating-count">({{ number_format($product->reviews_count) }})</span>
                                    </div>
                                    <button class="add-to-cart-btn mt-3" 
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-brand="{{ $product->brand }}"
                                            data-price="{{ $product->price }}"
                                            data-image="{{ $product->main_image }}">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h5>No products found in this category</h5>
                                <p class="text-muted">Check back later for new products</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-section mt-5">
                    {{ $products->links() }}
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
/* Filter Sidebar Styles */
.filter-sidebar {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
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
}

.filter-options .form-check-label {
    font-size: 13px;
    color: #555;
    cursor: pointer;
}

.filter-options .form-check-input:checked {
    background-color: #febd69;
    border-color: #febd69;
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

/* Category Header */
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

/* Products Grid */
.products-grid {
    margin-top: 20px;
}

/* Modern Product Card */
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

.modern-product-card .add-to-cart-btn:hover {
    background: #333;
    color: white;
    border-color: #333;
}

/* Pagination */
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

/* Responsive */
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
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // ============================================
    // FILTER FUNCTIONALITY
    // ============================================
    
    // Store active filters
    let activeFilters = {
        subcategory: [],
        price: null,
        brand: [],
        rating: [],
        discount: []
    };
    
    // Current sort option
    let currentSort = 'popularity';
    let currentPage = 1;
    
    // Update filter tags display
    function updateFilterTags() {
        let tagsHtml = '';
        let filterCount = 0;
        
        // Subcategory filters
        activeFilters.subcategory.forEach(id => {
            let label = $(`#subcat${id}`).next('label').text().split('(')[0].trim();
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="subcategory" data-value="${id}"></i></span>`;
            filterCount++;
        });
        
        // Price filter
        if (activeFilters.price) {
            let label = $(`input[data-filter="price"][data-value="${activeFilters.price}"]`).next('label').text();
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="price" data-value="${activeFilters.price}"></i></span>`;
            filterCount++;
        }
        
        // Brand filters
        activeFilters.brand.forEach(brand => {
            tagsHtml += `<span class="filter-tag">${brand} <i class="fas fa-times remove-filter" data-filter="brand" data-value="${brand}"></i></span>`;
            filterCount++;
        });
        
        // Rating filters
        activeFilters.rating.forEach(value => {
            let label = $(`input[data-filter="rating"][data-value="${value}"]`).next('label').text();
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="rating" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        // Discount filters
        activeFilters.discount.forEach(value => {
            let label = $(`input[data-filter="discount"][data-value="${value}"]`).next('label').text();
            tagsHtml += `<span class="filter-tag">${label} <i class="fas fa-times remove-filter" data-filter="discount" data-value="${value}"></i></span>`;
            filterCount++;
        });
        
        if (filterCount > 0) {
            $('#filterTags').html(tagsHtml);
            $('#activeFilters').show();
        } else {
            $('#activeFilters').hide();
        }
    }
    
    // Apply filters
    function applyFilters() {
        let params = new URLSearchParams();
        
        // Add filters to URL params
        if (activeFilters.subcategory.length) params.append('subcategory', activeFilters.subcategory.join(','));
        if (activeFilters.price) params.append('price', activeFilters.price);
        if (activeFilters.brand.length) params.append('brand', activeFilters.brand.join(','));
        if (activeFilters.rating.length) params.append('rating', activeFilters.rating.join(','));
        if (activeFilters.discount.length) params.append('discount', activeFilters.discount.join(','));
        params.append('sort', currentSort);
        params.append('page', currentPage);
        
        window.location.href = window.location.pathname + '?' + params.toString();
    }
    
    // Handle checkbox filters
    $('.filter-checkbox').on('change', function() {
        let filterType = $(this).data('filter');
        let filterValue = $(this).data('value');
        let isChecked = $(this).is(':checked');
        
        if (filterType === 'subcategory') {
            if (isChecked) {
                activeFilters.subcategory.push(filterValue);
            } else {
                activeFilters.subcategory = activeFilters.subcategory.filter(v => v != filterValue);
            }
        } else if (filterType === 'brand') {
            if (isChecked) {
                activeFilters.brand.push(filterValue);
            } else {
                activeFilters.brand = activeFilters.brand.filter(v => v != filterValue);
            }
        } else if (filterType === 'rating') {
            if (isChecked) {
                activeFilters.rating.push(filterValue);
            } else {
                activeFilters.rating = activeFilters.rating.filter(v => v != filterValue);
            }
        } else if (filterType === 'discount') {
            if (isChecked) {
                activeFilters.discount.push(filterValue);
            } else {
                activeFilters.discount = activeFilters.discount.filter(v => v != filterValue);
            }
        }
        
        updateFilterTags();
        applyFilters();
    });
    
    // Handle radio filters (price)
    $('.filter-radio').on('change', function() {
        if ($(this).is(':checked')) {
            activeFilters.price = $(this).data('value');
        } else {
            activeFilters.price = null;
        }
        updateFilterTags();
        applyFilters();
    });
    
    // Handle custom price range
    $('#applyPriceRange').on('click', function() {
        let min = $('#minPrice').val();
        let max = $('#maxPrice').val();
        
        if (min || max) {
            activeFilters.price = `custom-${min}-${max}`;
            updateFilterTags();
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
            
            if (filterType === 'subcategory') {
                activeFilters.subcategory = activeFilters.subcategory.filter(v => v != filterValue);
            } else if (filterType === 'brand') {
                activeFilters.brand = activeFilters.brand.filter(v => v != filterValue);
            } else if (filterType === 'rating') {
                activeFilters.rating = activeFilters.rating.filter(v => v != filterValue);
            } else if (filterType === 'discount') {
                activeFilters.discount = activeFilters.discount.filter(v => v != filterValue);
            }
        }
        
        updateFilterTags();
        applyFilters();
    });
    
    // Clear all filters
    $('#clearAllFilters').on('click', function() {
        $('.filter-checkbox').prop('checked', false);
        $('.filter-radio').prop('checked', false);
        $('#minPrice, #maxPrice').val('');
        
        activeFilters = {
            subcategory: [],
            price: null,
            brand: [],
            rating: [],
            discount: []
        };
        
        updateFilterTags();
        applyFilters();
    });
    
    // Sort change
    $('#sortBy').on('change', function() {
        currentSort = $(this).val();
        applyFilters();
    });
    
    // Pagination click handling
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        if (page) {
            currentPage = page;
            applyFilters();
        }
    });
    
    // ============================================
    // ADD TO CART FUNCTIONALITY
    // ============================================
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let id = btn.data('id');
        let name = btn.data('name');
        let brand = btn.data('brand');
        let price = btn.data('price');
        let image = btn.data('image');
        
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
                if (response.success) {
                    // Update cart count
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    showNotification(response.message, 'success');
                    
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
    
    // ============================================
    // WISHLIST
    // ============================================
    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let icon = btn.find('i');
        
        @auth
            // Logged in user - save to database
            let productId = btn.data('id');
            
            $.ajax({
                url: '{{ route("wishlist.store") }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    product_name: btn.closest('.modern-product-card').find('.product-title').text(),
                    product_brand: btn.closest('.modern-product-card').find('.brand-name').text(),
                    price: btn.closest('.modern-product-card').find('.current-price').text().replace('₹', '').replace(',', ''),
                    product_image: btn.closest('.modern-product-card').find('.product-image img').attr('src'),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        icon.removeClass('far').addClass('fas').css('color', '#ff4d4d');
                        showNotification(response.message, 'success');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '{{ route("login") }}';
                    } else {
                        showNotification('Error adding to wishlist', 'error');
                    }
                }
            });
        @else
            // Guest user - redirect to login
            window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.href);
        @endauth
    });
    
    // Notification function
    function showNotification(message, type) {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            alert(message);
        }
    }
});
</script>
@endpush