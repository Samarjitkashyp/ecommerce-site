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

<!-- Category Slider Section -->
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
                <!-- Categories -->
                <div class="category-item">
                    <a href="{{ route('category', 'fashion') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/1.png') }}" alt="Fashion">
                            </div>
                            <div class="category-name">
                                <span>Fashion</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'travel') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/2.png') }}" alt="Travel">
                            </div>
                            <div class="category-name">
                                <span>Travel</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'electronics') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/3.png') }}" alt="Electronics">
                            </div>
                            <div class="category-name">
                                <span>Electronics</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'home-kitchen') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/4.png') }}" alt="Home & Kitchen">
                            </div>
                            <div class="category-name">
                                <span>Home & kitchen</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'auto-accessories') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/1.png') }}" alt="Auto Accessories">
                            </div>
                            <div class="category-name">
                                <span>Auto Acc</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'toys-baby') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/2.png') }}" alt="Toys & Baby">
                            </div>
                            <div class="category-name">
                                <span>Toys, Baby...</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'genz-trends') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/3.png') }}" alt="GenZ Trends">
                            </div>
                            <div class="category-name">
                                <span>GenZ Trends</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'next-gen') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/4.png') }}" alt="Next Gen">
                            </div>
                            <div class="category-name">
                                <span>Next Gen</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'sports') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/1.png') }}" alt="Sports">
                            </div>
                            <div class="category-name">
                                <span>Sports</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="category-item">
                    <a href="{{ route('category', 'books') }}" class="category-link">
                        <div class="category-card">
                            <div class="category-image">
                                <img src="{{ asset('images/category-slider/2.png') }}" alt="Books">
                            </div>
                            <div class="category-name">
                                <span>Books</span>
                            </div>
                        </div>
                    </a>
                </div>
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
            <!-- Product 1 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge">BESTSELLER</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=201" alt="Product 1">
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
                        <div class="brand-name">Jack & Jones</div>
                        <a href="{{ route('product.detail', ['id' => 1, 'slug' => 'mens-printed-cotton-tshirt']) }}">
                            <h3 class="product-title">Multi-Color Abstract Print Sliders</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹1,190</span>
                            <span class="original-price">₹1,699</span>
                            <span class="discount">30% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="1" 
                                data-name="Multi-Color Abstract Print Sliders" 
                                data-brand="Jack & Jones" 
                                data-price="1190" 
                                data-image="https://picsum.photos/300/300?random=201">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge trending">TRENDING</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=202" alt="Product 2">
                        <div class="product-actions">
                            <button class="action-btn wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">Puma</div>
                        <a href="{{ route('product.detail', ['id' => 2, 'slug' => 'mens-running-shoes']) }}">
                            <h3 class="product-title">Men's Running Shoes | Lightweight | White/Black</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹2,499</span>
                            <span class="original-price">₹3,999</span>
                            <span class="discount">37% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="2" 
                                data-name="Men's Running Shoes" 
                                data-brand="Puma" 
                                data-price="2499" 
                                data-image="https://picsum.photos/300/300?random=202">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge new">NEW</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=203" alt="Product 3">
                        <div class="product-actions">
                            <button class="action-btn wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">Nike</div>
                        <a href="{{ route('product.detail', ['id' => 3, 'slug' => 'mens-solid-tshirt']) }}">
                            <h3 class="product-title">Men's Solid Regular Fit T-Shirt | Pure Cotton</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹1,799</span>
                            <span class="original-price">₹2,499</span>
                            <span class="discount">28% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="3" 
                                data-name="Men's Solid Regular Fit T-Shirt" 
                                data-brand="Nike" 
                                data-price="1799" 
                                data-image="https://picsum.photos/300/300?random=203">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 4 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge">BESTSELLER</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=204" alt="Product 4">
                        <div class="product-actions">
                            <button class="action-btn wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">Levi's</div>
                        <a href="{{ route('product.detail', ['id' => 4, 'slug' => 'womens-skinny-jeans']) }}">
                            <h3 class="product-title">Women's Skinny Fit Jeans | Stretchable | Blue</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹2,299</span>
                            <span class="original-price">₹3,299</span>
                            <span class="discount">30% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="4" 
                                data-name="Women's Skinny Fit Jeans" 
                                data-brand="Levi's" 
                                data-price="2299" 
                                data-image="https://picsum.photos/300/300?random=204">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 5 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge trending">TRENDING</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=205" alt="Product 5">
                        <div class="product-actions">
                            <button class="action-btn wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">Sony</div>
                        <a href="{{ route('product.detail', ['id' => 5, 'slug' => 'wireless-headphones']) }}">
                            <h3 class="product-title">Wireless Bluetooth Headphones | Noise Cancelling</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹3,999</span>
                            <span class="original-price">₹5,999</span>
                            <span class="discount">33% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="5" 
                                data-name="Wireless Bluetooth Headphones" 
                                data-brand="Sony" 
                                data-price="3999" 
                                data-image="https://picsum.photos/300/300?random=205">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 6 -->
            <div class="product-item">
                <div class="modern-product-card">
                    <div class="product-badge new">NEW</div>
                    <div class="product-image">
                        <img src="https://picsum.photos/300/300?random=206" alt="Product 6">
                        <div class="product-actions">
                            <button class="action-btn wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="brand-name">Fastrack</div>
                        <a href="{{ route('product.detail', ['id' => 6, 'slug' => 'mens-analog-watch']) }}">
                            <h3 class="product-title">Analog Watch - Men | Black Dial | Stainless Steel</h3>
                        </a>
                        <div class="price-section">
                            <span class="current-price">₹1,995</span>
                            <span class="original-price">₹2,995</span>
                            <span class="discount">33% off</span>
                        </div>
                        <button class="add-to-cart-btn" 
                                data-id="6" 
                                data-name="Analog Watch - Men" 
                                data-brand="Fastrack" 
                                data-price="1995" 
                                data-image="https://picsum.photos/300/300?random=206">
                            <i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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
            
            console.log('Adding to cart:', {id, name, brand, price, image});
            
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
                        
                        // Animate cart
                        $('.cart-wrapper').addClass('animate__animated animate__rubberBand');
                        setTimeout(function() {
                            $('.cart-wrapper').removeClass('animate__animated animate__rubberBand');
                        }, 1000);
                        
                        // Show success message
                        showNotification(response.message, 'success');
                        
                        // Redirect to cart page
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
        
        // Notification function
        function showNotification(message, type = 'info') {
            if (typeof toastr !== 'undefined') {
                toastr[type](message);
            } else {
                alert(message);
            }
        }
    });
</script>
@endpush