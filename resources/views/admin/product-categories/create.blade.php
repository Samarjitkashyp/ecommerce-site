{{-- resources/views/admin/product-categories/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Product Category')
@section('page-title', 'Add New Product Category')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Create New Product Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-categories.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="e.g., Fashion, Electronics, Books"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">
                            Slug <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               placeholder="Auto-generated from name">
                        <small class="text-muted">Leave empty to auto-generate</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="parent_id" class="form-label fw-bold">
                            Parent Category <span class="text-muted">(Optional)</span>
                        </label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" 
                                id="parent_id" 
                                name="parent_id">
                            <option value="">— None (Top Level) —</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select parent category for subcategory</small>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">
                            Description <span class="text-muted">(Optional)</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label fw-bold">
                                    Icon Class <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon') }}"
                                       placeholder="e.g., fas fa-tshirt">
                                <small class="text-muted">Font Awesome icon</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label fw-bold">
                                    Sort Order <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}"
                                       min="0">
                                <small class="text-muted">Lower number shows first</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">
                            Category Image <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small class="text-muted">Max size: 2MB (JPEG, PNG, JPG, WEBP)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                        <label class="form-label fw-bold">Preview:</label>
                        <div>
                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Active (Show on website)
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview
    $('#image').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreviewContainer').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Auto-generate slug from name
    $('#name').on('keyup', function() {
        if ($('#slug').val() === '') {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#slug').val(slug);
        }
    });
</script>
@endpush