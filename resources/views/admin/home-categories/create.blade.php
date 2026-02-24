{{-- resources/views/admin/home-categories/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Category to Homepage')
@section('page-title', 'Add Category to Homepage')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Add New Category to Homepage</h5>
            </div>
            <div class="card-body">
                
                {{-- 🟢 DEBUG: Show if no categories --}}
                @if($categories->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>No categories found!</strong> 
                    Please <a href="{{ route('admin.categories.create') }}" class="alert-link">create categories first</a>.
                </div>
                @endif

                <form action="{{ route('admin.home-categories.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      id="homeCategoryForm">
                    @csrf
                    
                    {{-- 🟢 CATEGORY SELECTION --}}
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-bold">
                            Select Category <span class="text-danger">*</span>
                        </label>
                        
                        {{-- 🟢 FIXED: Proper select dropdown --}}
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required
                                style="padding: 10px; font-size: 15px;">
                            
                            <option value="" selected disabled>-- Choose a category --</option>
                            
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                    @if($category->parent)
                                        ({{ $category->parent->name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Select the category you want to display on homepage
                        </small>
                        
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 🟢 CUSTOM NAME --}}
                    <div class="mb-4">
                        <label for="custom_name" class="form-label fw-bold">
                            Custom Display Name <span class="text-muted">(Optional)</span>
                        </label>
                        
                        <input type="text" 
                               class="form-control @error('custom_name') is-invalid @enderror" 
                               id="custom_name" 
                               name="custom_name" 
                               value="{{ old('custom_name') }}"
                               placeholder="e.g., New Tech, Hot Deals, etc."
                               style="padding: 10px; font-size: 15px;">
                        
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Leave empty to use category's original name
                        </small>
                        
                        @error('custom_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 🟢 CUSTOM IMAGE --}}
                    <div class="mb-4">
                        <label for="custom_image" class="form-label fw-bold">
                            Custom Image <span class="text-muted">(Optional)</span>
                        </label>
                        
                        <input type="file" 
                               class="form-control @error('custom_image') is-invalid @enderror" 
                               id="custom_image" 
                               name="custom_image" 
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               style="padding: 10px;">
                        
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Upload a custom image (JPEG, PNG, JPG, WEBP, max 2MB).<br>
                            If not uploaded, category's default image will be used.
                        </small>
                        
                        @error('custom_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 🟢 IMAGE PREVIEW --}}
                    <div class="mb-4" id="imagePreviewContainer" style="display: none;">
                        <label class="form-label fw-bold">Preview:</label>
                        <div>
                            <img id="imagePreview" 
                                 src="#" 
                                 alt="Preview" 
                                 style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreview" style="display: none;">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>

                    {{-- 🟢 ACTIVE STATUS --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   style="width: 40px; height: 20px;">
                            <label class="form-check-label fw-bold" for="is_active">
                                Show on Homepage
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Uncheck to hide this category temporarily
                        </small>
                    </div>

                    {{-- 🟢 PREVIEW CARD --}}
                    <div class="mb-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Preview (How it will look on homepage)</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="preview-box d-inline-block p-3">
                                    <div style="width: 120px; height: 120px; background: #f0f0f0; border-radius: 12px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;" id="previewImageBox">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                    <div class="fw-bold" id="previewName">Category Name</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 🟢 FORM BUTTONS --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.home-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>
                            Add to Homepage
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
$(document).ready(function() {
    console.log('✅ Create page loaded');
    
    // 🟢 Image preview
    $('#custom_image').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreviewContainer').show();
                $('#removePreview').show();
                
                // Update preview box
                $('#previewImageBox').html('<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // 🟢 Remove preview
    $('#removePreview').on('click', function() {
        $('#custom_image').val('');
        $('#imagePreviewContainer').hide();
        $('#removePreview').hide();
        $('#previewImageBox').html('<i class="fas fa-image fa-3x text-muted"></i>');
    });
    
    // 🟢 Update preview when category or custom name changes
    $('#category_id, #custom_name').on('change keyup', function() {
        updatePreview();
    });
    
    function updatePreview() {
        let categoryId = $('#category_id').val();
        let customName = $('#custom_name').val();
        
        if (categoryId) {
            let selectedText = $('#category_id option:selected').text();
            $('#previewName').text(customName || selectedText);
        }
    }
    
    // Initial preview update
    updatePreview();
    
    // 🟢 Form submission
    $('#homeCategoryForm').on('submit', function(e) {
        let categoryId = $('#category_id').val();
        
        if (!categoryId) {
            e.preventDefault();
            alert('Please select a category');
            return false;
        }
    });
});
</script>
@endpush