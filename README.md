# Laravel E-commerce Website - Amazon/Flipkart Clone

A fully functional e-commerce website built with Laravel 12, featuring user authentication, product management, shopping cart, and order management system.

## 🌟 Features

### 🎨 Frontend Features
- ✅ Amazon-style header with dynamic dropdowns
- ✅ Responsive category slider with custom navigation
- ✅ Modern product cards with quick view and wishlist
- ✅ Flipkart-style footer with multiple columns
- ✅ Owl Carousel for product and category sliders
- ✅ Bootstrap 5 with custom styling
- ✅ Font Awesome 6 icons
- ✅ Fully responsive design (mobile, tablet, desktop)

### 👤 User Management
- ✅ User registration with email and phone
- ✅ Secure login/logout system
- ✅ Password reset functionality
- ✅ User profile management
- ✅ Avatar upload with image cropping
- ✅ Address management (add, edit, delete, default)
- ✅ Wishlist functionality
- ✅ Order history and tracking

### 🛒 Shopping Features
- ✅ Add to cart functionality
- ✅ Cart quantity update
- ✅ Save for later feature
- ✅ Coupon system with validation
- ✅ Price calculation (subtotal, tax, delivery)
- ✅ Multiple delivery options
- ✅ Multiple payment methods (COD, Card, UPI, NetBanking)
- ✅ Order placement and confirmation

### 📦 Product Management
- ✅ Product categories with filtering
- ✅ Product details page with image zoom
- ✅ Color and size variants
- ✅ Product ratings and reviews
- ✅ Related products slider
- ✅ Recently viewed products
- ✅ Quick view modal
- ✅ Search functionality

### 🛡️ Security Features
- ✅ CSRF protection
- ✅ XSS protection
- ✅ SQL injection prevention
- ✅ Secure authentication
- ✅ Session management
- ✅ Input validation

## 🛠️ Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM (optional, for frontend assets)
- Laravel 12
- Web Server (Apache/Nginx) or Laravel Artisan

## 📦 Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/Samarjitkashyp/ecommerce-site.git
cd ecommerce-site

### Install PHP Dependencies
- composer install

### Install NPM Dependencies (Optional - for frontend)
- npm install
- npm run dev

### Environment Setup
- cp .env.example .env
- php artisan key:generate

### Database Configuration

## Edit .env file and update database credentials:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=ecommerce-site
- DB_USERNAME=root
- DB_PASSWORD=

### Run Migrations and Seeders
- php artisan migrate
- php artisan db:seed

### Create Storage Link
- php artisan storage:link

### Install Sanctum (For API Authentication)
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- php artisan migrate

### Start the Development Server
- php artisan serve

### Project Structure

ecommerce-site/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── AccountController.php
│   │   │   ├── AddressController.php
│   │   │   ├── CartController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   └── WishlistController.php
│   │   └── Middleware/
│   │       └── CheckUserActive.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Address.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── Wishlist.php
├── database/
│   ├── migrations/
│   │   ├── 2026_02_21_070844_add_user_fields_to_users_table.php
│   │   ├── 2026_02_21_070949_create_addresses_table.php
│   │   ├── 2026_02_21_071026_create_orders_table.php
│   │   ├── 2026_02_21_071106_create_order_items_table.php
│   │   └── 2026_02_21_071142_create_wishlists_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── master.blade.php
│       │   ├── header.blade.php
│       │   ├── footer.blade.php
│       │   └── auth.blade.php
│       ├── front/
│       │   ├── index.blade.php
│       │   ├── cart.blade.php
│       │   ├── category.blade.php
│       │   ├── checkout.blade.php
│       │   └── product-detail.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── account/
│           ├── dashboard.blade.php
│           ├── profile.blade.php
│           ├── orders.blade.php
│           ├── wishlist.blade.php
│           └── addresses.blade.php
├── routes/
│   └── web.php
└── public/
    └── storage/ (symlink to storage/app/public)


### Development Commands
# Clear all caches
php artisan optimize:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Run migrations
php artisan migrate

# Fresh migration with seed
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration migration_name

# Create new model
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Create new seeder
php artisan make:seeder SeederName

# Run seeder
php artisan db:seed --class=SeederName

# List all routes
php artisan route:list

# Start Tinker (REPL)
php artisan tinker


