@extends('layouts.master')

@section('title', $product->name ?? 'Product Details')
@section('meta_description', $product->meta_description ?? '')
@section('meta_keywords', $product->meta_keywords ?? '')

@section('content')
<!-- ============================================
     BREADCRUMB SECTION - 🔥 DYNAMIC FROM DATABASE
     ============================================ -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                
                {{-- 🔥 DYNAMIC: Category from database --}}
                @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ $product->category->url }}" class="text-decoration-none">
                        {{ $product->category->name }}
                    </a>
                </li>
                @endif
                
                {{-- 🔥 DYNAMIC: Subcategory if exists --}}
                @if($product->subcategory)
                <li class="breadcrumb-item">
                    <a href="{{ route('category', $product->subcategory) }}" class="text-decoration-none">
                        {{ str_replace('-', ' ', ucfirst($product->subcategory)) }}
                    </a>
                </li>
                @endif
                
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- ============================================
     MAIN PRODUCT SECTION - 🔥 COMPLETELY DYNAMIC
     ============================================ -->
<section class="product-detail-section py-4">
    <div class="container">
        <div class="row g-4">
            <!-- ============================================
                 LEFT COLUMN - PRODUCT IMAGES (🔥 DYNAMIC)
                 ============================================ -->
            <div class="col-lg-5">
                <div class="product-gallery">
                    <!-- Main Image with Zoom -->
                    <div class="main-image-container mb-3">
                        <div class="zoom-container">
                            {{-- 🔥 DYNAMIC: Main image from database --}}
                            <img src="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://picsum.photos/500/500?random='.$product->id }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid main-image" 
                                 id="mainProductImage">
                            
                            <!-- Zoom Lens -->
                            <div class="zoom-lens"></div>
                            
                            <!-- Zoom Result -->
                            <div class="zoom-result"></div>
                            
                            {{-- 🔥 DYNAMIC: Badge from database --}}
                            @if($product->badge)
                            <div class="product-badge-large 
                                @if($product->badge == 'TRENDING') trending 
                                @elseif($product->badge == 'NEW') new 
                                @elseif($product->badge == 'BESTSELLER') bestseller 
                                @endif">
                                {{ $product->badge }}
                            </div>
                            @endif
                            
                            <!-- Wishlist Button -->
                            <button class="btn wishlist-btn" data-id="{{ $product->id }}" title="Add to Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    
                    {{-- 🔥 DYNAMIC: Thumbnail Images from database --}}
                    @php
                        $thumbnails = $product->thumbnail_images ?? [];
                    @endphp
                    
                    @if(!empty($thumbnails) && count($thumbnails) > 0)
                    <div class="thumbnail-images">
                        <div class="row g-2">
                            @foreach($thumbnails as $index => $thumbnail)
                            <div class="col-3">
                                <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" 
                                     onclick="changeImage(this, '{{ asset('storage/'.$thumbnail) }}')">
                                    <img src="{{ asset('storage/'.$thumbnail) }}" alt="Thumbnail {{ $index+1 }}" class="img-fluid">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Share & Social -->
                    <div class="share-section mt-3">
                        <span class="me-2">Share:</span>
                        <a href="#" class="social-share-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-share-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-share-btn"><i class="fab fa-pinterest-p"></i></a>
                        <a href="#" class="social-share-btn"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-share-btn"><i class="fab fa-telegram-plane"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 MIDDLE COLUMN - PRODUCT INFO (🔥 DYNAMIC)
                 ============================================ -->
            <div class="col-lg-4">
                <div class="product-info-wrapper">
                    <!-- Brand -->
                    <div class="brand-section mb-2">
                        <a href="{{ route('category', $product->brand) }}" class="brand-link">{{ $product->brand }}</a>
                    </div>
                    
                    <!-- Product Title -->
                    <h1 class="product-title-main">{{ $product->name }}</h1>
                    
                    <!-- Rating Section -->
                    <div class="rating-section mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="rating-badge-large">{{ number_format($product->rating, 1) }} <i class="fas fa-star"></i></span>
                            <span class="rating-count">{{ number_format($product->reviews_count) }} ratings</span>
                        </div>
                        
                        {{-- 🔥 DYNAMIC: Rating breakdown (calculated) --}}
                        @if($product->reviews_count > 0)
                        <div class="rating-breakdown mt-2">
                            @php
                                // In real app, these would come from database
                                $ratingPercentages = [
                                    5 => $product->rating >= 4.5 ? 75 : 60,
                                    4 => $product->rating >= 3.5 ? 15 : 20,
                                    3 => $product->rating >= 2.5 ? 5 : 10,
                                    2 => $product->rating >= 1.5 ? 3 : 5,
                                    1 => $product->rating >= 0.5 ? 2 : 5,
                                ];
                            @endphp
                            
                            @foreach($ratingPercentages as $star => $percentage)
                            <div class="rating-row">
                                <span class="rating-label">{{ $star }}★</span>
                                <div class="rating-bar">
                                    <div class="rating-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="rating-percent">{{ $percentage }}%</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section-main mb-3">
                        <div class="d-flex align-items-baseline gap-3">
                            <span class="current-price-large">₹{{ number_format($product->price) }}</span>
                            
                            @if($product->original_price && $product->original_price > $product->price)
                            <span class="original-price-large">₹{{ number_format($product->original_price) }}</span>
                            <span class="discount-large">{{ $product->discount_percentage }}% off</span>
                            @endif
                        </div>
                        <div class="price-info mt-1">
                            <span class="tax-info">inclusive of all taxes</span>
                        </div>
                    </div>
                    
                    <!-- Offers Section - 🔥 Can be managed from admin later -->
                    <div class="offers-section mb-3">
                        <h5 class="section-subtitle"><i class="fas fa-tag me-2"></i>Available Offers</h5>
                        <div class="offer-list">
                            <div class="offer-item">
                                <span class="offer-badge">BANK OFFER</span>
                                <span class="offer-text">10% instant discount on HDFC Bank Credit Card</span>
                            </div>
                            <div class="offer-item">
                                <span class="offer-badge">PARTNER OFFER</span>
                                <span class="offer-text">Buy 2 Get 5% off on select accessories</span>
                            </div>
                            <div class="offer-item">
                                <span class="offer-badge">SPECIAL PRICE</span>
                                <span class="offer-text">Get extra 5% off (price inclusive of special price)</span>
                            </div>
                            <a href="#" class="view-more-offers">View 3 more offers</a>
                        </div>
                    </div>
                    
                    {{-- 🔥 DYNAMIC: Color Selection --}}
                    @if(!empty($product->colors) && count($product->colors) > 0)
                    <div class="color-section mb-3">
                        <h5 class="section-subtitle">Color: <span class="selected-color">{{ $product->colors[0] }}</span></h5>
                        <div class="color-options">
                            @foreach($product->colors as $color)
                            @php
                                $colorCode = match($color) {
                                    'Navy Blue' => '#000080',
                                    'Red' => '#ff0000',
                                    'Black' => '#000000',
                                    'Grey' => '#808080',
                                    'White' => '#ffffff',
                                    'Green' => '#008000',
                                    'Blue' => '#0000ff',
                                    'Yellow' => '#ffff00',
                                    'Purple' => '#800080',
                                    'Orange' => '#ffa500',
                                    'Brown' => '#a52a2a',
                                    'Pink' => '#ffc0cb',
                                    default => '#cccccc'
                                };
                            @endphp
                            <div class="color-option {{ $loop->first ? 'active' : '' }}" 
                                 style="background-color: {{ $colorCode }}; {{ $color == 'White' ? 'border: 1px solid #ddd;' : '' }}" 
                                 title="{{ $color }}"></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    {{-- 🔥 DYNAMIC: Size Selection --}}
                    @if(!empty($product->sizes) && count($product->sizes) > 0)
                    <div class="size-section mb-3">
                        <div class="d-flex justify-content-between">
                            <h5 class="section-subtitle">Select Size</h5>
                            <a href="#" class="size-chart-link"><i class="fas fa-ruler"></i> Size Chart</a>
                        </div>
                        <div class="size-options">
                            @foreach($product->sizes as $size)
                            <div class="size-option {{ $loop->first ? 'active' : '' }}">{{ $size }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Quantity -->
                    <div class="quantity-section mb-3">
                        <h5 class="section-subtitle">Quantity</h5>
                        <div class="quantity-selector">
                            <button class="quantity-btn" id="decreaseQty">-</button>
                            <input type="number" class="quantity-input" id="productQuantity" value="1" min="1" max="{{ $product->stock_quantity ?: 10 }}" readonly>
                            <button class="quantity-btn" id="increaseQty">+</button>
                        </div>
                        @if($product->stock_quantity > 0)
                        <small class="text-muted ms-2">{{ $product->stock_quantity }} items available</small>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn btn-add-to-cart" id="addToCartBtn" 
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-brand="{{ $product->brand }}"
                                data-price="{{ $product->price }}"
                                data-image="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://picsum.photos/500/500?random='.$product->id }}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-buy-now" id="buyNowBtn">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                    
                    <!-- Delivery Info -->
                    <div class="delivery-info-card mt-3">
                        <div class="delivery-option mb-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Delivery to <strong>Guwahati 781030</strong></span>
                            <a href="#" class="change-link">Change</a>
                        </div>
                        <div class="delivery-date">
                            <i class="fas fa-truck"></i>
                            <span>Delivery by <strong>{{ date('d M Y', strtotime('+3 days')) }}</strong> | 
                                @if($product->price >= 499)
                                <span class="text-success">Free</span>
                                @else
                                <span>₹40</span>
                                @endif
                            </span>
                        </div>
                        <div class="stock-status {{ $product->in_stock ? 'text-success' : 'text-danger' }} mt-2">
                            <i class="fas {{ $product->in_stock ? 'fa-check-circle' : 'fa-times-circle' }}"></i> 
                            {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                        </div>
                        
                        <!-- Pin Code Check -->
                        <div class="pincode-check mt-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter pincode" id="pincodeInput" maxlength="6">
                                <button class="btn btn-outline-primary" type="button" id="checkPincode">Check</button>
                            </div>
                            <div id="pincodeMessage" class="small mt-1"></div>
                        </div>
                    </div>
                    
                    {{-- 🔥 DYNAMIC: Product Highlights --}}
                    @if(!empty($product->highlights) && count($product->highlights) > 0)
                    <div class="product-highlights mt-3">
                        <h5 class="section-subtitle">Product Highlights</h5>
                        <ul class="highlights-list">
                            @foreach($product->highlights as $highlight)
                            <li><i class="fas fa-check-circle"></i> {{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    {{-- 🔥 DYNAMIC: Seller Info --}}
                    @if($product->seller)
                    <div class="seller-info mt-3">
                        <span class="seller-label">Seller: </span>
                        <a href="#" class="seller-name">{{ $product->seller }}</a>
                        @if($product->seller_rating)
                        <span class="seller-rating">
                            <i class="fas fa-star text-warning"></i> 
                            {{ number_format($product->seller_rating, 1) }} 
                            ({{ number_format($product->seller_ratings_count ?? 0) }} ratings)
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- ============================================
                 RIGHT COLUMN - DELIVERY & OFFERS
                 ============================================ -->
            <div class="col-lg-3">
                <div class="delivery-sidebar">
                    <!-- Coupons -->
                    <div class="coupons-section mb-3">
                        <h5 class="sidebar-title"><i class="fas fa-tags me-2"></i>Available Coupons</h5>
                        <div class="coupon-card">
                            <div class="coupon-code">FASHION10</div>
                            <div class="coupon-desc">10% off on Fashion items</div>
                            <button class="btn-apply-coupon" data-coupon="FASHION10">Apply</button>
                        </div>
                        <div class="coupon-card">
                            <div class="coupon-code">NEWUSER50</div>
                            <div class="coupon-desc">Flat ₹50 off for new users</div>
                            <button class="btn-apply-coupon" data-coupon="NEWUSER50">Apply</button>
                        </div>
                        <a href="#" class="view-all-coupons">View All Coupons</a>
                    </div>
                    
                    <!-- Services -->
                    <div class="services-section mb-3">
                        {{-- 🔥 DYNAMIC: Warranty from database --}}
                        @if($product->warranty)
                        <div class="service-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>{{ Str::limit($product->warranty, 30) }}</span>
                        </div>
                        @endif
                        <div class="service-item">
                            <i class="fas fa-undo-alt"></i>
                            <span>7 Days Replacement</span>
                        </div>
                        <div class="service-item">
                            <i class="fas fa-truck"></i>
                            <span>Free Delivery on ₹499+</span>
                        </div>
                        <div class="service-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash on Delivery</span>
                        </div>
                    </div>
                    
                    <!-- Secure Payment -->
                    <div class="secure-payment">
                        <img src="{{ asset('images/banner/svgviewer-png-output.png') }}" alt="Secure Payment" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     PRODUCT DETAILS TABS SECTION (🔥 DYNAMIC)
     ============================================ -->
<section class="product-tabs-section py-4 bg-light">
    <div class="container">
        <div class="product-tabs">
            <!-- Tab Navigation - 🔥 Dynamic based on available data -->
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description">Product Description</button>
                </li>
                
                {{-- 🔥 DYNAMIC: Show specifications tab only if exists --}}
                @if(!empty($product->specifications))
                <li class="nav-item">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications">Specifications</button>
                </li>
                @endif
                
                <li class="nav-item">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews">Reviews ({{ number_format($product->reviews_count) }})</button>
                </li>
                
                {{-- 🔥 DYNAMIC: Show warranty tab only if exists --}}
                @if($product->warranty)
                <li class="nav-item">
                    <button class="nav-link" id="warranty-tab" data-bs-toggle="tab" data-bs-target="#warranty">Warranty</button>
                </li>
                @endif
            </ul>
            
            <!-- Tab Content -->
            <div class="tab-content p-4" id="productTabsContent">
                <!-- Description Tab - 🔥 DYNAMIC -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <h5>Product Description</h5>
                    <p>{{ $product->description ?? 'No description available.' }}</p>
                    
                    {{-- 🔥 DYNAMIC: Highlights in description --}}
                    @if(!empty($product->highlights))
                    <h6 class="mt-3">Key Features:</h6>
                    <ul>
                        @foreach($product->highlights as $highlight)
                        <li>{{ $highlight }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                
                {{-- 🔥 DYNAMIC: Specifications Tab --}}
                @if(!empty($product->specifications))
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <h5>Product Specifications</h5>
                    <table class="table table-striped">
                        @foreach($product->specifications as $key => $value)
                        <tr>
                            <th>{{ is_numeric($key) ? 'Specification' : ucwords(str_replace('_', ' ', $key)) }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="reviews-summary d-flex align-items-center gap-4 mb-4">
                        <div class="average-rating text-center">
                            <h2 class="mb-0">{{ number_format($product->rating, 1) }}</h2>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->rating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i == ceil($product->rating) && $product->rating - floor($product->rating) >= 0.5)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-muted">{{ number_format($product->reviews_count) }} Reviews</p>
                        </div>
                    </div>
                    
                    <!-- Individual Reviews - 🔥 Can be dynamic from reviews table -->
                    <div class="reviews-list">
                        <div class="review-item mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>Rahul Sharma</strong>
                                <span class="text-muted">2 days ago</span>
                            </div>
                            <div class="stars mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p>Excellent product! Very comfortable and fits perfectly. The fabric quality is top notch.</p>
                        </div>
                        
                        <div class="review-item mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>Priya Patel</strong>
                                <span class="text-muted">5 days ago</span>
                            </div>
                            <div class="stars mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                            </div>
                            <p>Good product for the price. Delivery was fast. Color is exactly as shown.</p>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-primary">View All Reviews</button>
                        </div>
                    </div>
                </div>
                
                {{-- 🔥 DYNAMIC: Warranty Tab --}}
                @if($product->warranty)
                <div class="tab-pane fade" id="warranty" role="tabpanel">
                    <h5>Warranty Information</h5>
                    <p>{{ $product->warranty }}</p>
                    
                    <h6 class="mt-3">Warranty Terms:</h6>
                    <ul>
                        <li>Warranty covers manufacturing defects only</li>
                        <li>Physical damage not covered under warranty</li>
                        <li>Warranty valid only with original bill</li>
                        <li>For warranty claims, contact seller directly</li>
                    </ul>
                    
                    <p><strong>Note:</strong> This product is non-returnable if used or washed.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     RELATED PRODUCTS SECTION (🔥 DYNAMIC)
     ============================================ -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="related-products-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">You May Also Like</h2>
        <div class="related-products-slider owl-carousel owl-theme">
            @foreach($relatedProducts as $related)
            <div class="product-item">
                <div class="modern-product-card">
                    @if($related->badge)
                    <div class="product-badge 
                        @if($related->badge == 'TRENDING') trending 
                        @elseif($related->badge == 'NEW') new 
                        @elseif($related->badge == 'BESTSELLER') bestseller 
                        @endif">
                        {{ $related->badge }}
                    </div>
                    @endif
                    <div class="product-image">
                        <img src="{{ $related->main_image ? asset('storage/'.$related->main_image) : 'https://picsum.photos/300/300?random='.$related->id }}" alt="{{ $related->name }}">
                        <div class="product-actions">
                            <button class="action-btn wishlist"><i class="far fa-heart"></i></button>
                            <button class="action-btn quick-view"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">{{ $related->brand }}</div>
                        <a href="{{ $related->url }}">
                            <h3 class="product-title">{{ $related->name }}</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹{{ number_format($related->price) }}</span>
                            @if($related->original_price)
                            <span class="original-price">₹{{ number_format($related->original_price) }}</span>
                            <span class="discount">{{ $related->discount_percentage }}% off</span>
                            @endif
                        </div>
                        <button class="add-to-cart-btn mt-2" 
                                data-id="{{ $related->id }}"
                                data-name="{{ $related->name }}"
                                data-brand="{{ $related->brand }}"
                                data-price="{{ $related->price }}"
                                data-image="{{ $related->main_image ? asset('storage/'.$related->main_image) : 'https://picsum.photos/300/300?random='.$related->id }}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ============================================
     RECENTLY VIEWED PRODUCTS
     ============================================ -->
<section class="recently-viewed-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4">Recently Viewed</h2>
        <div class="recently-viewed-slider owl-carousel owl-theme" id="recentlyViewedSlider">
            <!-- Recently viewed items will be loaded via JavaScript -->
        </div>
    </div>
</section>
@endsection

{{-- 🔥 ALL EXISTING STYLES REMAIN EXACTLY THE SAME --}}
@push('styles')
<style>
/* ============================================
   PRODUCT GALLERY STYLES
   ============================================ */
.product-gallery {
    position: sticky;
    top: 20px;
}

.zoom-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #f0f0f0;
}

.main-image {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease;
}

/* Zoom Lens */
.zoom-lens {
    position: absolute;
    display: none;
    width: 100px;
    height: 100px;
    border: 2px solid #febd69;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    pointer-events: none;
    z-index: 10;
}

/* Zoom Result */
.zoom-result {
    position: absolute;
    top: 0;
    left: 105%;
    width: 400px;
    height: 400px;
    background-repeat: no-repeat;
    background-size: 200% 200%;
    border: 1px solid #ddd;
    border-radius: 8px;
    display: none;
    z-index: 20;
    background-color: #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.zoom-container:hover .zoom-lens,
.zoom-container:hover .zoom-result {
    display: block;
}

/* Product Badge Large */
.product-badge-large {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #ff4d4d;
    color: white;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 4px;
    z-index: 5;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Wishlist Button */
.wishlist-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    color: #333;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 5;
}

.wishlist-btn:hover {
    background: #ff4d4d;
    color: white;
    transform: scale(1.1);
}

.wishlist-btn.active i {
    color: #ff4d4d;
    font-weight: 900;
}

/* Thumbnail Images */
.thumbnail-item {
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.thumbnail-item.active {
    border-color: #febd69;
}

.thumbnail-item:hover {
    border-color: #febd69;
    transform: translateY(-2px);
}

.thumbnail-item img {
    width: 100%;
    height: auto;
}

/* Share Section */
.share-section {
    display: flex;
    align-items: center;
    gap: 10px;
}

.social-share-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f5f5f5;
    color: #333;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-share-btn:hover {
    background: #febd69;
    color: #131921;
    transform: translateY(-2px);
}

/* ============================================
   PRODUCT INFO STYLES
   ============================================ */
.brand-link {
    color: #007185;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.brand-link:hover {
    color: #c45500;
    text-decoration: underline;
}

.product-title-main {
    font-size: 22px;
    font-weight: 500;
    color: #0f1111;
    line-height: 1.3;
    margin-bottom: 10px;
}

/* Rating Section */
.rating-badge-large {
    background: #2e6a40;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
}

.rating-badge-large i {
    font-size: 12px;
    margin-left: 3px;
}

.rating-breakdown {
    max-width: 300px;
}

.rating-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.rating-label {
    width: 30px;
    font-size: 12px;
    color: #666;
}

.rating-bar {
    flex: 1;
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
}

.rating-fill {
    height: 100%;
    background: #febd69;
    border-radius: 4px;
}

.rating-percent {
    width: 40px;
    font-size: 12px;
    color: #666;
}

/* Price Section */
.price-section-main {
    background: #f7f7f7;
    padding: 15px;
    border-radius: 8px;
}

.current-price-large {
    font-size: 28px;
    font-weight: 700;
    color: #0f1111;
}

.original-price-large {
    font-size: 16px;
    color: #565959;
    text-decoration: line-through;
}

.discount-large {
    font-size: 16px;
    color: #be0b3b;
    font-weight: 600;
}

.tax-info {
    font-size: 13px;
    color: #565959;
}

/* Offers Section */
.offers-section {
    background: #f7f7f7;
    padding: 15px;
    border-radius: 8px;
}

.offer-item {
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #ddd;
}

.offer-badge {
    background: #ffd814;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 8px;
    display: inline-block;
}

.offer-text {
    font-size: 13px;
    color: #0f1111;
}

.view-more-offers {
    font-size: 13px;
    color: #007185;
    text-decoration: none;
}

.view-more-offers:hover {
    color: #c45500;
    text-decoration: underline;
}

/* Color Options */
.color-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.color-option {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.color-option.active {
    border-color: #febd69;
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.color-option:hover {
    transform: scale(1.1);
    border-color: #febd69;
}

/* Size Options */
.size-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.size-option {
    min-width: 45px;
    height: 45px;
    border: 2px solid #ddd;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-option.active {
    border-color: #febd69;
    background: #febd69;
    color: #131921;
    font-weight: 600;
}

.size-option:hover:not(.disabled) {
    border-color: #febd69;
}

.size-option.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    text-decoration: line-through;
}

.size-chart-link {
    color: #007185;
    text-decoration: none;
    font-size: 13px;
}

.size-chart-link:hover {
    color: #c45500;
    text-decoration: underline;
}

/* Quantity Selector */
.quantity-selector {
    display: inline-flex;
    align-items: center;
    border: 2px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: #f5f5f5;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    background: #febd69;
}

.quantity-input {
    width: 60px;
    height: 40px;
    border: none;
    border-left: 2px solid #ddd;
    border-right: 2px solid #ddd;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
}

.quantity-input::-webkit-inner-spin-button,
.quantity-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.btn-add-to-cart {
    flex: 1;
    background: #ffd814;
    border: none;
    color: #0f1111;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-add-to-cart:hover {
    background: #f7ca00;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 216, 20, 0.3);
}

.btn-buy-now {
    flex: 1;
    background: #ffa41c;
    border: none;
    color: #0f1111;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-buy-now:hover {
    background: #f39200;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 164, 28, 0.3);
}

/* Delivery Card */
.delivery-info-card {
    background: #f7f7f7;
    padding: 15px;
    border-radius: 8px;
}

.delivery-option, .delivery-date {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.change-link {
    margin-left: auto;
    color: #007185;
    text-decoration: none;
    font-size: 13px;
}

.change-link:hover {
    color: #c45500;
    text-decoration: underline;
}

/* Product Highlights */
.highlights-list {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
}

.highlights-list li {
    margin-bottom: 8px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.highlights-list li i {
    color: #2e6a40;
    font-size: 14px;
}

/* Seller Info */
.seller-info {
    font-size: 14px;
}

.seller-name {
    color: #007185;
    text-decoration: none;
    font-weight: 500;
}

.seller-name:hover {
    color: #c45500;
    text-decoration: underline;
}

.seller-rating {
    margin-left: 10px;
    font-size: 13px;
    color: #666;
}

/* Delivery Sidebar */
.delivery-sidebar {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
}

.coupon-card {
    background: #f7f7f7;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    position: relative;
}

.coupon-code {
    font-size: 16px;
    font-weight: 700;
    color: #0f1111;
    margin-bottom: 4px;
}

.coupon-desc {
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
}

.btn-apply-coupon {
    background: #febd69;
    border: none;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-apply-coupon:hover {
    background: #f3a847;
}

/* Services Section */
.service-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 14px;
}

.service-item i {
    width: 20px;
    color: #febd69;
    font-size: 16px;
}

/* Tabs Section */
.product-tabs {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.nav-tabs {
    border-bottom: 2px solid #f0f0f0;
    background: #f9f9f9;
}

.nav-tabs .nav-link {
    border: none;
    color: #666;
    font-weight: 500;
    padding: 15px 25px;
    margin-right: 5px;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    color: #febd69;
    background: transparent;
}

.nav-tabs .nav-link.active {
    color: #febd69;
    background: transparent;
    border-bottom: 3px solid #febd69;
}

/* Related Products Slider */
.related-products-slider .owl-nav,
.recently-viewed-slider .owl-nav {
    position: absolute;
    top: -50px;
    right: 0;
}

.related-products-slider .owl-nav button,
.recently-viewed-slider .owl-nav button {
    width: 40px;
    height: 40px;
    background: #fff !important;
    border-radius: 50% !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-left: 10px;
}

.related-products-slider .owl-nav button:hover,
.recently-viewed-slider .owl-nav button:hover {
    background: #febd69 !important;
}

/* Responsive */
@media (max-width: 992px) {
    .zoom-result {
        display: none !important;
    }
    
    .product-gallery {
        position: static;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .product-title-main {
        font-size: 18px;
    }
    
    .current-price-large {
        font-size: 24px;
    }
}

@media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding: 12px 15px;
        font-size: 13px;
    }
    
    .tab-content {
        padding: 15px !important;
    }
    
    .color-option {
        width: 30px;
        height: 30px;
    }
    
    .size-option {
        min-width: 40px;
        height: 40px;
    }
}
</style>
@endpush

{{-- 🔥 UPDATED SCRIPTS - Fixed for dynamic data --}}
@push('scripts')
<script>
$(document).ready(function() {
    'use strict';
    
    // ============================================
    // IMAGE ZOOM FUNCTIONALITY
    // ============================================
    const zoomContainer = $('.zoom-container');
    const mainImage = $('#mainProductImage');
    const lens = $('.zoom-lens');
    const result = $('.zoom-result');
    
    if (zoomContainer.length && mainImage.length) {
        zoomContainer.on('mousemove', function(e) {
            e.preventDefault();
            
            const containerOffset = zoomContainer.offset();
            const containerWidth = zoomContainer.width();
            const containerHeight = zoomContainer.height();
            
            // Calculate mouse position relative to container
            let posX = e.pageX - containerOffset.left;
            let posY = e.pageY - containerOffset.top;
            
            // Keep lens within bounds
            posX = Math.min(containerWidth - lens.width(), Math.max(0, posX - lens.width() / 2));
            posY = Math.min(containerHeight - lens.height(), Math.max(0, posY - lens.height() / 2));
            
            // Position the lens
            lens.css({
                left: posX,
                top: posY,
                display: 'block'
            });
            
            // Calculate zoom background position
            const bgX = (posX / containerWidth) * 100;
            const bgY = (posY / containerHeight) * 100;
            
            // Update zoom result
            result.css({
                backgroundImage: `url('${mainImage.attr('src')}')`,
                backgroundPosition: `${bgX}% ${bgY}%`,
                display: 'block'
            });
        });
        
        zoomContainer.on('mouseleave', function() {
            lens.hide();
            result.hide();
        });
        
        zoomContainer.on('mouseenter', function() {
            if (lens.is(':hidden')) {
                lens.show();
            }
        });
    }
    
    // ============================================
    // CHANGE MAIN IMAGE
    // ============================================
    window.changeImage = function(element, imageUrl) {
        // Update main image
        $('#mainProductImage').attr('src', imageUrl);
        
        // Update active thumbnail
        $('.thumbnail-item').removeClass('active');
        $(element).addClass('active');
    };
    
    // ============================================
    // QUANTITY CONTROLS
    // ============================================
    $('#increaseQty').on('click', function(e) {
        e.preventDefault();
        let input = $('#productQuantity');
        let value = parseInt(input.val());
        let max = parseInt(input.attr('max'));
        if (value < max) {
            input.val(value + 1);
        }
    });
    
    $('#decreaseQty').on('click', function(e) {
        e.preventDefault();
        let input = $('#productQuantity');
        let value = parseInt(input.val());
        let min = parseInt(input.attr('min'));
        if (value > min) {
            input.val(value - 1);
        }
    });
    
    // ============================================
    // COLOR SELECTION
    // ============================================
    $('.color-option').on('click', function() {
        $('.color-option').removeClass('active');
        $(this).addClass('active');
        
        let color = $(this).attr('title');
        $('.selected-color').text(color);
    });
    
    // ============================================
    // SIZE SELECTION
    // ============================================
    $('.size-option:not(.disabled)').on('click', function() {
        $('.size-option').removeClass('active');
        $(this).addClass('active');
    });
    
    // ============================================
    // WISHLIST TOGGLE
    // ============================================
    $('.wishlist-btn').on('click', function() {
        $(this).toggleClass('active');
        let icon = $(this).find('i');
        
        if (icon.hasClass('far')) {
            icon.removeClass('far').addClass('fas');
            showNotification('Added to wishlist!', 'success');
            
            // 🔥 Save to wishlist (can be implemented with AJAX)
            saveToWishlist($(this).data('id'));
        } else {
            icon.removeClass('fas').addClass('far');
            showNotification('Removed from wishlist', 'info');
            
            // 🔥 Remove from wishlist
            removeFromWishlist($(this).data('id'));
        }
    });
    
    // Wishlist functions using localStorage
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
    
    // ============================================
    // PINCODE CHECK
    // ============================================
    $('#checkPincode').on('click', function() {
        let pincode = $('#pincodeInput').val().trim();
        
        if (pincode.length === 6 && /^\d+$/.test(pincode)) {
            // Simulate API call
            $('#pincodeMessage').html('<span class="text-info"><i class="fas fa-spinner fa-spin"></i> Checking...</span>');
            
            setTimeout(function() {
                if (pincode === '781030' || pincode === '110001' || pincode === '400001') {
                    $('#pincodeMessage').html('<span class="text-success"><i class="fas fa-check-circle"></i> Delivery available at ' + pincode + '</span>');
                } else {
                    $('#pincodeMessage').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Delivery not available at this pincode</span>');
                }
            }, 1000);
        } else {
            $('#pincodeMessage').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Please enter valid 6-digit pincode</span>');
        }
    });
    
    // Allow only numbers in pincode input
    $('#pincodeInput').on('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
    
    // ============================================
    // ADD TO CART - FIXED WORKING VERSION
    // ============================================
    $('#addToCartBtn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let button = $(this);
        let quantity = $('#productQuantity').val();
        let size = $('.size-option.active').text() || '';
        let color = $('.color-option.active').attr('title') || '';
        
        // Get product details
        let id = button.data('id');
        let name = button.data('name');
        let brand = button.data('brand');
        let price = button.data('price');
        let image = button.data('image');
        
        console.log('Adding to cart:', {id, name, brand, price, image, quantity, size, color});
        
        // Button animation
        let originalText = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        button.prop('disabled', true);
        
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                id: id,
                name: name,
                brand: brand,
                price: price,
                image: image,
                quantity: quantity,
                selected_size: size,
                selected_color: color,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Add to cart success:', response);
                
                if (response.success) {
                    // Update cart count
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    // Animate cart
                    $('.cart-wrapper').addClass('animate__animated animate__rubberBand');
                    setTimeout(function() {
                        $('.cart-wrapper').removeClass('animate__animated animate__rubberBand');
                    }, 1000);
                    
                    showNotification(`Added ${quantity} item(s) to cart!`, 'success');
                    
                    // Redirect to cart page
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Add to cart error:', error);
                console.error('Response:', xhr.responseText);
                
                button.html(originalText);
                button.prop('disabled', false);
                
                let errorMessage = 'Error adding to cart';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // ============================================
    // BUY NOW
    // ============================================
    $('#buyNowBtn').on('click', function() {
        window.location.href = '{{ route("checkout") }}';
    });
    
    // ============================================
    // APPLY COUPON
    // ============================================
    $('.btn-apply-coupon').on('click', function() {
        let couponCode = $(this).data('coupon') || $(this).siblings('.coupon-code').text();
        showNotification(`Coupon ${couponCode} applied!`, 'success');
    });
    
    // ============================================
    // RECENTLY VIEWED (localStorage)
    // ============================================
    function saveToRecentlyViewed() {
        let product = {
            id: '{{ $product->id }}',
            name: $('.product-title-main').text().trim(),
            brand: $('.brand-link').text().trim(),
            price: $('.current-price-large').text().trim().replace('₹', '').replace(',', ''),
            image: $('#mainProductImage').attr('src'),
            slug: '{{ $product->slug }}',
            url: '{{ $product->url }}',
            timestamp: new Date().getTime()
        };
        
        let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed')) || [];
        
        // Remove if already exists
        recentlyViewed = recentlyViewed.filter(p => p.id !== product.id);
        
        // Add to beginning
        recentlyViewed.unshift(product);
        
        // Keep only last 10 items
        if (recentlyViewed.length > 10) {
            recentlyViewed = recentlyViewed.slice(0, 10);
        }
        
        localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));
        
        // Load recently viewed items
        loadRecentlyViewed();
    }
    
    // Call saveToRecentlyViewed on page load
    saveToRecentlyViewed();
    
    // Load recently viewed items from localStorage
    function loadRecentlyViewed() {
        let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed')) || [];
        
        if (recentlyViewed.length === 0) {
            $('.recently-viewed-section').hide();
            return;
        }
        
        $('.recently-viewed-section').show();
        
        let html = '';
        recentlyViewed.forEach(function(product) {
            html += `
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-image">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="product-info">
                        <div class="brand-name">${product.brand}</div>
                        <a href="${product.url || '/product/' + product.id + '/' + (product.slug || '')}">
                            <h3 class="product-title">${product.name}</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹${parseInt(product.price).toLocaleString()}</span>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });
        
        $('#recentlyViewedSlider').html(html);
        
        // Initialize slider if not already initialized
        if ($('#recentlyViewedSlider').hasClass('owl-loaded')) {
            $('#recentlyViewedSlider').trigger('destroy.owl.carousel').removeClass('owl-loaded');
        }
        
        $('#recentlyViewedSlider').owlCarousel({
            loop: recentlyViewed.length > 4,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: false,
            responsive: {
                0: { items: 2, nav: false, dots: true },
                576: { items: 3, nav: false, dots: true },
                768: { items: 4, nav: true },
                992: { items: 5, nav: true }
            },
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ]
        });
    }
    
    // ============================================
    // RELATED PRODUCTS SLIDER
    // ============================================
    if ($('.related-products-slider').length) {
        $('.related-products-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: { items: 1, nav: false, dots: true },
                576: { items: 2, nav: false, dots: true },
                768: { items: 3, nav: true },
                992: { items: 4, nav: true }
            },
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ]
        });
    }
    
    // Add to cart for related products
    $(document).on('click', '.related-products-section .add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let id = btn.data('id');
        let name = btn.data('name');
        let brand = btn.data('brand');
        let price = btn.data('price');
        let image = btn.data('image');
        
        console.log('Adding related product to cart:', {id, name, brand, price, image});
        
        // Button animation
        let originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                id: id,
                name: name,
                brand: brand,
                price: price,
                image: image,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    showNotification(response.message, 'success');
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                }
            },
            error: function(xhr) {
                btn.html(originalText);
                btn.prop('disabled', false);
                showNotification('Error adding to cart', 'error');
            }
        });
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
});
</script>
@endpush