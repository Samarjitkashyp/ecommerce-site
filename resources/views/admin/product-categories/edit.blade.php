{{-- resources/views/admin/product-categories/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Product Category')
@section('page-title', 'Edit: ' . $productCategory->name)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Product Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-categories.update', $productCategory->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $productCategory->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">
                            Slug
                        </label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $productCategory->slug) }}">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="parent_id" class="form-label fw-bold">
                            Parent Category
                        </label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" 
                                id="parent_id" 
                                name="parent_id">
                            <option value="">— None (Top Level) —</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" 
                                    {{ old('parent_id', $productCategory->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description', $productCategory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label fw-bold">
                                    Icon Class
                                </label>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon', $productCategory->icon) }}"
                                       placeholder="e.g., fas fa-tshirt">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label fw-bold">
                                    Sort Order
                                </label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $productCategory->sort_order ?? 0) }}"
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">
                            Category Image
                        </label>
                        
                        @if($productCategory->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$productCategory->image) }}" 
                                 alt="{{ $productCategory->name }}" 
                                 style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                            <div class="mt-1">
                                <label>
                                    <input type="checkbox" name="remove_image" value="1"> Remove current image
                                </label>
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small class="text-muted">Leave empty to keep current image</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                        <label class="form-label fw-bold">New Image Preview:</label>
                        <div>
                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $productCategory->is_active) ? 'checked' : '' }}>
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
                            <i class="fas fa-save me-2"></i>Update Category
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
    
    // Auto-generate slug from name (only if empty or unchanged)
    $('#name').on('keyup', function() {
        let currentSlug = $('#slug').val();
        if (currentSlug === '' || currentSlug === '{{ $productCategory->slug }}') {
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