@extends('layouts.master')

@section('title', 'Checkout - Complete Your Order')

@php
    $cart = Session::get('cart', []);
    $subtotal = 0;
    foreach($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $deliveryCharge = $subtotal >= 499 ? 0 : 40;
    $tax = round($subtotal * 0.05);
    $total = $subtotal + $deliveryCharge + $tax;
@endphp

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none">Cart</a></li>
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
        <form id="checkoutForm">
            @csrf
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
                                <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    + Add New Address
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="address-list">
                                    @forelse($addresses as $address)
                                    <div class="address-item mb-3 p-3 border rounded {{ $address->is_default ? 'selected' : '' }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address_id" 
                                                   id="address{{ $address->id }}" value="{{ $address->id }}"
                                                   {{ $address->is_default ? 'checked' : '' }} required>
                                            <label class="form-check-label w-100" for="address{{ $address->id }}">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>{{ $address->name }}</strong>
                                                        <span class="badge bg-{{ $address->type == 'home' ? 'success' : ($address->type == 'office' ? 'info' : 'secondary') }} ms-2">
                                                            {{ strtoupper($address->type) }}
                                                        </span>
                                                        @if($address->is_default)
                                                        <span class="badge bg-primary ms-2">DEFAULT</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mb-1 mt-2">
                                                    {{ $address->address_line1 }}<br>
                                                    @if($address->address_line2)
                                                        {{ $address->address_line2 }}<br>
                                                    @endif
                                                    @if($address->landmark)
                                                        Near {{ $address->landmark }}<br>
                                                    @endif
                                                    {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                                </p>
                                                <p class="mb-0">
                                                    <i class="fas fa-phone-alt me-2"></i>
                                                    +91 {{ $address->phone }}
                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-3">
                                        <p class="text-muted mb-3">No addresses found. Please add an address.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                            Add New Address
                                        </button>
                                    </div>
                                    @endforelse
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
                                        <input class="form-check-input" type="radio" name="delivery_option" 
                                               id="standardDelivery" value="standard" checked>
                                        <label class="form-check-label w-100" for="standardDelivery">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>Standard Delivery</strong>
                                                    <p class="mb-0 small text-muted">Get it by {{ date('d M Y', strtotime('+5 days')) }}</p>
                                                </div>
                                                @if($subtotal >= 499)
                                                <span class="text-success">FREE</span>
                                                @else
                                                <span>₹40</span>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="delivery_option" 
                                               id="expressDelivery" value="express">
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
                                        <input class="form-check-input" type="radio" name="delivery_option" 
                                               id="sameDayDelivery" value="sameday">
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
                                            <input class="form-check-input" type="radio" name="payment_method" 
                                                   id="upi" value="upi" checked>
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
                                            <input class="form-check-input" type="radio" name="payment_method" 
                                                   id="card" value="card">
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
                                            <input class="form-check-input" type="radio" name="payment_method" 
                                                   id="netbanking" value="netbanking">
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
                                            <input class="form-check-input" type="radio" name="payment_method" 
                                                   id="cod" value="cod">
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

                    <!-- Order Notes -->
                    <div class="checkout-card mb-3">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-pen text-primary me-2"></i>
                                    Order Notes (Optional)
                                </h5>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="notes" rows="2" 
                                          placeholder="Any special instructions for delivery?"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="checkout-actions d-flex justify-content-between">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Cart
                        </a>
                        <button type="submit" class="btn btn-primary" id="placeOrderBtn">
                            <i class="fas fa-check-circle me-2"></i>
                            Place Order
                        </button>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-lg-4">
                    <div class="checkout-summary sticky-top" style="top: 20px;">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="order-items mb-3" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($cart as $item)
                                    <div class="order-item d-flex mb-3 pb-2 border-bottom">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item['name'] }}</h6>
                                            <small class="text-muted d-block">Qty: {{ $item['quantity'] }}</small>
                                            <span class="fw-bold">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="price-details">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span>₹{{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Delivery Charges</span>
                                        <span class="delivery-charge-display">
                                            @if($deliveryCharge > 0)
                                                ₹{{ $deliveryCharge }}
                                            @else
                                                FREE
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">GST (5%)</span>
                                        <span>₹{{ number_format($tax) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Total Amount</strong>
                                        <strong class="text-primary h5 mb-0 total-amount">
                                            ₹{{ number_format($total) }}
                                        </strong>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold mt-3" id="placeOrderDesktopBtn">
                                    <i class="fas fa-lock me-2"></i>
                                    PLACE ORDER
                                </button>

                                <div class="secure-payment text-center mt-3 small text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Your payment information is secure
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addAddressForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" maxlength="6" required>
                    </div>
                    <div class="mb-3">
                        <label for="address_line1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="address_line1" name="address_line1" required>
                    </div>
                    <div class="mb-3">
                        <label for="address_line2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="address_line2" name="address_line2">
                    </div>
                    <div class="mb-3">
                        <label for="landmark" class="form-label">Landmark</label>
                        <input type="text" class="form-control" id="landmark" name="landmark">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Type</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="typeHome" value="home" checked>
                                <label class="form-check-label" for="typeHome">Home</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="typeOffice" value="office">
                                <label class="form-check-label" for="typeOffice">Office</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="typeOther" value="other">
                                <label class="form-check-label" for="typeOther">Other</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_default" id="isDefault" value="1">
                        <label class="form-check-label" for="isDefault">Set as default address</label>
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
                    <strong class="h5" id="orderNumberDisplay">#ORD12345</strong>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ url('/') }}" class="btn btn-primary" id="continueShoppingBtn">Continue Shopping</a>
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-primary">View Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

.checkout-card .card {
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

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

.payment-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-item:hover {
    border-color: #febd69 !important;
    background: #fff9f0;
}

.checkout-summary .card {
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.success-icon {
    animation: scaleIn 0.5s ease;
}

@keyframes scaleIn {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); opacity: 1; }
}

@media (max-width: 768px) {
    .step-item .step-icon {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .step-item .step-text {
        font-size: 12px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Global notification function
function showNotification(message, type = 'info') {
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(message);
    }
}

$(document).ready(function() {
    console.log('✅ Checkout page loaded');
    console.log('📍 Process URL: {{ route("checkout.process") }}');
    
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

    // Delivery option change
    $('input[name="delivery_option"]').on('change', function() {
        let deliveryOption = $(this).val();
        let subtotal = {{ $subtotal }};
        let deliveryCharge = 40;
        
        if (deliveryOption === 'express') {
            deliveryCharge = 99;
        } else if (deliveryOption === 'sameday') {
            deliveryCharge = 199;
        } else if (deliveryOption === 'standard' && subtotal >= 499) {
            deliveryCharge = 0;
        }
        
        let tax = Math.round(subtotal * 0.05);
        let total = subtotal + deliveryCharge + tax;
        
        $('.delivery-charge-display').text(deliveryCharge === 0 ? 'FREE' : '₹' + deliveryCharge);
        $('.total-amount').text('₹' + total.toLocaleString());
    });

    // ============================================
    // FIXED: Place Order Form Submission
    // ============================================
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate address
        if (!$('input[name="address_id"]:checked').val()) {
            showNotification('Please select a delivery address', 'warning');
            return;
        }
        
        // Validate payment method
        if (!$('input[name="payment_method"]:checked').val()) {
            showNotification('Please select a payment method', 'warning');
            return;
        }
        
        // Validate delivery option
        if (!$('input[name="delivery_option"]:checked').val()) {
            showNotification('Please select a delivery option', 'warning');
            return;
        }
        
        console.log('📦 Submitting order...');
        
        let formData = {
            address_id: $('input[name="address_id"]:checked').val(),
            payment_method: $('input[name="payment_method"]:checked').val(),
            delivery_option: $('input[name="delivery_option"]:checked').val(),
            notes: $('textarea[name="notes"]').val(),
            _token: '{{ csrf_token() }}'
        };
        
        console.log('📝 Form data:', formData);
        
        let btn = $('#placeOrderBtn, #placeOrderDesktopBtn');
        let originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("checkout.process") }}',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('✅ Order success:', response);
                
                if (response.success) {
                    // Show order number
                    $('#orderNumberDisplay').text('#' + response.order_number);
                    
                    // Show success modal
                    $('#orderSuccessModal').modal('show');
                    
                    // Update cart count
                    $('.cart-count, .mobile-cart-count').text(0);
                    
                    showNotification(response.message, 'success');
                    
                    // Redirect after modal closes
                    $('#orderSuccessModal').on('hidden.bs.modal', function () {
                        window.location.href = response.redirect;
                    });
                }
            },
            error: function(xhr) {
                console.error('❌ Order error:', xhr);
                
                btn.html(originalText);
                btn.prop('disabled', false);
                
                let errorMessage = 'Failed to place order.';
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    $.each(errors, function(key, value) {
                        errorMessages.push(value[0]);
                    });
                    errorMessage = errorMessages.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });

    // ============================================
    // FIXED: Save Address
    // ============================================
    $('#saveAddressBtn').on('click', function() {
        let formData = $('#addAddressForm').serialize();
        
        $.ajax({
            url: '{{ route("address.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    $('#addAddressModal').modal('hide');
                    
                    // Reload to show new address
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                let message = 'Failed to add address';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showNotification(message, 'error');
            }
        });
    });

    // Continue shopping
    $('#continueShoppingBtn').on('click', function(e) {
        e.preventDefault();
        window.location.href = '{{ url("/") }}';
    });

    // Phone validation
    $('#phone, #mobile').on('keypress', function(e) {
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