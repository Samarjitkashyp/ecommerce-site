{{-- resources/views/layouts/partials/header.blade.php --}}
@php
    // ============================================
    // DYNAMIC MENUS FROM DATABASE
    // These menus are managed from Admin Panel
    // Location: admin/menus
    // ============================================
    use App\Models\Menu;
    
    // MAIN NAVIGATION MENUS - Top navigation bar (visible on desktop)
    // These appear as the main navigation links next to "All" button
    $mainMenus = Menu::with('children')
        ->where('location', 'main')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    // TOP BAR MENUS - Small links above main header
    // Currently used for banner/announcement
    $topMenus = Menu::where('location', 'top')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    // SIDEBAR MENUS - These appear in the "All" dropdown menu
    // IMPORTANT: This is what you need for the sidebar
    // Parent menus become headers, children become menu items
    $sidebarMenus = Menu::with('children')
        ->where('location', 'sidebar')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    // CATEGORIES - Fallback if no sidebar menus exist
    // Also used for search dropdown
    $allCategories = App\Models\Category::with('children')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
@endphp

<header>
    <!-- ============================================
         MAIN HEADER - Dark Bar (Amazon Style)
         Contains: Logo, Location, Search, Account, Cart
         ============================================ -->
    <div class="main-header">
        <div class="container-fluid px-3">
            <div class="row align-items-center g-1">
                <!-- Logo Column -->
                <div class="col-auto">
                    <a href="{{ url('/') }}" class="logo-link">
                        <span class="logo-text">amazon</span><span class="logo-dot">.in</span>
                    </a>
                </div>

                <!-- Location Column - Only on desktop -->
                <div class="col-auto d-none d-lg-block">
                    <div class="location-wrapper" id="locationWrapper">
                        <i class="fas fa-map-marker-alt location-icon"></i>
                        <div class="location-text">
                            <span class="delivery-label">Delivering to Guwahati 781030</span>
                            <span class="update-link">Update location</span>
                        </div>
                    </div>
                </div>

                <!-- Search Column - Full width on mobile -->
                <div class="col search-col px-2">
                    <div class="search-container">
                        <!-- Search Category Dropdown - Dynamic from Categories -->
                        <div class="dropdown search-dropdown">
                            <button class="search-category-btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                All
                            </button>
                            <ul class="dropdown-menu search-category-menu" aria-labelledby="categoryDropdown">
                                <li><h6 class="dropdown-header">All Categories</h6></li>
                                @foreach($allCategories as $category)
                                    <li>
                                        <a class="dropdown-item" href="{{ $category->url }}">
                                            @if($category->icon)
                                                <i class="{{ $category->icon }} me-2"></i>
                                            @endif
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'all') }}">All Departments</a></li>
                            </ul>
                        </div>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search Amazon.in">
                        <button class="search-btn" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Icons Column - Account, Cart etc. -->
                <div class="col-auto">
                    <div class="header-tools">
                        <!-- Language Dropdown - Only on desktop -->
                        <div class="dropdown lang-dropdown d-none d-xl-block">
                            <button class="lang-selector-btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe"></i>
                                <span>EN</span>
                            </button>
                            <ul class="dropdown-menu lang-menu" aria-labelledby="languageDropdown">
                                <li><a class="dropdown-item" href="#">English - EN</a></li>
                                <li><a class="dropdown-item" href="#">हिन्दी - HI</a></li>
                                <li><a class="dropdown-item" href="#">தமிழ் - TA</a></li>
                                <li><a class="dropdown-item" href="#">తెలుగు - TE</a></li>
                                <li><a class="dropdown-item" href="#">ಕನ್ನಡ - KN</a></li>
                                <li><a class="dropdown-item" href="#">മലയാളം - ML</a></li>
                                <li><a class="dropdown-item" href="#">मराठी - MR</a></li>
                                <li><a class="dropdown-item" href="#">বাংলা - BN</a></li>
                            </ul>
                        </div>

                        <!-- Account Dropdown - Dynamic based on login status -->
                        <div class="dropdown account-dropdown">
                            <button class="account-btn dropdown-toggle" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="account-text">
                                    @auth
                                        <span class="hello-text">Hello, {{ explode(' ', Auth::user()->name)[0] }}</span>
                                        <span class="account-bold">Your Account</span>
                                    @else
                                        <span class="hello-text">Hello, sign in</span>
                                        <span class="account-bold">Account & Lists</span>
                                    @endauth
                                </div>
                            </button>
                            
                            <!-- Account Dropdown Menu - Complex structure for logged in/out users -->
                            <div class="dropdown-menu account-menu" aria-labelledby="accountDropdown">
                                @auth
                                    {{-- Logged In User Menu --}}
                                    <div class="account-menu-header">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=febd69&color=131921&bold=true' }}" 
                                                 alt="{{ Auth::user()->name }}" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #febd69;">
                                            <div>
                                                <strong style="font-size: 14px;">{{ Auth::user()->name }}</strong>
                                                <p class="mb-0 small text-muted">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('account.dashboard') }}" class="signin-btn text-center d-block" style="text-decoration: none;">
                                            Your Account
                                        </a>
                                    </div>
                                    
                                    <div class="account-menu-content">
                                        <div class="menu-column">
                                            <h3>Your Orders</h3>
                                            <a href="{{ route('account.orders') }}" class="dropdown-item">
                                                <i class="fas fa-shopping-bag me-2" style="width: 18px;"></i> Orders
                                            </a>
                                            <a href="{{ route('account.wishlist') }}" class="dropdown-item">
                                                <i class="fas fa-heart me-2" style="width: 18px;"></i> Wishlist
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-undo-alt me-2" style="width: 18px;"></i> Returns
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-times-circle me-2" style="width: 18px;"></i> Cancellations
                                            </a>
                                        </div>
                                        
                                        <div class="menu-column">
                                            <h3>Your Account</h3>
                                            <a href="{{ route('account.profile') }}" class="dropdown-item">
                                                <i class="fas fa-user me-2" style="width: 18px;"></i> Profile
                                            </a>
                                            <a href="{{ route('account.addresses') }}" class="dropdown-item">
                                                <i class="fas fa-map-marker-alt me-2" style="width: 18px;"></i> Addresses
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-credit-card me-2" style="width: 18px;"></i> Payment Methods
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-shield-alt me-2" style="width: 18px;"></i> Login & Security
                                            </a>
                                        </div>
                                        
                                        <div class="menu-column">
                                            <h3>Settings</h3>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-bell me-2" style="width: 18px;"></i> Notifications
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-language me-2" style="width: 18px;"></i> Language
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-lock me-2" style="width: 18px;"></i> Privacy
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt me-2" style="width: 18px;"></i> Sign Out
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    {{-- Guest User Menu --}}
                                    <div class="account-menu-header">
                                        <a href="{{ route('login') }}" class="signin-btn text-center d-block" style="text-decoration: none;">
                                            Sign in
                                        </a>
                                        <p class="new-customer text-center mt-2">
                                            New customer? <a href="{{ route('register') }}">Start here.</a>
                                        </p>
                                    </div>
                                    
                                    <div class="account-menu-content">
                                        <div class="menu-column">
                                            <h3>Your Lists</h3>
                                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="dropdown-item">
                                                <i class="fas fa-heart me-2" style="width: 18px;"></i> Create a Wish List
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-globe me-2" style="width: 18px;"></i> Wish from Any Website
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-baby me-2" style="width: 18px;"></i> Baby Wishlist
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-tshirt me-2" style="width: 18px;"></i> Discover Your Style
                                            </a>
                                        </div>
                                        
                                        <div class="menu-column">
                                            <h3>Your Account</h3>
                                            <a href="{{ route('login') }}" class="dropdown-item">
                                                <i class="fas fa-user me-2" style="width: 18px;"></i> Sign in
                                            </a>
                                            <a href="{{ route('register') }}" class="dropdown-item">
                                                <i class="fas fa-user-plus me-2" style="width: 18px;"></i> Register
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-shopping-bag me-2" style="width: 18px;"></i> Your Orders
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-heart me-2" style="width: 18px;"></i> Your Wish List
                                            </a>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <!-- Returns & Orders - Only on desktop -->
                        <div class="returns-orders d-none d-lg-block" id="returnsOrders" onclick="window.location.href='{{ route('account.orders') }}'" style="cursor: pointer;">
                            <span class="returns-text">Returns</span>
                            <span class="orders-bold">& Orders</span>
                        </div>

                        <!-- Cart - Always visible -->
                        <div class="cart-wrapper" id="cartWrapper" onclick="window.location.href='{{ route('cart.index') }}'" style="cursor: pointer;">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                            <span class="cart-count">{{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                            <span class="cart-text d-none d-xl-inline">Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         SECONDARY NAVIGATION - Light bar below main header
         Contains: "All" dropdown (SIDEBAR MENUS) and MAIN NAVIGATION
         ============================================ -->
    <div class="secondary-nav">
        <div class="container-fluid px-3">
            <div class="nav-wrapper">
                <!-- ============================================
                     ALL MENU DROPDOWN - FIXED: Now using sidebar menus
                     
                     IMPORTANT: This dropdown shows menus from 'sidebar' location
                     How to manage from Admin Panel:
                     1. Go to Admin -> Menu Management
                     2. Click "Add New Menu"
                     3. Select Location: "sidebar"
                     4. For headers (like "Trending"): Select Type: "dropdown"
                     5. For menu items: Select Type: "link" and set Parent to the header
                     
                     Example structure:
                     - Trending (dropdown, parent: none)
                       - Best Sellers (link, parent: Trending)
                       - New Releases (link, parent: Trending)
                     - Shop by Category (dropdown, parent: none)
                       - Electronics (link, parent: Shop by Category)
                       - Fashion (link, parent: Shop by Category)
                     ============================================ -->
                <div class="all-menu-dropdown">
                    <button class="all-menu-btn">
                        <i class="fas fa-bars"></i>
                        <span>All</span>
                    </button>
                    
                    <div class="all-menu-list">
                        @php
                            // Get sidebar menus - these are managed from admin panel
                            // Location: admin/menus with location = 'sidebar'
                            $sidebarMenus = Menu::with('children')
                                ->where('location', 'sidebar')
                                ->whereNull('parent_id')
                                ->where('is_active', true)
                                ->orderBy('sort_order')
                                ->get();
                        @endphp
                        
                        {{-- Check if we have sidebar menus from admin --}}
                        @if($sidebarMenus->count() > 0)
                            {{-- Loop through each parent menu (these become headers) --}}
                            @foreach($sidebarMenus as $menu)
                                {{-- Check if this menu has children (dropdown items) --}}
                                @if($menu->children->count() > 0)
                                    {{-- Parent menu with children becomes a section header --}}
                                    <h6 class="dropdown-header">
                                        @if($menu->icon)
                                            <i class="{{ $menu->icon }} me-2"></i>
                                        @endif
                                        {{ $menu->name }}
                                    </h6>
                                    
                                    {{-- Loop through child menus (these become clickable items) --}}
                                    @foreach($menu->children->sortBy('sort_order') as $child)
                                        <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                            @if($child->icon)
                                                <i class="{{ $child->icon }} me-2"></i>
                                            @endif
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                    
                                    {{-- Add divider between sections except for last one --}}
                                    @if(!$loop->last)
                                        <div class="dropdown-divider"></div>
                                    @endif
                                @else
                                    {{-- Parent menu without children becomes a single menu item --}}
                                    <a class="dropdown-item" href="{{ $menu->url }}" target="{{ $menu->target }}">
                                        @if($menu->icon)
                                            <i class="{{ $menu->icon }} me-2"></i>
                                        @endif
                                        {{ $menu->name }}
                                    </a>
                                @endif
                            @endforeach
                        @else
                            {{-- FALLBACK: If no sidebar menus exist, show categories --}}
                            <h6 class="dropdown-header">Trending</h6>
                            <a class="dropdown-item" href="#"><i class="fas fa-fire me-2"></i> Best Sellers</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-star me-2"></i> New Releases</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i> Movers & Shakers</a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <h6 class="dropdown-header">Shop by Category</h6>
                            @foreach($allCategories as $category)
                                <a class="dropdown-item" href="{{ $category->url }}">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} me-2"></i>
                                    @endif
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            
                            <div class="dropdown-divider"></div>
                            
                            <a class="dropdown-item text-primary" href="#">
                                <i class="fas fa-tags me-2"></i> Sale
                            </a>
                        @endif
                    </div>
                </div>

                <!-- ============================================
                     MAIN NAVIGATION LINKS
                     These are from 'main' location in admin panel
                     Can be simple links or dropdowns with children
                     ============================================ -->
                <div class="nav-links">
                    @foreach($mainMenus as $menu)
                        @if($menu->children->count() > 0)
                            {{-- Menu with children becomes a dropdown --}}
                            <div class="nav-item dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }} me-1"></i>
                                    @endif
                                    {{ $menu->name }}
                                </a>
                                <div class="dropdown-menu">
                                    @foreach($menu->children->sortBy('sort_order') as $child)
                                        <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                            @if($child->icon)
                                                <i class="{{ $child->icon }} me-2"></i>
                                            @endif
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Simple menu item --}}
                            <div class="nav-item">
                                <a href="{{ $menu->url }}" target="{{ $menu->target }}">
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }} me-1"></i>
                                    @endif
                                    {{ $menu->name }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         PRIME BANNER - Can be managed from 'top' location
         Create a menu with type 'banner' or use default
         ============================================ -->
    @if($topBanner = \App\Models\Menu::where('location', 'top')->where('type', 'banner')->first())
        <div class="prime-banner">
            <div class="container-fluid px-3">
                <div class="banner-content">
                    {!! $topBanner->name !!}
                </div>
            </div>
        </div>
    @else
        <div class="prime-banner">
            <div class="container-fluid px-3">
                <div class="banner-content">
                    <span class="banner-text">TU MERI MAIN TERA MAIN TERA TU MERI</span>
                    <span class="prime-tag">Join Prime Lite at ₹67/month*</span>
                    <span class="asterisk-text">*when paid annually</span>
                </div>
            </div>
        </div>
    @endif
</header>

<!-- ============================================
     MOBILE BOTTOM NAVIGATION
     Fixed at bottom on mobile devices
     ============================================ -->
<div class="mobile-nav-bottom">
    <a href="{{ url('/') }}" class="mobile-nav-item">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="#" class="mobile-nav-item" id="mobileSearch">
        <i class="fas fa-search"></i>
        <span>Search</span>
    </a>
    <a href="{{ route('account.dashboard') }}" class="mobile-nav-item" id="mobileAccount">
        <i class="fas fa-user"></i>
        <span>Account</span>
    </a>
    <a href="{{ route('cart.index') }}" class="mobile-nav-item" id="mobileCart">
        <i class="fas fa-shopping-cart"></i>
        <span>Cart</span>
        <span class="mobile-cart-count">{{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
    </a>
</div>

@push('styles')
<style>
/* ============================================
   HEADER STYLES
   Keep your existing styles here
   ============================================ */
/* ... (your existing styles remain the same) ... */
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // ============================================
    // HEADER JAVASCRIPT FUNCTIONS
    // ============================================
    
    // Update cart count dynamically
    function updateCartCount() {
        $.get('{{ route("cart.count") }}', function(response) {
            $('.cart-count, .mobile-cart-count').text(response.count);
        });
    }
    
    // Search functionality
    $('#searchBtn').on('click', function() {
        let query = $('#searchInput').val().trim();
        if (query) {
            window.location.href = '{{ route("search") }}?q=' + encodeURIComponent(query);
        }
    });
    
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            $('#searchBtn').click();
        }
    });
    
    // Mobile search toggle
    $('#mobileSearch').on('click', function(e) {
        e.preventDefault();
        $('.search-col').toggleClass('d-none d-block');
        $('#searchInput').focus();
    });
    
    // Active link highlighting
    let currentPath = window.location.pathname;
    $('.nav-links a, .mobile-nav-item').each(function() {
        if ($(this).attr('href') === currentPath) {
            $(this).addClass('active');
        }
    });
    
    // Initialize Bootstrap dropdowns for dynamic content
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
});
</script>
@endpush