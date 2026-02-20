/**
 * Custom JavaScript for Amazon Style Website
 * Version: 2.0
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
    // CART COUNTER FUNCTIONALITY
    // ============================================
    let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
    updateCartCount(cartCount);
    
    function updateCartCount(count) {
        $('.cart-count').text(count);
        $('.mobile-cart-count').text(count);
        localStorage.setItem('cartCount', count);
    }
    
    // ============================================
    // ADD TO CART FUNCTIONALITY
    // ============================================
    $('.add-to-cart-btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let button = $(this);
        let productCard = button.closest('.modern-product-card');
        let productId = button.data('id');
        let productTitle = button.data('name') || productCard.find('.product-title').text();
        let brandName = button.data('brand') || productCard.find('.brand-name').text();
        let productPrice = button.data('price') || productCard.find('.current-price').text().replace('₹', '');
        
        // Button loading animation
        let originalText = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        button.prop('disabled', true);
        
        // Simulate API call
        setTimeout(function() {
            // Update cart count
            cartCount++;
            updateCartCount(cartCount);
            
            // Animate cart icon
            $('.cart-wrapper').addClass('animate__animated animate__rubberBand');
            setTimeout(function() {
                $('.cart-wrapper').removeClass('animate__animated animate__rubberBand');
            }, 1000);
            
            // Reset button
            button.html(originalText);
            button.prop('disabled', false);
            
            // Show success notification
            showNotification(`${brandName} ${productTitle} added to cart!`, 'success');
            
            // Save to localStorage (cart items)
            saveToCart(productId, productTitle, brandName, productPrice);
            
            console.log('Product added:', { id: productId, name: productTitle, brand: brandName, price: productPrice });
        }, 600);
    });
    
    // Save cart items to localStorage
    function saveToCart(id, name, brand, price) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems.push({
            id: id,
            name: name,
            brand: brand,
            price: price,
            timestamp: new Date().getTime()
        });
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }
    
    // ============================================
    // SEARCH FUNCTIONALITY
    // ============================================
    function performSearch() {
        let searchTerm = $('#searchInput').val().trim();
        let selectedCategory = $('.search-category-btn').contents().first().text().trim();
        
        if(searchTerm) {
            console.log('Searching for:', searchTerm, 'in category:', selectedCategory);
            showNotification('Searching for: ' + searchTerm, 'info');
            
            // Redirect to search page (uncomment when search page is ready)
            // window.location.href = '/search?q=' + encodeURIComponent(searchTerm) + '&category=' + encodeURIComponent(selectedCategory);
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
        console.log('Category selected:', selectedCategory);
    });
    
    // ============================================
    // LANGUAGE SELECTION
    // ============================================
    $('.lang-menu .dropdown-item').on('click', function(e) {
        e.preventDefault();
        let selectedLang = $(this).text();
        let langCode = selectedLang.split(' - ')[1] || selectedLang.split(' ')[0];
        $('.lang-selector-btn span').text(langCode);
        console.log('Language changed to:', selectedLang);
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
        showNotification('Navigating to Orders page', 'info');
        // window.location.href = '/orders';
    });
    
    // ============================================
    // ACCOUNT DROPDOWN ITEM CLICKS
    // ============================================
    $('.account-menu .dropdown-item').on('click', function(e) {
        e.preventDefault();
        let linkText = $(this).text();
        console.log('Navigating to:', linkText);
        showNotification('Navigating to: ' + linkText, 'info');
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
    function showNotification(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            console.log(`[${type.toUpperCase()}]`, message);
            
            // Create temporary notification
            let notification = $(`
                <div class="temp-notification ${type}">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(function() {
                notification.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    }
    
    // ============================================
    // WISHLIST BUTTON
    // ============================================
    $('.action-btn.wishlist').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let heart = $(this).find('i');
        if(heart.hasClass('far')) {
            heart.removeClass('far').addClass('fas').css('color', '#ff4d4d');
            showNotification('Added to wishlist!', 'success');
        } else {
            heart.removeClass('fas').addClass('far').css('color', '');
            showNotification('Removed from wishlist', 'info');
        }
    });
    
    // ============================================
    // QUICK VIEW BUTTON
    // ============================================
    $('.action-btn.quick-view').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let productCard = $(this).closest('.modern-product-card');
        let productTitle = productCard.find('.product-title').text();
        
        showNotification('Quick view for: ' + productTitle, 'info');
        // Add modal popup logic here
    });
    
    // ============================================
    // INITIALIZATION COMPLETE
    // ============================================
    console.log('All systems initialized successfully!');
    console.log('Current cart count:', cartCount);
});