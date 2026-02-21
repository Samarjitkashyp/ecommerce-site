{{-- resources/views/admin/menus/create.blade.php --}}
@extends('layouts.admin')

@section('title', isset($menu) ? 'Edit Menu' : 'Create Menu')
@section('page-title', isset($menu) ? 'Edit Menu: ' . $menu->name : 'Create New Menu')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="form-card">
            <form action="{{ isset($menu) ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}" 
                  method="POST" 
                  id="menuForm">
                @csrf
                @if(isset($menu))
                    @method('PUT')
                @endif
                
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-12 mb-4">
                        <h5 class="border-bottom pb-2">Basic Information</h5>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $menu->name ?? '') }}" 
                               placeholder="e.g., MX Player" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Menu Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" {{ old('type', $menu->type ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Dynamic Fields Based on Type -->
                    <div class="col-md-12 mb-3" id="urlField" style="display: none;">
                        <label for="url" class="form-label">Custom URL</label>
                        <input type="url" class="form-control" id="url" name="url" 
                               value="{{ old('url', $menu->url ?? '') }}" 
                               placeholder="https://example.com">
                        <small class="text-muted">Enter full URL including https://</small>
                    </div>
                    
                    <div class="col-md-12 mb-3" id="routeField" style="display: none;">
                        <label for="route" class="form-label">Route Name</label>
                        <input type="text" class="form-control" id="route" name="route" 
                               value="{{ old('route', $menu->route ?? '') }}" 
                               placeholder="e.g., home, category">
                        <small class="text-muted">Enter Laravel route name</small>
                    </div>
                    
                    <div class="col-md-12 mb-3" id="categoryField" style="display: none;">
                        <label for="category_id" class="form-label">Select Category</label>
                        <select class="form-select select2" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->path }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Display Settings -->
                    <div class="col-md-12 mt-4 mb-4">
                        <h5 class="border-bottom pb-2">Display Settings</h5>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Menu Location <span class="text-danger">*</span></label>
                        <select class="form-select @error('location') is-invalid @enderror" 
                                id="location" name="location" required>
                            @foreach($locations as $value => $label)
                                <option value="{{ $value }}" {{ old('location', $menu->location ?? request('location', 'main')) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">None (Top Level)</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select parent for dropdown menu</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon Class</label>
                        <input type="text" class="form-control" id="icon" name="icon" 
                               value="{{ old('icon', $menu->icon ?? '') }}" 
                               placeholder="e.g., fas fa-home">
                        <small class="text-muted">Font Awesome icon class</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="target" class="form-label">Open In</label>
                        <select class="form-select" id="target" name="target">
                            <option value="_self" {{ old('target', $menu->target ?? '') == '_self' ? 'selected' : '' }}>Same Window</option>
                            <option value="_blank" {{ old('target', $menu->target ?? '') == '_blank' ? 'selected' : '' }}>New Window</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" 
                               value="{{ old('sort_order', $menu->sort_order ?? 0) }}" min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="is_visible" name="is_visible" value="1" 
                                   {{ old('is_visible', $menu->is_visible ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_visible">Visible to Guests</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        {{ isset($menu) ? 'Update Menu' : 'Create Menu' }}
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
    // Show/hide fields based on menu type
    function toggleFields() {
        let type = $('#type').val();
        
        $('.dynamic-field').hide();
        
        switch(type) {
            case 'link':
                $('#urlField').show();
                break;
            case 'route':
                $('#routeField').show();
                break;
            case 'category':
                $('#categoryField').show();
                break;
            case 'dropdown':
                // No additional fields needed
                break;
        }
    }
    
    // Initial toggle
    toggleFields();
    
    // On type change
    $('#type').on('change', toggleFields);
    
    // Form submission
    $('#menuForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let btn = $('#submitBtn');
        let originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    if (response.redirect) {
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1500);
                    }
                }
            },
            error: function(xhr) {
                btn.html(originalText);
                btn.prop('disabled', false);
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    
                    $.each(errors, function(key, value) {
                        errorMessages.push(value[0]);
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });
                    
                    showNotification(errorMessages.join('<br>'), 'error');
                } else {
                    showNotification(xhr.responseJSON?.message || 'Error saving menu', 'error');
                }
            }
        });
    });
});
</script>
@endpush