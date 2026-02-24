@extends('layouts.master')

@section('title', 'Home - My Website')

@section('content')
<!-- Main Slider Section -->
<section class="slider-section">
    <div class="container-fluid p-0">
        <!-- Main Banner Slider -->
        <div class="main-slider owl-carousel owl-theme">
            <!-- Slide 1 -->
            <div class="slider-item">
                <div class="slide-bg" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                    <img src="{{ asset('images/banner/1.png') }}" alt="Banner 1" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400/ffffff/333333?text=Banner+1';">
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="slider-item">
                <div class="slide-bg" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                    <img src="{{ asset('images/banner/2.png') }}" alt="Banner 2" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400/ffffff/333333?text=Banner+2';">
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="slider-item">
                <div class="slide-bg" style="background: linear-gradient(45deg, #667eea, #764ba2);">
                    <img src="{{ asset('images/banner/3.png') }}" alt="Banner 3" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400/ffffff/333333?text=Banner+3';">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SHOP BY CATEGORY SECTION - DYNAMIC FROM ADMIN
     ============================================ -->
<section class="category-section py-5">
    <div class="container">
        <div class="section-title text-center mb-4">
            <h2 class="fw-bold">Shop by Category</h2>
            <p class="text-muted">Explore our wide range of categories</p>
        </div>
        
        <div class="category-slider-container position-relative">
            <div class="category-nav custom-nav-prev">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="category-nav custom-nav-next">
                <i class="fas fa-chevron-right"></i>
            </div>
            
            <div class="category-slider owl-carousel owl-theme">
                @forelse($homeCategories as $item)
                <!-- Category Item -->
                <div class="category-item">
                    <a href="{{ $item->url }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ $item->display_image }}" 
                                     alt="{{ $item->display_name }}"
                                     loading="lazy">
                            </div>
                            <div class="category-name">
                                <span>{{ $item->display_name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <!-- Fallback if no categories in database -->
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=1" alt="Fashion">
                            </div>
                            <div class="category-name">
                                <span>Fashion</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=2" alt="Electronics">
                            </div>
                            <div class="category-name">
                                <span>Electronics</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=3" alt="Home & Kitchen">
                            </div>
                            <div class="category-name">
                                <span>Home & Kitchen</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=4" alt="Books">
                            </div>
                            <div class="category-name">
                                <span>Books</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=5" alt="Sports">
                            </div>
                            <div class="category-name">
                                <span>Sports</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="https://picsum.photos/200/200?random=6" alt="Toys & Baby">
                            </div>
                            <div class="category-name">
                                <span>Toys & Baby</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Products Slider Section -->
<section class="products-section py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="animate__animated animate__fadeInUp">Featured Products</h2>
            <p class="text-muted animate__animated animate__fadeInUp animate__delay-1s">Check out our latest products</p>
        </div>
        <div class="product-slider owl-carousel owl-theme">
            @foreach($featuredProducts as $product)
            <!-- Product -->
            <div class="product-item">
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
                        <a href="{{ route('product.detail', ['id' => $product['id'], 'slug' => $product['slug'] ?? Str::slug($product['name'])]) }}">
                            <h3 class="product-title">{{ $product['name'] }}</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹{{ number_format($product['price']) }}</span>
                            <span class="original-price">₹{{ number_format($product['original_price']) }}</span>
                            <span class="discount">{{ $product['discount'] }}% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="{{ $product['id'] }}" 
                                data-name="{{ $product['name'] }}" 
                                data-brand="{{ $product['brand'] }}" 
                                data-price="{{ $product['price'] }}" 
                                data-image="{{ $product['image'] }}">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.category-card {
    text-align: center;
    padding: 15px 10px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    margin: 5px;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.category-image {
    width: 120px;
    height: 120px;
    margin: 0 auto 15px;
    border-radius: 50%;
    overflow: hidden;
    background: #f5f5f5;
    border: 3px solid #febd69;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-name span {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-link {
    text-decoration: none;
}

.category-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.category-nav:hover {
    background: #febd69;
    color: #131921;
}

.custom-nav-prev {
    left: -20px;
}

.custom-nav-next {
    right: -20px;
}

/* Modern Product Card */
.modern-product-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
}

.modern-product-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}

.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff4d4d;
    color: white;
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 3px;
    z-index: 2;
}

.product-badge.trending {
    background: #ff8c42;
}

.product-badge.new {
    background: #4caf50;
}

.product-image {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.modern-product-card:hover .product-image img {
    transform: scale(1.05);
}

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
}

.modern-product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #fff;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: #febd69;
    color: #131921;
}

.product-info {
    padding: 15px;
}

.brand-name {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    line-height: 1.3;
    height: 36px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.price-section {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 10px;
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
}

.add-to-cart-btn {
    width: 100%;
    background: transparent;
    border: 2px solid #333;
    color: #333;
    padding: 8px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: #333;
    color: #fff;
}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        'use strict';
        
        // Main Banner Slider
        $('.main-slider').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 1000,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsive: {
                0: { nav: false, dots: true },
                768: { nav: true, dots: true }
            }
        });
        
        // Category Slider
        $('.category-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            smartSpeed: 800,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsive: {
                0: { items: 2, nav: false, dots: true },
                576: { items: 3, nav: false, dots: true },
                768: { items: 4, nav: true, dots: false },
                992: { items: 5, nav: true, dots: false },
                1200: { items: 6, nav: true, dots: false }
            }
        });
        
        // Products Slider
        $('.product-slider').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            smartSpeed: 800,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsive: {
                0: { items: 1, nav: false, dots: true },
                576: { items: 2, nav: false, dots: true },
                768: { items: 3, nav: true, dots: false },
                992: { items: 4, nav: true, dots: false }
            }
        });

        // Add to Cart
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
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