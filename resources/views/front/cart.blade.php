@extends('layouts.master')

@section('title', 'Shopping Cart')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Cart Main Section -->
<section class="cart-section py-4">
    <div class="container">
        <div class="row">
            <!-- Cart Items Column -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- Cart Header -->
                <div class="cart-header d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">My Cart <span class="cart-count-badge" id="cartCountHeader">({{ array_sum(array_column($cart, 'quantity')) }} items)</span></h4>
                    @if(!empty($cart))
                    <button class="btn btn-link text-decoration-none text-danger" id="clearCartBtn">
                        <i class="fas fa-trash-alt"></i> Clear Cart
                    </button>
                    @endif
                </div>
                
                <!-- Delivery Address Card -->
                <div class="address-card mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="address-icon me-3">
                                    <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                </div>
                                <div class="address-details flex-grow-1">
                                    <h6 class="mb-1">Deliver to: <strong>Rahul Sharma, 781030</strong></h6>
                                    <p class="mb-0 text-muted">House No. 123, ABC Colony, Guwahati, Assam - 781030</p>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Change</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cart Items List -->
                <div class="cart-items-container" id="cartItemsContainer">
                    @forelse($cart as $id => $item)
                    <div class="cart-item-card mb-3" data-id="{{ $id }}" id="cart-item-{{ $id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-md-2 col-4 mb-3 mb-md-0">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid rounded">
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="col-md-6 col-8">
                                        <div class="product-details">
                                            <p class="brand-name mb-1">{{ $item['brand'] }}</p>
                                            <h6 class="product-title mb-2">{{ $item['name'] }}</h6>
                                            
                                            <!-- Selected Variants -->
                                            @if(!empty($item['selected_size']) || !empty($item['selected_color']))
                                            <div class="product-variants mb-2">
                                                @if(!empty($item['selected_size']))
                                                <span class="variant-badge">Size: {{ $item['selected_size'] }}</span>
                                                @endif
                                                @if(!empty($item['selected_color']))
                                                <span class="variant-badge">Color: {{ $item['selected_color'] }}</span>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            <!-- Delivery Info -->
                                            <div class="delivery-info">
                                                <i class="fas fa-truck text-success"></i>
                                                <span class="delivery-date">Delivery by {{ $item['delivery_date'] ?? date('d M', strtotime('+3 days')) }}</span>
                                            </div>
                                            
                                            <!-- In Stock -->
                                            <div class="stock-status text-success mt-1">
                                                <i class="fas fa-check-circle"></i> In Stock
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price & Quantity -->
                                    <div class="col-md-4 mt-3 mt-md-0">
                                        <div class="price-section text-md-end">
                                            <div class="current-price mb-2">₹{{ number_format($item['price']) }}</div>
                                            @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                                            <div class="original-price">₹{{ number_format($item['original_price']) }}</div>
                                            <div class="discount">{{ $item['discount'] }}% off</div>
                                            @endif
                                            
                                            <!-- Quantity Selector -->
                                            <div class="quantity-selector mt-3">
                                                <button class="quantity-btn decrease-qty" data-id="{{ $id }}">-</button>
                                                <input type="number" class="quantity-input item-qty" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_quantity'] ?? 10 }}" readonly data-id="{{ $id }}">
                                                <button class="quantity-btn increase-qty" data-id="{{ $id }}">+</button>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="cart-actions mt-3">
                                                <button class="btn btn-sm btn-outline-danger remove-item" data-id="{{ $id }}">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary save-for-later" data-id="{{ $id }}">
                                                    <i class="fas fa-clock"></i> Save for later
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Empty Cart State -->
                    <div class="empty-cart text-center py-5" id="emptyCartMessage">
                        <div class="empty-cart-icon mb-3">
                            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                        </div>
                        <h5>Your cart is empty!</h5>
                        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-home"></i> Continue Shopping
                        </a>
                    </div>
                    @endforelse
                </div>
                
                <!-- Saved for Later Section -->
                @if(!empty($savedForLater))
                <div class="saved-items-section mt-4">
                    <h5 class="mb-3">Saved for Later <span class="text-muted">({{ count($savedForLater) }} items)</span></h5>
                    
                    @foreach($savedForLater as $id => $item)
                    <div class="saved-item-card mb-2" data-id="{{ $id }}">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-6">
                                        <p class="brand-name mb-1">{{ $item['brand'] }}</p>
                                        <h6 class="product-title mb-0">{{ $item['name'] }}</h6>
                                        <div class="price mt-2">
                                            <span class="current-price">₹{{ number_format($item['price']) }}</span>
                                            @if(isset($item['original_price']))
                                            <span class="original-price ms-2">₹{{ number_format($item['original_price']) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <button class="btn btn-sm btn-primary move-to-cart" data-id="{{ $id }}">
                                            <i class="fas fa-shopping-cart"></i> Move to Cart
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger remove-saved mt-2" data-id="{{ $id }}">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <!-- Price Details Column -->
            <div class="col-lg-4">
                <div class="price-details-card sticky-top" style="top: 20px;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Price Details</h5>
                            
                            <div class="price-breakdown">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Price ({{ array_sum(array_column($cart, 'quantity')) }} items)</span>
                                    <span class="subtotal-price" id="subtotalDisplay">₹{{ number_format($subtotal) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount</span>
                                    <span class="text-success discount-amount" id="discountDisplay">− ₹{{ number_format($discount) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Delivery Charges</span>
                                    <span id="deliveryDisplay">
                                        @if($deliveryCharge > 0)
                                        ₹{{ number_format($deliveryCharge) }}
                                        @else
                                        <span class="text-success">Free</span>
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-3">
                                    <span>GST (5%)</span>
                                    <span id="taxDisplay">₹{{ number_format($tax) }}</span>
                                </div>
                                
                                <hr>
                                
                                <div class="d-flex justify-content-between mb-3 fw-bold">
                                    <span>Total Amount</span>
                                    <span class="total-price" id="totalDisplay">₹{{ number_format($total) }}</span>
                                </div>
                                
                                @if($deliveryCharge > 0)
                                <div class="free-delivery-msg text-success small mb-3">
                                    <i class="fas fa-info-circle"></i>
                                    Add ₹{{ number_format(499 - $subtotal) }} more for FREE Delivery
                                </div>
                                @endif
                                
                                <!-- Coupon Section -->
                                <div class="coupon-section mb-3">
                                    <label class="form-label fw-bold">Apply Coupon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="couponInput" placeholder="Enter coupon code" value="{{ $appliedCoupon['code'] ?? '' }}">
                                        <button class="btn btn-outline-primary" type="button" id="applyCouponBtn">
                                            <i class="fas fa-tag"></i> Apply
                                        </button>
                                    </div>
                                    <div id="couponMessage" class="small mt-2"></div>
                                    
                                    @if($appliedCoupon)
                                    <div class="applied-coupon mt-2 p-2 bg-success text-white rounded">
                                        <i class="fas fa-check-circle"></i>
                                        Coupon {{ $appliedCoupon['code'] }} applied! {{ $appliedCoupon['message'] }}
                                        <button class="btn btn-sm btn-light text-danger float-end" id="removeCouponBtn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Available Offers -->
                                <div class="offers-section mb-3">
                                    <h6 class="mb-2"><i class="fas fa-tag text-primary"></i> Available Offers</h6>
                                    <div class="offer-item small mb-2">
                                        <i class="fas fa-circle text-primary" style="font-size: 8px;"></i>
                                        <span class="ms-2">10% instant discount on HDFC Credit Card</span>
                                    </div>
                                    <div class="offer-item small mb-2">
                                        <i class="fas fa-circle text-primary" style="font-size: 8px;"></i>
                                        <span class="ms-2">Get 5% cashback on UPI payments</span>
                                    </div>
                                    <div class="offer-item small">
                                        <i class="fas fa-circle text-primary" style="font-size: 8px;"></i>
                                        <span class="ms-2">No cost EMI available on select cards</span>
                                    </div>
                                </div>
                                
                                <!-- ============================================
                                     PLACE ORDER BUTTON - FIXED
                                     ============================================ -->
                                @if(!empty($cart))
                                    @if(auth()->check())
                                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-3 fw-bold text-decoration-none" style="display: inline-block; text-align: center;">
                                        <i class="fas fa-bolt"></i> PROCEED TO CHECKOUT
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout')) }}" class="btn btn-primary w-100 py-3 fw-bold text-decoration-none" style="display: inline-block; text-align: center;">
                                        <i class="fas fa-sign-in-alt"></i> LOGIN TO CHECKOUT
                                    </a>
                                    @endif
                                @else
                                <button class="btn btn-primary w-100 py-3 fw-bold" disabled>
                                    <i class="fas fa-bolt"></i> PLACE ORDER
                                </button>
                                @endif
                                
                                <!-- Secure Payment Info -->
                                <div class="secure-payment text-center mt-3 small text-muted">
                                    <i class="fas fa-lock"></i> Secure Payment
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Suggested Products Section -->
        @if(!empty($suggestedProducts))
        <div class="suggested-products-section mt-5">
            <h5 class="mb-3">Frequently Bought Together</h5>
            <div class="suggested-slider owl-carousel owl-theme">
                @foreach($suggestedProducts as $product)
                <div class="suggested-product-item">
                    <div class="card h-100">
                        <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                        <div class="card-body p-2">
                            <p class="brand-name small mb-1">{{ $product['brand'] }}</p>
                            <h6 class="product-title small">{{ $product['name'] }}</h6>
                            <div class="price-section">
                                <span class="current-price">₹{{ number_format($product['price']) }}</span>
                                <span class="original-price small">₹{{ number_format($product['original_price']) }}</span>
                            </div>
                            <div class="rating small">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product['rating']))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i == ceil($product['rating']) && $product['rating'] - floor($product['rating']) >= 0.5)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="text-muted">({{ number_format($product['reviews']) }})</span>
                            </div>
                            <button class="btn btn-sm btn-outline-primary w-100 mt-2 add-suggested" 
                                    data-id="{{ $product['id'] }}"
                                    data-name="{{ $product['name'] }}"
                                    data-brand="{{ $product['brand'] }}"
                                    data-price="{{ $product['price'] }}"
                                    data-image="{{ $product['image'] }}">
                                <i class="fas fa-cart-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
/* Cart Page Styles */
.cart-count-badge {
    font-size: 16px;
    color: #666;
    font-weight: normal;
}

.address-card .card {
    border-left: 4px solid #febd69;
}

.cart-item-card .card {
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.cart-item-card .card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #febd69;
}

.brand-name {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    margin-bottom: 2px;
}

.product-title {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

.variant-badge {
    background: #f5f5f5;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    margin-right: 5px;
}

.delivery-info {
    font-size: 12px;
    color: #666;
}

.delivery-date {
    color: #333;
    font-weight: 500;
    margin-left: 5px;
}

.stock-status {
    font-size: 12px;
}

.price-section .current-price {
    font-size: 18px;
    font-weight: 700;
    color: #333;
}

.price-section .original-price {
    font-size: 13px;
    color: #999;
    text-decoration: line-through;
}

.price-section .discount {
    font-size: 13px;
    color: #ff4d4d;
    font-weight: 600;
}

/* Quantity Selector */
.quantity-selector {
    display: inline-flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 20px;
    overflow: hidden;
    background: white;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    border: none;
    background: #f5f5f5;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    background: #febd69;
}

.quantity-input {
    width: 40px;
    height: 30px;
    border: none;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
}

.quantity-input::-webkit-inner-spin-button,
.quantity-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Cart Actions */
.cart-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.cart-actions .btn {
    font-size: 12px;
    padding: 4px 8px;
}

/* Price Details Card */
.price-details-card {
    position: sticky;
    top: 20px;
}

.price-details-card .card {
    border: 1px solid #f0f0f0;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.price-breakdown {
    font-size: 14px;
}

.total-price {
    font-size: 18px;
    color: #febd69;
}

.free-delivery-msg {
    background: #e8f5e9;
    padding: 8px;
    border-radius: 4px;
}

/* Empty Cart */
.empty-cart {
    background: white;
    border-radius: 8px;
    padding: 50px 20px;
}

.empty-cart-icon {
    color: #ddd;
}

/* Suggested Products */
.suggested-slider .owl-nav {
    position: absolute;
    top: -40px;
    right: 0;
}

.suggested-slider .owl-nav button {
    width: 30px;
    height: 30px;
    background: white !important;
    border-radius: 50% !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-left: 5px;
}

.suggested-slider .owl-nav button:hover {
    background: #febd69 !important;
}

.suggested-product-item .card {
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.suggested-product-item .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #febd69;
}

/* Responsive */
@media (max-width: 768px) {
    .cart-actions {
        justify-content: flex-start;
    }
    
    .price-section.text-md-end {
        text-align: left !important;
    }
    
    .quantity-selector {
        margin-top: 10px;
    }
}

@media (max-width: 576px) {
    .cart-item-card .row > [class*="col-"] {
        margin-bottom: 10px;
    }
    
    .cart-item-card img {
        max-width: 80px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    console.log('✅ Cart page loaded');
    console.log('👤 User logged in: {{ auth()->check() ? 'Yes' : 'No' }}');
    
    // Initialize suggested products slider
    if ($('.suggested-slider').length) {
        $('.suggested-slider').owlCarousel({
            loop: true,
            margin: 15,
            nav: true,
            dots: false,
            responsive: {
                0: { items: 2 },
                576: { items: 3 },
                768: { items: 4 }
            },
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ]
        });
    }
    
    // Increase quantity
    $('.increase-qty').on('click', function() {
        let id = $(this).data('id');
        let input = $(this).siblings('.item-qty');
        let currentVal = parseInt(input.val());
        let maxVal = parseInt(input.attr('max')) || 10;
        
        if (currentVal < maxVal) {
            updateQuantity(id, currentVal + 1);
        }
    });
    
    // Decrease quantity
    $('.decrease-qty').on('click', function() {
        let id = $(this).data('id');
        let input = $(this).siblings('.item-qty');
        let currentVal = parseInt(input.val());
        
        if (currentVal > 1) {
            updateQuantity(id, currentVal - 1);
        }
    });
    
    // Update quantity function
    function updateQuantity(id, newQuantity) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            type: 'POST',
            data: {
                id: id,
                quantity: newQuantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update item quantity
                    $(`#cart-item-${id} .item-qty`).val(newQuantity);
                    
                    // Update item total
                    $(`#cart-item-${id} .current-price`).html(response.item_total_formatted);
                    
                    // Update cart totals
                    $('#subtotalDisplay').html(response.subtotal_formatted);
                    $('#discountDisplay').html('− ' + response.discount_formatted);
                    $('#deliveryDisplay').html(response.delivery_charge === 0 ? '<span class="text-success">Free</span>' : '₹' + response.delivery_charge.toLocaleString());
                    $('#taxDisplay').html(response.tax_formatted);
                    $('#totalDisplay').html(response.total_formatted);
                    $('#cartCountHeader').html(`(${response.cart_count} items)`);
                    
                    // Update cart count in header
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    showNotification('Cart updated!', 'success');
                }
            },
            error: function(xhr) {
                showNotification('Error updating cart', 'error');
            }
        });
    }
    
    // Remove item
    $('.remove-item').on('click', function() {
        let id = $(this).data('id');
        
        if (confirm('Remove this item from cart?')) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $(`#cart-item-${id}`).fadeOut(300, function() {
                            $(this).remove();
                            
                            if (response.cart_empty) {
                                location.reload();
                            } else {
                                // Update cart totals
                                $('#subtotalDisplay').html(response.subtotal_formatted);
                                $('#discountDisplay').html('− ' + response.discount_formatted);
                                $('#deliveryDisplay').html(response.delivery_charge === 0 ? '<span class="text-success">Free</span>' : '₹' + response.delivery_charge.toLocaleString());
                                $('#taxDisplay').html(response.tax_formatted);
                                $('#totalDisplay').html(response.total_formatted);
                                $('#cartCountHeader').html(`(${response.cart_count} items)`);
                                
                                // Update cart count
                                $('.cart-count').text(response.cart_count);
                                $('.mobile-cart-count').text(response.cart_count);
                            }
                            
                            showNotification(response.message, 'success');
                        });
                    }
                }
            });
        }
    });
    
    // Save for later
    $('.save-for-later').on('click', function() {
        let id = $(this).data('id');
        
        $.ajax({
            url: '{{ route("cart.save") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // Move to cart
    $('.move-to-cart').on('click', function() {
        let id = $(this).data('id');
        
        $.ajax({
            url: '{{ route("cart.move") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // Apply coupon
    $('#applyCouponBtn').on('click', function() {
        let coupon = $('#couponInput').val();
        
        if (!coupon) {
            showNotification('Please enter a coupon code', 'warning');
            return;
        }
        
        $.ajax({
            url: '{{ route("cart.coupon.apply") }}',
            type: 'POST',
            data: {
                coupon: coupon,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#couponMessage').html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                    $('#discountDisplay').html('− ' + response.discount_formatted);
                    
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                $('#couponMessage').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> ' + xhr.responseJSON.message + '</span>');
            }
        });
    });
    
    // Remove coupon
    $('#removeCouponBtn').on('click', function() {
        $.ajax({
            url: '{{ route("cart.coupon.remove") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // Clear cart
    $('#clearCartBtn').on('click', function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            $.ajax({
                url: '{{ route("cart.clear") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
    
    // Add suggested product
    $('.add-suggested').on('click', function() {
        let btn = $(this);
        let id = btn.data('id');
        let name = btn.data('name');
        let brand = btn.data('brand');
        let price = btn.data('price');
        let image = btn.data('image');
        
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
                    btn.html('<i class="fas fa-check"></i> Added');
                    btn.removeClass('btn-outline-primary').addClass('btn-success');
                    
                    $('.cart-count').text(response.cart_count);
                    $('.mobile-cart-count').text(response.cart_count);
                    
                    showNotification(response.message, 'success');
                    
                    setTimeout(function() {
                        btn.html('<i class="fas fa-cart-plus"></i> Add');
                        btn.removeClass('btn-success').addClass('btn-outline-primary');
                    }, 2000);
                }
            }
        });
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