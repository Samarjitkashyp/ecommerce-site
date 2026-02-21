{{-- resources/views/layouts/partials/header.blade.php --}}
<header>
    <!-- Main Header - Dark Bar -->
    <div class="main-header">
        <div class="container-fluid px-3">
            <div class="row align-items-center g-1">
                <!-- Logo Column -->
                <div class="col-auto">
                    <a href="{{ url('/') }}" class="logo-link">
                        <span class="logo-text">amazon</span><span class="logo-dot">.in</span>
                    </a>
                </div>

                <!-- Location Column -->
                <div class="col-auto d-none d-lg-block">
                    <div class="location-wrapper" id="locationWrapper">
                        <i class="fas fa-map-marker-alt location-icon"></i>
                        <div class="location-text">
                            <span class="delivery-label">Delivering to Guwahati 781030</span>
                            <span class="update-link">Update location</span>
                        </div>
                    </div>
                </div>

                <!-- Search Column - Takes remaining space -->
                <div class="col search-col px-2">
                    <div class="search-container">
                        <!-- Search Category Dropdown -->
                        <div class="dropdown search-dropdown">
                            <button class="search-category-btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                All
                            </button>
                            <ul class="dropdown-menu search-category-menu" aria-labelledby="categoryDropdown">
                                <li><h6 class="dropdown-header">All Categories</h6></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'fashion') }}">Fashion</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'electronics') }}">Electronics</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'home-kitchen') }}">Home & Kitchen</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'books') }}">Books</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'sports') }}">Sports</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'toys-baby') }}">Toys & Baby</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'auto-accessories') }}">Auto Accessories</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'travel') }}">Travel</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'genz-trends') }}">GenZ Trends</a></li>
                                <li><a class="dropdown-item" href="{{ route('category', 'next-gen') }}">Next Gen</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">All Departments</a></li>
                            </ul>
                        </div>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search Amazon.in">
                        <button class="search-btn" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Icons Column -->
                <div class="col-auto">
                    <div class="header-tools">
                        <!-- Language Dropdown -->
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

                        <!-- ============================================
                             UPDATED ACCOUNT DROPDOWN WITH AUTH
                             ============================================ -->
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

                        <!-- Returns & Orders -->
                        <div class="returns-orders d-none d-lg-block" id="returnsOrders" onclick="window.location.href='{{ route('account.orders') }}'" style="cursor: pointer;">
                            <span class="returns-text">Returns</span>
                            <span class="orders-bold">& Orders</span>
                        </div>

                        <!-- Cart -->
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

    <!-- Secondary Navigation -->
    <div class="secondary-nav">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <!-- All Menu Dropdown -->
                <div class="dropdown all-menu-dropdown">
                    <button class="all-menu-btn dropdown-toggle" type="button" id="allMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                        <span>All</span>
                    </button>
                    <ul class="dropdown-menu all-menu-list" aria-labelledby="allMenuDropdown">
                        <li><h6 class="dropdown-header">Trending</h6></li>
                        <li><a class="dropdown-item" href="#">Bestsellers</a></li>
                        <li><a class="dropdown-item" href="#">New Releases</a></li>
                        <li><a class="dropdown-item" href="#">Movers and Shakers</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Shop by Category</h6></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'fashion') }}">Fashion</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'electronics') }}">Electronics</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'home-kitchen') }}">Home & Kitchen</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'books') }}">Books</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'sports') }}">Sports</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'toys-baby') }}">Toys & Baby</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'auto-accessories') }}">Auto Accessories</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'travel') }}">Travel</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'genz-trends') }}">GenZ Trends</a></li>
                        <li><a class="dropdown-item" href="{{ route('category', 'next-gen') }}">Next Gen</a></li>
                    </ul>
                </div>

                <!-- Nav Links -->
                <div class="nav-links">
                    <a href="#">MX Player</a>
                    <a href="#">Sell</a>
                    <a href="#">Bestsellers</a>
                    <a href="{{ route('category', 'electronics') }}">Mobiles</a>
                    <a href="#">Today's Deals</a>
                    <a href="#">Customer Service</a>
                    <a href="#">New Releases</a>
                    <a href="#">Prime</a>
                    <a href="{{ route('category', 'fashion') }}">Fashion</a>
                    <a href="#">Amazon Pay</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Prime Banner -->
    <div class="prime-banner">
        <div class="container-fluid px-3">
            <div class="banner-content">
                <span class="banner-text">TU MERI MAIN TERA MAIN TERA TU MERI</span>
                <span class="prime-tag">Join Prime Lite at ₹67/month*</span>
                <span class="asterisk-text">*when paid annually</span>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Bottom Navigation -->
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
   ============================================ */
