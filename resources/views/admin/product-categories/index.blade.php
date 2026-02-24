{{-- resources/views/admin/product-categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Product Categories')
@section('page-title', 'Product Categories Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2 text-primary"></i>
                    All Product Categories
                </h5>
                <div>
                    <button class="btn btn-danger me-2" id="bulkDeleteBtn" style="display: none;">
                        <i class="fas fa-trash me-2"></i>Delete Selected
                    </button>
                    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Category
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="categoriesTable">
                        <thead>
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th width="50">Order</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach($categories as $index => $category)
                            <tr data-id="{{ $category->id }}" data-order="{{ $category->sort_order }}">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input select-item" type="checkbox" value="{{ $category->id }}">
                                    </div>
                                </td>
                                <td>
                                    <span class="sort-handle" style="cursor: move;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                        <span class="badge bg-secondary ms-1">{{ $category->sort_order ?? 0 }}</span>
                                    </span>
                                </td>
                                <td>
                                    <img src="{{ $category->image_url }}" 
                                         alt="{{ $category->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} ms-1 text-muted"></i>
                                    @endif
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>
                                    @if($category->parent)
                                        {{ $category->parent->name }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $category->id }}"
                                               data-url="{{ route('admin.product-categories.toggle-status', $category->id) }}"
                                               {{ $category->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.product-categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-url="{{ route('admin.product-categories.destroy', $category->id) }}"
                                            data-name="{{ $category->name }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-tags fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No product categories found!</h5>
                    <p class="text-muted">Create your first product category.</p>
                    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add New Category
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.sortable-ghost {
    opacity: 0.4;
    background: #f0f0f0;
}
.sort-handle:hover {
    color: #4361ee;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Sortable for drag-drop
    let sortableTable = document.getElementById('sortable');
    if (sortableTable) {
        new Sortable(sortableTable, {
            animation: 150,
            handle: '.sort-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateOrder();
            }
        });
    }
    
    function updateOrder() {
        let items = [];
        $('#sortable tr').each(function(index) {
            items.push({
                id: $(this).data('id'),
                sort_order: index
            });
        });
        
        $.ajax({
            url: '{{ route("admin.product-categories.update-order") }}',
            type: 'POST',
            data: {
                items: items,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Order updated!');
                    // Update badges
                    $('#sortable tr').each(function(index) {
                        $(this).find('.badge').text(index);
                    });
                }
            },
            error: function() {
                toastr.error('Error updating order');
            }
        });
    }
    
    // Select all
    $('#selectAll').on('change', function() {
        $('.select-item').prop('checked', $(this).is(':checked'));
        toggleBulkDelete();
    });
    
    $(document).on('change', '.select-item', function() {
        let allChecked = $('.select-item:checked').length === $('.select-item').length;
        $('#selectAll').prop('checked', allChecked);
        toggleBulkDelete();
    });
    
    function toggleBulkDelete() {
        if ($('.select-item:checked').length > 0) {
            $('#bulkDeleteBtn').show();
        } else {
            $('#bulkDeleteBtn').hide();
        }
    }
    
    // Status toggle
    $(document).on('change', '.status-toggle', function() {
        let checkbox = $(this);
        let url = checkbox.data('url');
        let isChecked = checkbox.is(':checked');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                checkbox.prop('checked', !isChecked);
                toastr.error('Error updating status');
            }
        });
    });
    
    // Delete single
    $(document).on('click', '.delete-btn', function() {
        let btn = $(this);
        let url = btn.data('url');
        let name = btn.data('name');
        
        if (confirm('Delete category "' + name + '"?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(xhr) {
                    let message = 'Error deleting category';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
                }
            });
        }
    });
    
    // Bulk delete
    $('#bulkDeleteBtn').on('click', function() {
        let ids = [];
        $('.select-item:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (ids.length === 0) return;
        
        if (confirm('Delete ' + ids.length + ' categories?')) {
            $.ajax({
                url: '{{ route("admin.product-categories.bulk-delete") }}',
                type: 'POST',
                data: {
                    ids: ids,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let message = 'Error deleting categories';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
                }
            });
        }
    });
});
</script>
@endpush