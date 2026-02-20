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
                        <!-- Search Category Dropdown - FIXED -->
                        <div class="dropdown search-dropdown">
                            <button class="search-category-btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                All
                            </button>
                            <ul class="dropdown-menu search-category-menu" aria-labelledby="categoryDropdown">
                                <li><h6 class="dropdown-header">All Categories</h6></li>
                                <li><a class="dropdown-item" href="#">All Departments</a></li>
                                <li><a class="dropdown-item" href="#">Alexa Skills</a></li>
                                <li><a class="dropdown-item" href="#">Amazon Devices</a></li>
                                <li><a class="dropdown-item" href="#">Amazon Fashion</a></li>
                                <li><a class="dropdown-item" href="#">Amazon Fresh</a></li>
                                <li><a class="dropdown-item" href="#">Amazon Pharmacy</a></li>
                                <li><a class="dropdown-item" href="#">Appliances</a></li>
                                <li><a class="dropdown-item" href="#">Apps & Games</a></li>
                                <li><a class="dropdown-item" href="#">Baby</a></li>
                                <li><a class="dropdown-item" href="#">Beauty</a></li>
                                <li><a class="dropdown-item" href="#">Books</a></li>
                                <li><a class="dropdown-item" href="#">Car & Motorbike</a></li>
                                <li><a class="dropdown-item" href="#">Clothing & Accessories</a></li>
                                <li><a class="dropdown-item" href="#">Collectibles</a></li>
                                <li><a class="dropdown-item" href="#">Computers & Accessories</a></li>
                                <li><a class="dropdown-item" href="#">Electronics</a></li>
                                <li><a class="dropdown-item" href="#">Furniture</a></li>
                                <li><a class="dropdown-item" href="#">Garden & Outdoors</a></li>
                                <li><a class="dropdown-item" href="#">Gift Cards</a></li>
                                <li><a class="dropdown-item" href="#">Grocery & Gourmet Foods</a></li>
                                <li><a class="dropdown-item" href="#">Health & Personal Care</a></li>
                                <li><a class="dropdown-item" href="#">Home & Kitchen</a></li>
                                <li><a class="dropdown-item" href="#">Industrial & Scientific</a></li>
                                <li><a class="dropdown-item" href="#">Jewellery</a></li>
                                <li><a class="dropdown-item" href="#">Kindle Store</a></li>
                                <li><a class="dropdown-item" href="#">Luggage & Bags</a></li>
                                <li><a class="dropdown-item" href="#">Luxury Beauty</a></li>
                                <li><a class="dropdown-item" href="#">Movies & TV Shows</a></li>
                                <li><a class="dropdown-item" href="#">Musical Instruments</a></li>
                                <li><a class="dropdown-item" href="#">Office Products</a></li>
                                <li><a class="dropdown-item" href="#">Pet Supplies</a></li>
                                <li><a class="dropdown-item" href="#">Prime Video</a></li>
                                <li><a class="dropdown-item" href="#">Shoes & Handbags</a></li>
                                <li><a class="dropdown-item" href="#">Software</a></li>
                                <li><a class="dropdown-item" href="#">Sports, Fitness & Outdoors</a></li>
                                <li><a class="dropdown-item" href="#">Subscribe & Save</a></li>
                                <li><a class="dropdown-item" href="#">Tools & Home Improvement</a></li>
                                <li><a class="dropdown-item" href="#">Toys & Games</a></li>
                                <li><a class="dropdown-item" href="#">Under ₹500</a></li>
                                <li><a class="dropdown-item" href="#">Video Games</a></li>
                                <li><a class="dropdown-item" href="#">Watches</a></li>
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
                        <!-- Language Dropdown - FIXED -->
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

                        <!-- Account Dropdown - FIXED -->
                        <div class="dropdown account-dropdown">
                            <button class="account-btn dropdown-toggle" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="account-text">
                                    <span class="hello-text">Hello, sign in</span>
                                    <span class="account-bold">Account & Lists</span>
                                </div>
                            </button>
                            <div class="dropdown-menu account-menu" aria-labelledby="accountDropdown">
                                <div class="account-menu-header">
                                    <button class="signin-btn" onclick="window.location.href='/login'">Sign in</button>
                                    <p class="new-customer">New customer? <a href="/register">Start here.</a></p>
                                </div>
                                <div class="account-menu-content">
                                    <div class="menu-column">
                                        <h3>Your Lists</h3>
                                        <a href="#" class="dropdown-item">Create a Wish List</a>
                                        <a href="#" class="dropdown-item">Wish from Any Website</a>
                                        <a href="#" class="dropdown-item">Baby Wishlist</a>
                                        <a href="#" class="dropdown-item">Discover Your Style</a>
                                        <a href="#" class="dropdown-item">Explore Showroom</a>
                                    </div>
                                    <div class="menu-column">
                                        <h3>Your Account</h3>
                                        <a href="#" class="dropdown-item">Your Account</a>
                                        <a href="#" class="dropdown-item">Your Orders</a>
                                        <a href="#" class="dropdown-item">Your Wish List</a>
                                        <a href="#" class="dropdown-item">Your Recommendations</a>
                                        <a href="#" class="dropdown-item">Your Prime Membership</a>
                                        <a href="#" class="dropdown-item">Your Seller Account</a>
                                        <a href="#" class="dropdown-item">Manage Your Content and Devices</a>
                                        <a href="#" class="dropdown-item">Your Subscribe & Save Items</a>
                                        <a href="#" class="dropdown-item">Your Garage</a>
                                        <a href="#" class="dropdown-item">Free with Prime</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Returns & Orders -->
                        <div class="returns-orders d-none d-lg-block" id="returnsOrders">
                            <span class="returns-text">Returns</span>
                            <span class="orders-bold">& Orders</span>
                        </div>

                        <!-- Cart -->
                        <div class="cart-wrapper" id="cartWrapper">
                            <i class="fas fa-shopping-cart cart-icon"></i>
                            <span class="cart-count">0</span>
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
                <!-- All Menu Dropdown - FIXED -->
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
                        <li><h6 class="dropdown-header">Digital Content and Devices</h6></li>
                        <li><a class="dropdown-item" href="#">Echo & Alexa</a></li>
                        <li><a class="dropdown-item" href="#">Fire TV</a></li>
                        <li><a class="dropdown-item" href="#">Kindle E-Readers & eBooks</a></li>
                        <li><a class="dropdown-item" href="#">Audible Audiobooks</a></li>
                        <li><a class="dropdown-item" href="#">Amazon Prime Video</a></li>
                        <li><a class="dropdown-item" href="#">Amazon Prime Music</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Shop by Category</h6></li>
                        <li><a class="dropdown-item" href="#">Mobiles & Accessories</a></li>
                        <li><a class="dropdown-item" href="#">Laptops & Computers</a></li>
                        <li><a class="dropdown-item" href="#">TV & Home Entertainment</a></li>
                        <li><a class="dropdown-item" href="#">Audio & Headphones</a></li>
                        <li><a class="dropdown-item" href="#">Camera & Photography</a></li>
                        <li><a class="dropdown-item" href="#">Smart Home Technology</a></li>
                        <li><a class="dropdown-item" href="#">Women's Fashion</a></li>
                        <li><a class="dropdown-item" href="#">Men's Fashion</a></li>
                        <li><a class="dropdown-item" href="#">Girls' Fashion</a></li>
                        <li><a class="dropdown-item" href="#">Boys' Fashion</a></li>
                        <li><a class="dropdown-item" href="#">Health & Personal Care</a></li>
                        <li><a class="dropdown-item" href="#">Beauty & Grooming</a></li>
                        <li><a class="dropdown-item" href="#">Sports, Fitness & Outdoors</a></li>
                        <li><a class="dropdown-item" href="#">Books & Audible</a></li>
                        <li><a class="dropdown-item" href="#">Movies, Music & Video Games</a></li>
                        <li><a class="dropdown-item" href="#">Gaming & Accessories</a></li>
                        <li><a class="dropdown-item" href="#">Toys & Baby Products</a></li>
                        <li><a class="dropdown-item" href="#">Car & Motorbike</a></li>
                        <li><a class="dropdown-item" href="#">Grocery & Gourmet Foods</a></li>
                        <li><a class="dropdown-item" href="#">Pet Supplies</a></li>
                        <li><a class="dropdown-item" href="#">Home & Kitchen</a></li>
                        <li><a class="dropdown-item" href="#">Furniture & Décor</a></li>
                        <li><a class="dropdown-item" href="#">Gardening & Outdoor</a></li>
                        <li><a class="dropdown-item" href="#">Jewellery & Watches</a></li>
                        <li><a class="dropdown-item" href="#">Luggage & Travel Gear</a></li>
                    </ul>
                </div>

                <!-- Nav Links -->
                <div class="nav-links">
                    <a href="#">MX Player</a>
                    <a href="#">Sell</a>
                    <a href="#">Bestsellers</a>
                    <a href="#">Mobiles</a>
                    <a href="#">Today's Deals</a>
                    <a href="#">Customer Service</a>
                    <a href="#">New Releases</a>
                    <a href="#">Prime</a>
                    <a href="#">Fashion</a>
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
    <a href="#" class="mobile-nav-item" id="mobileAccount">
        <i class="fas fa-user"></i>
        <span>Account</span>
    </a>
    <a href="#" class="mobile-nav-item" id="mobileCart">
        <i class="fas fa-shopping-cart"></i>
        <span>Cart</span>
        <span class="mobile-cart-count">0</span>
    </a>
</div>