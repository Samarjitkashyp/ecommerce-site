{{-- resources/views/admin/home-categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Homepage Categories')
@section('page-title', 'Shop by Category Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-home me-2 text-primary"></i>
                    Homepage Categories
                </h5>
                <div>
                    <button class="btn btn-danger me-2" id="bulkDeleteBtn" data-url="{{ route('admin.home-categories.bulk-delete') }}" style="display: none;">
                        <i class="fas fa-trash me-2"></i>Delete Selected
                    </button>
                    <a href="{{ route('admin.home-categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Category
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($homeCategories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="categoriesTable">
                        <thead>
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th width="50">#</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Display Name</th>
                                <th>Main Category</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach($homeCategories as $index => $item)
                            <tr data-id="{{ $item->id }}" data-order="{{ $item->sort_order }}">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input select-item" type="checkbox" value="{{ $item->id }}">
                                    </div>
                                </td>
                                <td>
                                    <span class="sort-handle" style="cursor: move;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </span>
                                </td>
                                <td>
                                    <img src="{{ $item->display_image }}" 
                                         alt="{{ $item->display_name }}"
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td>
                                    <strong>{{ $item->category->name ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    @if($item->custom_name)
                                        <span class="badge bg-info">{{ $item->custom_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $item->category_id) }}" class="text-primary">
                                        {{ $item->category->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $item->id }}"
                                               data-url="{{ route('admin.home-categories.toggle-status', $item->id) }}"
                                               {{ $item->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->sort_order }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.home-categories.edit', $item->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-url="{{ route('admin.home-categories.destroy', $item->id) }}"
                                            data-name="{{ $item->display_name }}"
                                            title="Remove from homepage">
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
                        <i class="fas fa-images fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No categories added to homepage yet!</h5>
                    <p class="text-muted">Add categories to display in "Shop by Category" section.</p>
                    <a href="{{ route('admin.home-categories.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add Your First Category
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

.sortable-drag {
    opacity: 1;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.sort-handle {
    cursor: move;
    padding: 5px;
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
    // 🟢 Initialize Sortable for drag-drop ordering
    let sortableTable = document.getElementById('sortable');
    if (sortableTable) {
        new Sortable(sortableTable, {
            animation: 150,
            handle: '.sort-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }
    
    // 🟢 Update order after drag-drop
    function updateOrder() {
        let items = [];
        $('#sortable tr').each(function(index) {
            items.push({
                id: $(this).data('id'),
                sort_order: index
            });
        });
        
        $.ajax({
            url: '{{ route("admin.home-categories.update-order") }}',
            type: 'POST',
            data: {
                items: items,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Order updated!', 'success');
                    // Update displayed order numbers
                    $('#sortable tr').each(function(index) {
                        $(this).find('td:eq(7) span').text(index);
                    });
                }
            },
            error: function() {
                showNotification('Error updating order', 'error');
            }
        });
    }
    
    // 🟢 Select all checkbox
    $('#selectAll').on('change', function() {
        $('.select-item').prop('checked', $(this).is(':checked'));
        toggleBulkDelete();
    });
    
    // 🟢 Individual checkbox
    $(document).on('change', '.select-item', function() {
        let allChecked = $('.select-item:checked').length === $('.select-item').length;
        $('#selectAll').prop('checked', allChecked);
        toggleBulkDelete();
    });
    
    // 🟢 Show/hide bulk delete button
    function toggleBulkDelete() {
        if ($('.select-item:checked').length > 0) {
            $('#bulkDeleteBtn').show();
        } else {
            $('#bulkDeleteBtn').hide();
        }
    }
    
    // 🟢 Bulk delete
    $('#bulkDeleteBtn').on('click', function() {
        let ids = [];
        $('.select-item:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (ids.length === 0) {
            showNotification('Select items to delete', 'warning');
            return;
        }
        
        if (confirm('Remove ' + ids.length + ' categor' + (ids.length > 1 ? 'ies' : 'y') + ' from homepage?')) {
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                data: {
                    ids: ids,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function() {
                    showNotification('Error deleting items', 'error');
                }
            });
        }
    });
    
    // 🟢 Delete single item
    $(document).on('click', '.delete-btn', function() {
        let btn = $(this);
        let url = btn.data('url');
        let name = btn.data('name');
        
        if (confirm('Remove "' + name + '" from homepage?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function() {
                    showNotification('Error removing category', 'error');
                }
            });
        }
    });
    
    // 🟢 Status toggle
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
                    showNotification(response.message, 'success');
                }
            },
            error: function() {
                checkbox.prop('checked', !isChecked);
                showNotification('Error updating status', 'error');
            }
        });
    });
});
</script>
@endpush