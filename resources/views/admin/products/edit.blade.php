{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Product: ' . $product->name)
@section('page-title', 'Edit Product: ' . $product->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-card">
            <form action="{{ route('admin.products.update', $product->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="productForm">
                @csrf
                @method('PUT')
                
                <!-- ============================================
                     BASIC INFORMATION SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Basic Information</h5>
                    </div>
                    
                    <!-- Product Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">
                            Product Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}"
                               placeholder="e.g., Men's Printed Cotton T-Shirt"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label fw-bold">
                            Slug <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $product->slug) }}"
                               placeholder="Auto-generated from name">
                        <small class="text-muted">Leave empty to auto-generate</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Brand -->
                    <div class="col-md-4 mb-3">
                        <label for="brand" class="form-label fw-bold">
                            Brand <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('brand') is-invalid @enderror" 
                               id="brand" 
                               name="brand" 
                               value="{{ old('brand', $product->brand) }}"
                               placeholder="e.g., Jack & Jones"
                               required>
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- SKU -->
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label fw-bold">
                            SKU <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('sku') is-invalid @enderror" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku', $product->sku) }}"
                               placeholder="e.g., JJ-TSHIRT-001">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Badge -->
                    <div class="col-md-4 mb-3">
                        <label for="badge" class="form-label fw-bold">Badge</label>
                        <select class="form-select @error('badge') is-invalid @enderror" 
                                id="badge" 
                                name="badge">
                            @foreach($badges as $value => $label)
                                <option value="{{ $value }}" {{ old('badge', $product->badge) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Special label for product</small>
                        @error('badge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- ============================================
                     CATEGORY SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Category</h5>
                    </div>
                    
                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label fw-bold">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select class="form-select select2 @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                    @if($category->parent)
                                        ({{ $category->parent->name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Subcategory -->
                    <div class="col-md-6 mb-3">
                        <label for="subcategory" class="form-label fw-bold">
                            Subcategory <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('subcategory') is-invalid @enderror" 
                               id="subcategory" 
                               name="subcategory" 
                               value="{{ old('subcategory', $product->subcategory) }}"
                               placeholder="e.g., mens-clothing">
                        <small class="text-muted">For breadcrumb and filtering</small>
                        @error('subcategory')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- ============================================
                     PRICING SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Pricing</h5>
                    </div>
                    
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label fw-bold">
                            Selling Price (₹) <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}"
                               min="0"
                               step="0.01"
                               placeholder="799"
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Original Price -->
                    <div class="col-md-4 mb-3">
                        <label for="original_price" class="form-label fw-bold">
                            Original Price (₹) <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="number" 
                               class="form-control @error('original_price') is-invalid @enderror" 
                               id="original_price" 
                               name="original_price" 
                               value="{{ old('original_price', $product->original_price) }}"
                               min="0"
                               step="0.01"
                               placeholder="2499">
                        <small class="text-muted">For showing discount</small>
                        @error('original_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Discount -->
                    <div class="col-md-4 mb-3">
                        <label for="discount" class="form-label fw-bold">
                            Discount (%) <span class="text-muted">(Auto)</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               id="discount" 
                               name="discount" 
                               value="{{ old('discount', $product->discount) }}"
                               min="0"
                               max="100"
                               readonly
                               placeholder="Auto-calculated">
                        <small class="text-muted" id="discountInfo"></small>
                    </div>
                </div>
                
                <!-- ============================================
                     PRODUCT CONTENT SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Product Content</h5>
                    </div>
                    
                    <!-- Description -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label fw-bold">
                            Product Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Highlights -->
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Key Features / Highlights</label>
                        <div id="highlights-container">
                            @php
                                $highlights = old('highlights', $product->highlights ?? []);
                            @endphp
                            
                            @if(!empty($highlights) && is_array($highlights))
                                @foreach($highlights as $highlight)
                                <div class="input-group mb-2">
                                    <input type="text" 
                                           class="form-control" 
                                           name="highlights[]" 
                                           value="{{ $highlight }}"
                                           placeholder="Enter feature">
                                    <button class="btn btn-outline-danger remove-highlight" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                            
                            <div class="input-group mb-2">
                                <input type="text" 
                                       class="form-control" 
                                       name="highlights[]" 
                                       placeholder="e.g., 100% Pure Cotton">
                                <button class="btn btn-outline-success add-highlight" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Add key features of the product</small>
                    </div>
                    
                    <!-- Specifications -->
                    <!-- ============================================
     SPECIFICATIONS SECTION - FIXED VERSION
     ============================================ -->
    <div class="col-12 mb-3">
        <label class="form-label fw-bold">Specifications</label>
        <div id="specs-container">
            @php
                $specs = old('specifications', $product->specifications ?? []);
                
                // Agar JSON string hai to decode karo
                if (is_string($specs)) {
                    $specs = json_decode($specs, true) ?? [];
                }
                
                // Agar empty array hai to empty karo
                if (empty($specs)) {
                    $specs = [];
                }
            @endphp
            
            {{-- Show existing specifications --}}
            @if(!empty($specs) && is_array($specs))
                @foreach($specs as $key => $value)
                    {{-- Check if value is array --}}
                    @if(is_array($value))
                        {{-- Handle key-value pair format --}}
                        @if(isset($value['key']) || isset($value['value']))
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" 
                                        class="form-control" 
                                        name="specifications[key][]" 
                                        value="{{ $value['key'] ?? '' }}" 
                                        placeholder="Specification">
                                </div>
                                <div class="col-5">
                                    <input type="text" 
                                        class="form-control" 
                                        name="specifications[value][]" 
                                        value="{{ $value['value'] ?? '' }}" 
                                        placeholder="Value">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger remove-spec" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- Handle nested array format --}}
                            @foreach($value as $subKey => $subValue)
                                @if(is_array($subValue))
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <input type="text" 
                                                class="form-control" 
                                                name="specifications[key][]" 
                                                value="{{ $subValue['key'] ?? $subKey }}" 
                                                placeholder="Specification">
                                        </div>
                                        <div class="col-5">
                                            <input type="text" 
                                                class="form-control" 
                                                name="specifications[value][]" 
                                                value="{{ $subValue['value'] ?? (is_array($subValue) ? '' : $subValue) }}" 
                                                placeholder="Value">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-outline-danger remove-spec" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-2">
                                        <div class="col-10">
                                            <input type="text" 
                                                class="form-control" 
                                                name="specifications[]" 
                                                value="{{ $subValue }}" 
                                                placeholder="Specification">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-outline-danger remove-spec" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @else
                        {{-- Handle simple key-value --}}
                        @if(is_numeric($key))
                            {{-- Simple array item --}}
                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="text" 
                                        class="form-control" 
                                        name="specifications[]" 
                                        value="{{ $value }}" 
                                        placeholder="Specification">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger remove-spec" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- Key-value pair --}}
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" 
                                        class="form-control" 
                                        name="specifications[key][]" 
                                        value="{{ $key }}" 
                                        placeholder="Specification">
                                </div>
                                <div class="col-5">
                                    <input type="text" 
                                        class="form-control" 
                                        name="specifications[value][]" 
                                        value="{{ $value }}" 
                                        placeholder="Value">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger remove-spec" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
            
            {{-- Default empty row for adding new specification --}}
            <div class="row mb-2">
                <div class="col-5">
                    <input type="text" 
                        class="form-control" 
                        name="specifications[key][]" 
                        placeholder="Specification (e.g., Material)">
                </div>
                <div class="col-5">
                    <input type="text" 
                        class="form-control" 
                        name="specifications[value][]" 
                        placeholder="Value (e.g., 100% Cotton)">
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-success add-spec" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <small class="text-muted">Add technical specifications</small>
    </div>
                </div>
                
                <!-- ============================================
                     MEDIA SECTION (IMAGES)
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Product Images</h5>
                    </div>
                    
                    <!-- Current Main Image -->
                    @if($product->main_image)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Current Main Image</label>
                        <div>
                            <img src="{{ asset('storage/'.$product->main_image) }}" 
                                 alt="Current main image" 
                                 style="max-width: 150px; max-height: 150px; border-radius: 5px;"
                                 class="border">
                            <div class="mt-1">
                                <label>
                                    <input type="checkbox" name="remove_images[]" value="main"> Remove this image
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Main Image -->
                    <div class="col-md-6 mb-3">
                        <label for="main_image" class="form-label fw-bold">
                            New Main Image <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('main_image') is-invalid @enderror" 
                               id="main_image" 
                               name="main_image" 
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small class="text-muted">Leave empty to keep current image</small>
                        @error('main_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview -->
                        <div class="mt-2" id="mainImagePreviewContainer" style="display: none;">
                            <img id="mainImagePreview" src="#" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                        </div>
                    </div>
                    
                    <!-- Current Thumbnails -->
                    @if(!empty($product->thumbnail_images))
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Current Additional Images</label>
                        <div class="row">
                            @foreach($product->thumbnail_images as $index => $thumbnail)
                            <div class="col-2 mb-2">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/'.$thumbnail) }}" 
                                         alt="Thumbnail {{ $index+1 }}" 
                                         style="width: 100%; height: 80px; object-fit: cover; border-radius: 5px;"
                                         class="border">
                                    <div class="mt-1 text-center">
                                        <label>
                                            <input type="checkbox" name="remove_images[]" value="thumbnails.{{ $index }}"> Remove
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Thumbnail Images -->
                    <div class="col-md-6 mb-3">
                        <label for="thumbnail_images" class="form-label fw-bold">
                            Add New Additional Images
                        </label>
                        <input type="file" 
                               class="form-control @error('thumbnail_images.*') is-invalid @enderror" 
                               id="thumbnail_images" 
                               name="thumbnail_images[]" 
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               multiple>
                        <small class="text-muted">You can select multiple images</small>
                        @error('thumbnail_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview -->
                        <div class="mt-2" id="thumbnailsPreviewContainer">
                            <div class="row g-2" id="thumbnailsPreview"></div>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================
                     VARIANTS SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Product Variants</h5>
                    </div>
                    
                    <!-- Colors -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Available Colors</label>
                        <div id="colors-container">
                            @php
                                $colors = old('colors', $product->colors ?? []);
                            @endphp
                            
                            @if(!empty($colors) && is_array($colors))
                                @foreach($colors as $color)
                                <div class="input-group mb-2">
                                    <input type="text" 
                                           class="form-control" 
                                           name="colors[]" 
                                           value="{{ $color }}"
                                           placeholder="Enter color">
                                    <button class="btn btn-outline-danger remove-color" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                            
                            <div class="input-group mb-2">
                                <input type="text" 
                                       class="form-control" 
                                       name="colors[]" 
                                       placeholder="e.g., Navy Blue">
                                <button class="btn btn-outline-success add-color" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Add colors available for this product</small>
                    </div>
                    
                    <!-- Sizes -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Available Sizes</label>
                        <div id="sizes-container">
                            @php
                                $sizes = old('sizes', $product->sizes ?? []);
                            @endphp
                            
                            @if(!empty($sizes) && is_array($sizes))
                                @foreach($sizes as $size)
                                <div class="input-group mb-2">
                                    <input type="text" 
                                           class="form-control" 
                                           name="sizes[]" 
                                           value="{{ $size }}"
                                           placeholder="Enter size">
                                    <button class="btn btn-outline-danger remove-size" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                            
                            <div class="input-group mb-2">
                                <input type="text" 
                                       class="form-control" 
                                       name="sizes[]" 
                                       placeholder="e.g., S, M, L, XL">
                                <button class="btn btn-outline-success add-size" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Add sizes available for this product</small>
                    </div>
                </div>
                
                <!-- ============================================
                     STOCK & SELLER INFO
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Stock & Seller Information</h5>
                    </div>
                    
                    <!-- Stock Quantity -->
                    <div class="col-md-4 mb-3">
                        <label for="stock_quantity" class="form-label fw-bold">
                            Stock Quantity
                        </label>
                        <input type="number" 
                               class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" 
                               name="stock_quantity" 
                               value="{{ old('stock_quantity', $product->stock_quantity) }}"
                               min="0">
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- In Stock Toggle -->
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" 
                                   id="in_stock" name="in_stock" value="1" 
                                   {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="in_stock">
                                In Stock
                            </label>
                        </div>
                    </div>
                    
                    <!-- Seller -->
                    <div class="col-md-4 mb-3">
                        <label for="seller" class="form-label fw-bold">Seller Name</label>
                        <input type="text" 
                               class="form-control @error('seller') is-invalid @enderror" 
                               id="seller" 
                               name="seller" 
                               value="{{ old('seller', $product->seller) }}"
                               placeholder="e.g., SuperComNet">
                        @error('seller')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Seller Rating -->
                    <div class="col-md-4 mb-3">
                        <label for="seller_rating" class="form-label fw-bold">Seller Rating</label>
                        <input type="number" 
                               class="form-control @error('seller_rating') is-invalid @enderror" 
                               id="seller_rating" 
                               name="seller_rating" 
                               value="{{ old('seller_rating', $product->seller_rating) }}"
                               min="0"
                               max="5"
                               step="0.1"
                               placeholder="4.2">
                        @error('seller_rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Seller Ratings Count -->
                    <div class="col-md-4 mb-3">
                        <label for="seller_ratings_count" class="form-label fw-bold">Total Ratings</label>
                        <input type="number" 
                               class="form-control @error('seller_ratings_count') is-invalid @enderror" 
                               id="seller_ratings_count" 
                               name="seller_ratings_count" 
                               value="{{ old('seller_ratings_count', $product->seller_ratings_count) }}"
                               min="0"
                               placeholder="12000">
                        @error('seller_ratings_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Warranty -->
                    <div class="col-12 mb-3">
                        <label for="warranty" class="form-label fw-bold">Warranty Information</label>
                        <textarea class="form-control @error('warranty') is-invalid @enderror" 
                                  id="warranty" 
                                  name="warranty" 
                                  rows="3">{{ old('warranty', $product->warranty) }}</textarea>
                        @error('warranty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- ============================================
                     SEO SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">SEO Settings</h5>
                    </div>
                    
                    <!-- Meta Title -->
                    <div class="col-md-4 mb-3">
                        <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                        <input type="text" 
                               class="form-control @error('meta_title') is-invalid @enderror" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title', $product->meta_title) }}"
                               placeholder="SEO title">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Meta Keywords -->
                    <div class="col-md-4 mb-3">
                        <label for="meta_keywords" class="form-label fw-bold">Meta Keywords</label>
                        <input type="text" 
                               class="form-control @error('meta_keywords') is-invalid @enderror" 
                               id="meta_keywords" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords', $product->meta_keywords) }}"
                               placeholder="comma, separated, keywords">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Meta Description -->
                    <div class="col-md-4 mb-3">
                        <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                        <input type="text" 
                               class="form-control @error('meta_description') is-invalid @enderror" 
                               id="meta_description" 
                               name="meta_description" 
                               value="{{ old('meta_description', $product->meta_description) }}"
                               placeholder="SEO description">
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- ============================================
                     STATUS SECTION
                     ============================================ -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Status</h5>
                    </div>
                    
                    <!-- Is Active -->
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Active (Show on website)
                            </label>
                        </div>
                    </div>
                    
                    <!-- Is Featured -->
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_featured">
                                Featured Product
                            </label>
                        </div>
                    </div>
                    
                    <!-- Sort Order -->
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $product->sort_order) }}"
                               min="0">
                        <small class="text-muted">Lower number shows first</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ============================================
    // AUTO-CALCULATE DISCOUNT
    // ============================================
    function calculateDiscount() {
        let price = parseFloat($('#price').val()) || 0;
        let originalPrice = parseFloat($('#original_price').val()) || 0;
        
        if (originalPrice > price && price > 0) {
            let discount = Math.round(((originalPrice - price) / originalPrice) * 100);
            $('#discount').val(discount);
            $('#discountInfo').text(discount + '% off');
        } else {
            $('#discount').val('');
            $('#discountInfo').text('');
        }
    }
    
    $('#price, #original_price').on('input', calculateDiscount);
    
    // ============================================
    // AUTO-GENERATE SLUG FROM NAME
    // ============================================
    $('#name').on('keyup', function() {
        if ($('#slug').val() === '' || $('#slug').val() === '{{ $product->slug }}') {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#slug').val(slug);
        }
    });
    
    // ============================================
    // ADD HIGHLIGHT FIELDS
    // ============================================
    $(document).on('click', '.add-highlight', function() {
        let container = $('#highlights-container');
        container.append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="highlights[]" placeholder="Enter feature">
                <button class="btn btn-outline-danger remove-highlight" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
    });
    
    $(document).on('click', '.remove-highlight', function() {
        $(this).closest('.input-group').remove();
    });
    
    // ============================================
    // ADD SPECIFICATION FIELDS
    // ============================================
    $(document).on('click', '.add-spec', function() {
        let container = $('#specs-container');
        container.append(`
            <div class="row mb-2">
                <div class="col-5">
                    <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification">
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="specifications[value][]" placeholder="Value">
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-danger remove-spec" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);
    });
    
    $(document).on('click', '.remove-spec', function() {
        $(this).closest('.row').remove();
    });
    
    // ============================================
    // ADD COLOR FIELDS
    // ============================================
    $(document).on('click', '.add-color', function() {
        let container = $('#colors-container');
        container.append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="colors[]" placeholder="Enter color">
                <button class="btn btn-outline-danger remove-color" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
    });
    
    $(document).on('click', '.remove-color', function() {
        $(this).closest('.input-group').remove();
    });
    
    // ============================================
    // ADD SIZE FIELDS
    // ============================================
    $(document).on('click', '.add-size', function() {
        let container = $('#sizes-container');
        container.append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="sizes[]" placeholder="Enter size">
                <button class="btn btn-outline-danger remove-size" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
    });
    
    $(document).on('click', '.remove-size', function() {
        $(this).closest('.input-group').remove();
    });
    
    // ============================================
    // IMAGE PREVIEW
    // ============================================
    $('#main_image').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#mainImagePreview').attr('src', e.target.result);
                $('#mainImagePreviewContainer').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    $('#thumbnail_images').on('change', function() {
        let files = this.files;
        let preview = $('#thumbnailsPreview');
        preview.empty();
        
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = (function(e) {
                    preview.append(`
                        <div class="col-3">
                            <img src="${e.target.result}" class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                        </div>
                    `);
                })(file);
                reader.readAsDataURL(file);
            }
        }
    });
    
    // ============================================
    // FORM SUBMISSION
    // ============================================
    $('#productForm').on('submit', function(e) {
        let btn = $('#submitBtn');
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Updating...');
        btn.prop('disabled', true);
    });
});
</script>
@endpush