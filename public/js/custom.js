/**
 * Custom JavaScript for Amazon Style Website
 * Version: 2.0 - FINAL FIXED
 */

$(document).ready(function() {
    'use strict';
    
    // ============================================
    // INITIALIZE BOOTSTRAP DROPDOWNS
    // ============================================
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
    
    // ============================================
    // CART COUNTER FUNCTIONALITY - FIXED
    // ============================================
    function updateCartCount(count) {
        $('.cart-count').text(count);
        $('.mobile-cart-count').text(count);
    }
    
    // Get initial cart count from server
    $.ajax({
        url: '/cart/count',
        type: 'GET',
        success: function(response) {
            updateCartCount(response.count);
        },
        error: function() {
            console.log('Could not fetch cart count');
        }
    });
    
    // ============================================
    // 🔥 CRITICAL FIX: REMOVED ADD TO CART HANDLER
    // Forms will now submit naturally to the server
    // ============================================
    // (Entire add-to-cart handler removed)
    
    // ============================================
    // SEARCH FUNCTIONALITY
    // ============================================
    function performSearch() {
        let searchTerm = $('#searchInput').val().trim();
        
        if(searchTerm) {
            console.log('Searching for:', searchTerm);
            window.location.href = '/search?q=' + encodeURIComponent(searchTerm);
        } else {
            showNotification('Please enter a search term', 'warning');
        }
    }
    
    $('#searchBtn').on('click', performSearch);
    
    $('#searchInput').on('keypress', function(e) {
        if(e.which === 13) {
            performSearch();
        }
    });
    
    $('#mobileSearch').on('click', function(e) {
        e.preventDefault();
        $('#searchInput').focus();
    });
    
    // ============================================
    // CATEGORY SELECTION
    // ============================================
    $('.search-category-menu .dropdown-item').on('click', function(e) {
        e.preventDefault();
        let selectedCategory = $(this).text();
        $('.search-category-btn').contents().first().replaceWith(selectedCategory);
    });
    
    // ============================================
    // LANGUAGE SELECTION
    // ============================================
    $('.lang-menu .dropdown-item').on('click', function(e) {
        e.preventDefault();
        let selectedLang = $(this).text();
        let langCode = selectedLang.split(' - ')[1] || selectedLang.split(' ')[0];
        $('.lang-selector-btn span').text(langCode);
        showNotification('Language changed to: ' + selectedLang, 'success');
    });
    
    // ============================================
    // LOCATION UPDATE
    // ============================================
    $('#locationWrapper').on('click', function() {
        let newLocation = prompt('Enter your delivery location:', 'Guwahati 781030');
        if(newLocation) {
            $('.delivery-label').text('Delivering to ' + newLocation);
            showNotification('Location updated to: ' + newLocation, 'success');
        }
    });
    
    // ============================================
    // RETURNS & ORDERS CLICK
    // ============================================
    $('#returnsOrders').on('click', function() {
        window.location.href = '/orders';
    });
    
    // ============================================
    // MOBILE ACCOUNT CLICK
    // ============================================
    $('#mobileAccount').on('click', function(e) {
        e.preventDefault();
        if ($(window).width() > 992) {
            $('#accountDropdown').dropdown('toggle');
        } else {
            window.location.href = '/login';
        }
    });
    
    // ============================================
    // DROPDOWN ANIMATION
    // ============================================
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').addClass('animate__animated animate__fadeInDown');
    });
    
    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').removeClass('animate__animated animate__fadeInDown');
    });
    
    // ============================================
    // RESPONSIVE HANDLING
    // ============================================
    function handleResponsive() {
        let windowWidth = $(window).width();
        
        if (windowWidth < 768) {
            $('.desktop-only').hide();
            $('.mobile-only').show();
            $('.dropdown-menu').removeClass('show');
        } else {
            $('.desktop-only').show();
            $('.mobile-only').hide();
        }
    }
    
    handleResponsive();
    $(window).resize(handleResponsive);
    
    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================
    window.showNotification = function(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            console.log(`[${type.toUpperCase()}]`, message);
            
            let bgColor = type === 'success' ? '#4caf50' : (type === 'error' ? '#f44336' : '#2196f3');
            let icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
            
            let notification = $(`
                <div class="temp-notification" style="position: fixed; top: 20px; right: 20px; background: ${bgColor}; color: white; padding: 12px 20px; border-radius: 4px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="fas ${icon}"></i>
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
    };
    
    // ============================================
    // WISHLIST BUTTON - FIXED
    // ============================================
    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let btn = $(this);
        let icon = btn.find('i');
        let productId = btn.data('id');
        let productCard = btn.closest('.modern-product-card');
        
        if (!productCard.length) {
            productCard = btn.closest('.product-item');
        }
        
        let productName = productCard.find('.product-title').text() || 'Product';
        let brandName = productCard.find('.brand-name').text() || 'Brand';
        let priceText = productCard.find('.current-price').text().replace('₹', '').replace(',', '');
        let price = parseFloat(priceText) || 0;
        let image = productCard.find('.product-image img').attr('src') || '';
        
        // Check if user is logged in via meta tag
        let isLoggedIn = $('meta[name="user-logged-in"]').attr('content') === 'true';
        
        if (!isLoggedIn) {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.href);
            return;
        }
        
        $.ajax({
            url: '/wishlist',
            type: 'POST',
            data: {
                product_id: productId,
                product_name: productName,
                product_brand: brandName,
                price: price,
                product_image: image,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    if (icon.hasClass('far')) {
                        icon.removeClass('far').addClass('fas').css('color', '#ff4d4d');
                        showNotification(response.message || 'Added to wishlist!', 'success');
                    } else {
                        icon.removeClass('fas').addClass('far').css('color', '');
                        showNotification('Removed from wishlist', 'info');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.href);
                } else {
                    showNotification('Error updating wishlist', 'error');
                }
            }
        });
    });
    
    // ============================================
    // QUICK VIEW BUTTON - FIXED
    // ============================================
    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let productId = $(this).data('id');
        
        $.ajax({
            url: '/product/quick-view/' + productId,
            type: 'GET',
            success: function(response) {
                $('#quickViewContent').html(response);
                $('#quickViewModal').modal('show');
            },
            error: function() {
                showNotification('Error loading product details', 'error');
            }
        });
    });
    
    // ============================================
    // INITIALIZATION COMPLETE
    // ============================================
    console.log('All systems initialized successfully!');
});