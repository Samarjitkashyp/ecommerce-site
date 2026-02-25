<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- 🔥 CRITICAL: CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- 🔥 CRITICAL: User login status for JavaScript -->
    <meta name="user-logged-in" content="{{ auth()->check() ? 'true' : 'false' }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Your trusted online shopping destination')">
    <meta name="keywords" content="@yield('meta_keywords', 'shopping, ecommerce, online store')">
    
    <title>@yield('title', 'My Laravel Website')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Owl Carousel CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Header Section -->
    @include('layouts.header')
    
    <!-- Main Content -->
    <main style="min-height: calc(100vh - 200px); margin-bottom: 60px;" class="mb-lg-0">
        @yield('content')
    </main>
    
    <!-- Footer Section -->
    @include('layouts.footer')
    
    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Owl Carousel JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <script>
        // 🔥 FIXED: Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // 🔥 FIXED: Global functions that might be needed across pages
        window.showNotification = function(message, type = 'info') {
            if (typeof toastr !== 'undefined') {
                toastr[type](message);
            } else {
                console.log(`[${type.toUpperCase()}]`, message);
                alert(message);
            }
        };

        // 🔥 FIXED: Update cart count globally
        window.updateCartCount = function(count) {
            $('.cart-count').text(count);
            $('.mobile-cart-count').text(count);
        };

        // 🔥 FIXED: Get cart count on page load
        $(document).ready(function() {
            $.ajax({
                url: '/cart/count',
                type: 'GET',
                success: function(response) {
                    window.updateCartCount(response.count);
                },
                error: function() {
                    console.log('Could not fetch cart count');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>