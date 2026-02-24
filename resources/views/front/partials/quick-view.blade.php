<div class="row">
    <div class="col-md-6">
        <img src="{{ $product->main_image ?? 'https://picsum.photos/500/500?random='.$product->id }}" 
             alt="{{ $product->name }}" 
             class="img-fluid rounded">
    </div>
    <div class="col-md-6">
        <p class="brand-name mb-1">{{ $product->brand }}</p>
        <h5 class="mb-2">{{ $product->name }}</h5>
        <div class="product-rating mb-2">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($product->rating))
                    <i class="fas fa-star text-warning"></i>
                @elseif($i == ceil($product->rating) && $product->rating - floor($product->rating) >= 0.5)
                    <i class="fas fa-star-half-alt text-warning"></i>
                @else
                    <i class="far fa-star text-warning"></i>
                @endif
            @endfor
            <span class="rating-count">({{ number_format($product->reviews_count) }} reviews)</span>
        </div>
        <div class="price-section mb-3">
            <span class="current-price h4">₹{{ number_format($product->price) }}</span>
            @if($product->original_price && $product->original_price > $product->price)
                <span class="original-price ms-2">₹{{ number_format($product->original_price) }}</span>
                <span class="discount ms-2">{{ $product->discount_percentage }}% off</span>
            @endif
        </div>
        <p class="text-success"><i class="fas fa-check-circle"></i> In Stock</p>
        <div class="d-grid gap-2">
            <button class="btn btn-add-to-cart quick-add-to-cart" 
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

<script>
$(document).ready(function() {
    $('.quick-add-to-cart').on('click', function(e) {
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
                    
                    // Close modal
                    $('#quickViewModal').modal('hide');
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    }
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                }
            },
            error: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
                
                if (typeof toastr !== 'undefined') {
                    toastr.error('Error adding to cart');
                }
            }
        });
    });
});
</script>