.main-header {
    background-color: #131921;
    padding: 8px 0;
}

/* Logo */
.logo-link {
    text-decoration: none;
    display: inline-block;
    padding: 5px 0;
}

.logo-text {
    color: white;
    font-size: 24px;
    font-weight: 600;
    letter-spacing: -1px;
}

.logo-dot {
    color: #febd69;
    font-size: 20px;
    font-weight: 600;
}

/* Location */
.location-wrapper {
    display: flex;
    align-items: center;
    color: white;
    cursor: pointer;
    padding: 5px 8px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.location-wrapper:hover {
    background-color: #485769;
}

.location-icon {
    font-size: 16px;
    margin-right: 5px;
    color: #febd69;
}

.location-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.delivery-label {
    font-size: 11px;
    color: #ccc;
}

.update-link {
    font-size: 13px;
    font-weight: 600;
    color: white;
}

/* Search Container */
.search-container {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 6px;
    overflow: hidden;
    height: 44px;
}

.search-dropdown {
    height: 100%;
}

.search-category-btn {
    height: 100%;
    background: #f3f3f3;
    border: none;
    padding: 0 15px;
    font-size: 13px;
    color: #555;
    border-right: 1px solid #cdcdcd;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
}

.search-category-btn:hover {
    background: #e3e3e3;
}

.search-category-menu {
    border-radius: 8px;
    margin-top: 2px;
    max-height: 400px;
    overflow-y: auto;
}

.search-category-menu .dropdown-header {
    font-size: 12px;
    font-weight: 600;
    color: #333;
}

.search-category-menu .dropdown-item {
    font-size: 13px;
    padding: 8px 15px;
}

.search-category-menu .dropdown-item:hover {
    background: #febd69;
    color: #131921;
}

.search-input {
    flex: 1;
    border: none;
    padding: 0 15px;
    font-size: 14px;
    height: 100%;
}

.search-input:focus {
    outline: none;
}

.search-btn {
    height: 100%;
    background: #febd69;
    border: none;
    width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #131921;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: #f3a847;
}

/* Header Tools */
.header-tools {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Language Dropdown */
.lang-selector-btn {
    background: transparent;
    border: none;
    color: white;
    padding: 8px 10px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.lang-selector-btn:hover {
    background: #485769;
}

.lang-menu {
    min-width: 120px;
}

.lang-menu .dropdown-item {
    font-size: 13px;
    padding: 8px 15px;
}

.lang-menu .dropdown-item:hover {
    background: #febd69;
    color: #131921;
}

/* Account Dropdown */
.account-btn {
    background: transparent;
    border: none;
    color: white;
    padding: 8px 10px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.account-btn:hover {
    background: #485769;
}

.account-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
    text-align: left;
}

.hello-text {
    font-size: 11px;
    color: #ccc;
}

.account-bold {
    font-size: 13px;
    font-weight: 600;
    color: white;
}

/* Account Menu */
.account-menu {
    width: 500px;
    padding: 0;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    margin-top: 5px;
}

.account-menu-header {
    background: #f7f7f7;
    padding: 20px;
    border-bottom: 1px solid #e7e7e7;
}

.signin-btn {
    background: #ffd814;
    border: none;
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #131921;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.signin-btn:hover {
    background: #f7ca00;
}

.new-customer {
    font-size: 13px;
    margin-top: 10px;
}

.new-customer a {
    color: #007185;
    text-decoration: none;
}

.new-customer a:hover {
    color: #c45500;
    text-decoration: underline;
}

.account-menu-content {
    display: flex;
    padding: 20px;
    gap: 30px;
}

.menu-column {
    flex: 1;
}

.menu-column h3 {
    font-size: 14px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.menu-column .dropdown-item {
    padding: 6px 0;
    font-size: 13px;
    color: #444;
    transition: all 0.2s ease;
}

.menu-column .dropdown-item:hover {
    background: transparent;
    color: #febd69;
    text-decoration: underline;
    transform: translateX(5px);
}

/* Returns & Orders */
.returns-orders {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
    padding: 8px 10px;
    border-radius: 4px;
    transition: all 0.3s ease;
    color: white;
}

.returns-orders:hover {
    background: #485769;
}

.returns-text {
    font-size: 11px;
    color: #ccc;
}

.orders-bold {
    font-size: 13px;
    font-weight: 600;
}

/* Cart */
.cart-wrapper {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 10px;
    border-radius: 4px;
    transition: all 0.3s ease;
    color: white;
    position: relative;
}

.cart-wrapper:hover {
    background: #485769;
}

.cart-icon {
    font-size: 22px;
}

.cart-count {
    position: absolute;
    top: 0;
    left: 22px;
    background: #febd69;
    color: #131921;
    font-size: 14px;
    font-weight: 700;
    min-width: 20px;
    height: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}

.cart-text {
    font-size: 13px;
    font-weight: 600;
    margin-left: 5px;
}

/* Secondary Navigation */
.secondary-nav {
    background: #232f3e;
    padding: 8px 0;
}

.all-menu-btn {
    background: transparent;
    border: none;
    color: white;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.all-menu-btn:hover {
    background: #485769;
}

.all-menu-list {
    width: 300px;
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    padding: 10px 0;
}

.all-menu-list .dropdown-header {
    font-size: 12px;
    font-weight: 600;
    color: #333;
    padding: 8px 20px;
}

.all-menu-list .dropdown-item {
    font-size: 13px;
    padding: 8px 20px;
    transition: all 0.2s ease;
}

.all-menu-list .dropdown-item:hover {
    background: #febd69;
    color: #131921;
    padding-left: 25px;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-left: 15px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: thin;
}

.nav-links::-webkit-scrollbar {
    height: 3px;
}

.nav-links::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.nav-links::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    padding: 5px 0;
    transition: all 0.3s ease;
}

.nav-links a:hover {
    color: #febd69;
    border-bottom: 2px solid #febd69;
}

/* Prime Banner */
.prime-banner {
    background: #2d2f31;
    padding: 8px 0;
    color: white;
}

.banner-content {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
}

.banner-text {
    color: #febd69;
    font-weight: 500;
}

.prime-tag {
    background: #febd69;
    color: #131921;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: 600;
}

.asterisk-text {
    color: #999;
    font-size: 11px;
}

/* Mobile Navigation */
.mobile-nav-bottom {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    padding: 5px 0;
    border-top: 1px solid #eee;
}

.mobile-nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #666;
    text-decoration: none;
    font-size: 11px;
    position: relative;
    padding: 5px 0;
}

.mobile-nav-item i {
    font-size: 20px;
    margin-bottom: 2px;
}

.mobile-nav-item.active {
    color: #febd69;
}

.mobile-cart-count {
    position: absolute;
    top: 0;
    right: 25%;
    background: #febd69;
    color: #131921;
    font-size: 10px;
    font-weight: 700;
    min-width: 16px;
    height: 16px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
}

/* Responsive */
@media (max-width: 992px) {
    .search-col {
        order: 3;
        margin-top: 10px;
        width: 100%;
        flex: 0 0 100%;
    }
    
    .secondary-nav {
        display: none;
    }
    
    .prime-banner {
        display: none;
    }
}

@media (max-width: 768px) {
    .account-menu {
        width: 300px;
    }
    
    .account-menu-content {
        flex-direction: column;
        gap: 15px;
    }
    
    .mobile-nav-bottom {
        display: flex;
    }
    
    .main-header {
        padding-bottom: 5px;
    }
}

@media (max-width: 576px) {
    .logo-text {
        font-size: 20px;
    }
    
    .logo-dot {
        font-size: 16px;
    }
    
    .cart-text {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
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
});
</script>
@endpush