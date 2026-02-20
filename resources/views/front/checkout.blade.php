@extends('layouts.master')

@section('title', 'Checkout - Complete Your Order')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/cart') }}" class="text-decoration-none">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Checkout Progress -->
<section class="checkout-progress py-3">
    <div class="container">
        <div class="progress-steps">
            <div class="row">
                <div class="col-4">
                    <div class="step-item completed">
                        <div class="step-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="step-text">Cart</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="step-item active">
                        <div class="step-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="step-text">Checkout</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="step-item">
                        <div class="step-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="step-text">Payment</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Main Section -->
<section class="checkout-section py-4">
    <div class="container">
        <div class="row">
            <!-- Left Column - Checkout Forms -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- Delivery Address Section -->
                <div class="checkout-card mb-3">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Delivery Address
                            </h5>
                            <button class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                + Add New Address
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="address-list">
                                <!-- Default Address -->
                                <div class="address-item mb-3 p-3 border rounded selected">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="deliveryAddress" id="address1" checked>
                                        <label class="form-check-label w-100" for="address1">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>Rahul Sharma</strong>
                                                    <span class="badge bg-success ms-2">HOME</span>
                                                </div>
                                                <div class="address-actions">
                                                    <button class="btn btn-sm btn-outline-primary me-2">Edit</button>
                                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                                </div>
                                            </div>
                                            <p class="mb-1 mt-2">
                                                House No. 123, ABC Colony, Near City Hospital,<br>
                                                Guwahati, Assam - 781030
                                            </p>
                                            <p class="mb-0">
                                                <i class="fas fa-phone-alt me-2"></i>
                                                +91 98765 43210
                                            </p>
                                        </label>
                                    </div>
                                </div>

                                <!-- Another Address -->
                                <div class="address-item mb-3 p-3 border rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="deliveryAddress" id="address2">
                                        <label class="form-check-label w-100" for="address2">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>Rahul Sharma (Office)</strong>
                                                    <span class="badge bg-info ms-2">OFFICE</span>
                                                </div>
                                                <div class="address-actions">
                                                    <button class="btn btn-sm btn-outline-primary me-2">Edit</button>
                                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                                </div>
                                            </div>
                                            <p class="mb-1 mt-2">
                                                Tech Park, 5th Floor, Block B,<br>
                                                GS Road, Guwahati, Assam - 781005
                                            </p>
                                            <p class="mb-0">
                                                <i class="fas fa-phone-alt me-2"></i>
                                                +91 98765 43210
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Options -->
                <div class="checkout-card mb-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-truck text-primary me-2"></i>
                                Delivery Options
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="delivery-options">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="deliveryOption" id="standardDelivery" checked>
                                    <label class="form-check-label w-100" for="standardDelivery">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Standard Delivery</strong>
                                                <p class="mb-0 small text-muted">Get it by {{ date('d M Y', strtotime('+5 days')) }}</p>
                                            </div>
                                            <span class="text-success">FREE</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="deliveryOption" id="expressDelivery">
                                    <label class="form-check-label w-100" for="expressDelivery">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Express Delivery</strong>
                                                <p class="mb-0 small text-muted">Get it by {{ date('d M Y', strtotime('+2 days')) }}</p>
                                            </div>
                                            <span>₹99</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deliveryOption" id="sameDayDelivery">
                                    <label class="form-check-label w-100" for="sameDayDelivery">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Same Day Delivery</strong>
                                                <p class="mb-0 small text-muted">Get it today (order before 2 PM)</p>
                                            </div>
                                            <span>₹199</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card mb-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                Payment Method
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="payment-methods">
                                <!-- UPI -->
                                <div class="payment-item mb-3 p-3 border rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="upi" checked>
                                        <label class="form-check-label w-100" for="upi">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-mobile-alt fa-2x me-3 text-primary"></i>
                                                <div>
                                                    <strong>UPI</strong>
                                                    <p class="mb-0 small text-muted">Pay using Google Pay, PhonePe, Paytm</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Credit/Debit Card -->
                                <div class="payment-item mb-3 p-3 border rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="card">
                                        <label class="form-check-label w-100" for="card">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-credit-card fa-2x me-3 text-primary"></i>
                                                <div>
                                                    <strong>Credit/Debit Card</strong>
                                                    <p class="mb-0 small text-muted">Visa, MasterCard, RuPay, American Express</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Net Banking -->
                                <div class="payment-item mb-3 p-3 border rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="netbanking">
                                        <label class="form-check-label w-100" for="netbanking">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-university fa-2x me-3 text-primary"></i>
                                                <div>
                                                    <strong>Net Banking</strong>
                                                    <p class="mb-0 small text-muted">All major banks supported</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Cash on Delivery -->
                                <div class="payment-item p-3 border rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="cod">
                                        <label class="form-check-label w-100" for="cod">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-wave fa-2x me-3 text-primary"></i>
                                                <div>
                                                    <strong>Cash on Delivery</strong>
                                                    <p class="mb-0 small text-muted">Pay when you receive your order</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary (Mobile) -->
                <div class="checkout-card d-lg-none mb-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-bag text-primary me-2"></i>
                                Order Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="order-items mb-3">
                                @php
                                    $cart = Session::get('cart', []);
                                    $subtotal = 0;
                                    foreach($cart as $item) {
                                        $subtotal += $item['price'] * $item['quantity'];
                                    }
                                @endphp

                                @foreach($cart as $item)
                                <div class="order-item d-flex mb-2">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-2">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 small">{{ $item['name'] }}</h6>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <span>₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="price-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>₹{{ number_format($subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Delivery</span>
                                    <span class="text-success">FREE</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (5% GST)</span>
                                    <span>₹{{ number_format(round($subtotal * 0.05)) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span class="text-primary">₹{{ number_format($subtotal + round($subtotal * 0.05)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="checkout-actions d-flex justify-content-between">
                    <a href="{{ url('/cart') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Cart
                    </a>
                    <button class="btn btn-primary" id="placeOrderBtn">
                        <i class="fas fa-check-circle me-2"></i>
                        Place Order
                    </button>
                </div>
            </div>

            <!-- Right Column - Order Summary (Desktop) -->
            <div class="col-lg-4">
                <div class="checkout-summary sticky-top" style="top: 20px;">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="order-items mb-3" style="max-height: 300px; overflow-y: auto;">
                                @php
                                    $cart = Session::get('cart', []);
                                    $subtotal = 0;
                                    foreach($cart as $item) {
                                        $subtotal += $item['price'] * $item['quantity'];
                                    }
                                @endphp

                                @forelse($cart as $item)
                                <div class="order-item d-flex mb-3 pb-2 border-bottom">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted d-block">Qty: {{ $item['quantity'] }}</small>
                                        <span class="fw-bold">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-3">
                                    <p class="text-muted mb-0">Your cart is empty</p>
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-sm mt-2">Continue Shopping</a>
                                </div>
                                @endforelse
                            </div>

                            @if(!empty($cart))
                            <div class="price-details">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₹{{ number_format($subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Delivery Charges</span>
                                    <span class="text-success">FREE</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">GST (5%)</span>
                                    <span>₹{{ number_format(round($subtotal * 0.05)) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total Amount</strong>
                                    <strong class="text-primary h5 mb-0">₹{{ number_format($subtotal + round($subtotal * 0.05)) }}</strong>
                                </div>

                                <!-- Coupon Input -->
                                <div class="coupon-input mt-3">
                                    <label class="form-label fw-bold">Have a coupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter coupon code" id="checkoutCoupon">
                                        <button class="btn btn-outline-primary" type="button" id="applyCheckoutCoupon">Apply</button>
                                    </div>
                                </div>

                                <!-- Place Order Button (Desktop) -->
                                <button class="btn btn-primary w-100 py-3 fw-bold mt-3" id="placeOrderDesktopBtn">
                                    <i class="fas fa-lock me-2"></i>
                                    PLACE ORDER
                                </button>

                                <!-- Secure Payment Info -->
                                <div class="secure-payment text-center mt-3 small text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Your payment information is secure
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAddressForm">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control" id="mobile" placeholder="10-digit mobile number" maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" placeholder="6-digit pincode" maxlength="6">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" rows="2" placeholder="House/Flat No., Colony, Street"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="locality" class="form-label">Locality</label>
                        <input type="text" class="form-control" id="locality" placeholder="Locality / Area">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" placeholder="City">
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select" id="state">
                                <option value="">Select State</option>
                                <option value="Assam">Assam</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="West Bengal">West Bengal</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Type</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addressType" id="typeHome" value="home" checked>
                                <label class="form-check-label" for="typeHome">Home</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addressType" id="typeOffice" value="office">
                                <label class="form-check-label" for="typeOffice">Office</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addressType" id="typeOther" value="other">
                                <label class="form-check-label" for="typeOther">Other</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAddressBtn">Save Address</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Success Modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle text-success fa-5x"></i>
                </div>
                <h3 class="mb-3">Order Placed Successfully!</h3>
                <p class="text-muted mb-4">Your order has been placed successfully. You will receive an order confirmation shortly.</p>
                <div class="order-number bg-light p-3 rounded mb-4">
                    <small class="text-muted d-block">Order Number</small>
                    <strong class="h5">#ORD{{ rand(10000, 99999) }}</strong>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Checkout Progress */
.progress-steps {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.step-item {
    text-align: center;
    position: relative;
}

.step-item .step-icon {
    width: 50px;
    height: 50px;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: #999;
    transition: all 0.3s ease;
}

.step-item.active .step-icon {
    background: #febd69;
    color: #131921;
}

.step-item.completed .step-icon {
    background: #4caf50;
    color: white;
}

.step-item .step-text {
    font-size: 14px;
    font-weight: 500;
    color: #666;
}

.step-item.active .step-text {
    color: #febd69;
    font-weight: 600;
}

.step-item.completed .step-text {
    color: #4caf50;
}

/* Checkout Cards */
.checkout-card .card {
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.checkout-card .card-header {
    border-bottom: 1px solid #f0f0f0;
    padding: 15px 20px;
}

/* Address Item */
.address-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.address-item:hover {
    border-color: #febd69 !important;
    background: #fff9f0;
}

.address-item.selected {
    border-color: #febd69 !important;
    background: #fff9f0;
}

.address-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.address-item:hover .address-actions {
    opacity: 1;
}

/* Payment Methods */
.payment-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-item:hover {
    border-color: #febd69 !important;
    background: #fff9f0;
}

/* Checkout Summary */
.checkout-summary .card {
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Order Items Scroll */
.order-items::-webkit-scrollbar {
    width: 5px;
}

.order-items::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.order-items::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

/* Success Modal */
.success-icon {
    animation: scaleIn 0.5s ease;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .step-item .step-icon {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .step-item .step-text {
        font-size: 12px;
    }
    
    .address-actions {
        opacity: 1;
    }
    
    .address-actions .btn {
        padding: 2px 8px;
        font-size: 11px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Address selection
    $('.address-item').on('click', function() {
        $('.address-item').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });
    
    // Payment method selection
    $('.payment-item').on('click', function() {
        $(this).find('input[type="radio"]').prop('checked', true);
    });
    
    // Save address
    $('#saveAddressBtn').on('click', function() {
        // Validate form (simple validation)
        let name = $('#fullName').val();
        let mobile = $('#mobile').val();
        let pincode = $('#pincode').val();
        
        if (!name || !mobile || !pincode) {
            alert('Please fill all required fields');
            return;
        }
        
        if (mobile.length !== 10) {
            alert('Please enter valid 10-digit mobile number');
            return;
        }
        
        if (pincode.length !== 6) {
            alert('Please enter valid 6-digit pincode');
            return;
        }
        
        // Success message
        showNotification('Address added successfully!', 'success');
        $('#addAddressModal').modal('hide');
        
        // Reset form
        $('#addAddressForm')[0].reset();
    });
    
    // Apply coupon
    $('#applyCheckoutCoupon').on('click', function() {
        let coupon = $('#checkoutCoupon').val();
        
        if (!coupon) {
            showNotification('Please enter a coupon code', 'warning');
            return;
        }
        
        showNotification('Coupon applied successfully!', 'success');
    });
    
    // Place order
    $('#placeOrderBtn, #placeOrderDesktopBtn').on('click', function() {
        // Check if cart is empty
        let cartItems = {{ json_encode(!empty($cart)) }};
        
        if (!cartItems) {
            showNotification('Your cart is empty!', 'warning');
            return;
        }
        
        // Show success modal
        $('#orderSuccessModal').modal('show');
        
        // Clear cart after order placement (optional)
        setTimeout(function() {
            // You can add AJAX call to clear cart here
            console.log('Order placed successfully!');
        }, 1000);
    });
    
    // Notification function
    function showNotification(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            alert(message);
        }
    }
    
    // Mobile number validation
    $('#mobile').on('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
    
    // Pincode validation
    $('#pincode').on('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
});
</script>
@endpush