{{-- resources/views/admin/menus/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Menu Management')
@section('page-title', 'Menu Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Menus</h5>
                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Menu
                </a>
            </div>
            <div class="card-body">
                <!-- Location Tabs -->
                <ul class="nav nav-tabs mb-4" id="menuTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab">
                            Main Navigation
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="top-tab" data-bs-toggle="tab" data-bs-target="#top" type="button" role="tab">
                            Top Bar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" type="button" role="tab">
                            Footer
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sidebar-tab" data-bs-toggle="tab" data-bs-target="#sidebar" type="button" role="tab">
                            Sidebar
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content" id="menuTabsContent">
                    @foreach(['main', 'top', 'footer', 'sidebar'] as $location)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $location }}" role="tabpanel">
                        <div class="menu-builder">
                            @php
                                $locationMenus = $groupedMenus[$location] ?? collect();
                                $parentMenus = $locationMenus->whereNull('parent_id')->sortBy('sort_order');
                            @endphp
                            
                            @if($parentMenus->count() > 0)
                                {{-- 🟢 FIX: Only create sortable container if menus exist --}}
                                <div class="menu-items" id="sortable-{{ $location }}" data-has-menus="true">
                                    @foreach($parentMenus as $menu)
                                        @include('admin.menus.partials.menu-item', ['menu' => $menu])
                                    @endforeach
                                </div>
                            @else
                                <div class="menu-items" id="sortable-{{ $location }}" data-has-menus="false" style="min-height: 100px;">
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fas fa-bars fa-3x text-muted opacity-50"></i>
                                        </div>
                                        <h6 class="text-muted">No menus in this location</h6>
                                        <a href="{{ route('admin.menus.create', ['location' => $location]) }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus me-2"></i>Add Menu
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.menu-items {
    min-height: 200px;
}

.menu-item {
    margin-bottom: 10px;
}

.menu-item-content {
    background: white;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

.menu-item-content:hover {
    border-color: #4361ee;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.menu-item.dragging .menu-item-content {
    opacity: 0.5;
    transform: scale(0.98);
}

.menu-handle {
    cursor: move;
    color: #999;
    font-size: 16px;
}

.menu-handle:hover {
    color: #4361ee;
}

.menu-icon {
    width: 32px;
    height: 32px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4361ee;
}

.menu-info {
    flex: 1;
}

.menu-name {
    font-weight: 600;
    margin-bottom: 3px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.menu-url {
    font-size: 12px;
    color: #999;
}

.menu-badge {
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 12px;
    background: #f0f0f0;
    color: #666;
}

.menu-badge.active {
    background: #10b981;
    color: white;
}

.menu-badge.child-count {
    background: #4361ee;
    color: white;
}

.menu-actions {
    display: flex;
    gap: 8px;
}

.menu-actions .btn {
    padding: 5px 10px;
    font-size: 12px;
}

.child-menus {
    margin-left: 50px;
    margin-top: 10px;
    padding-left: 20px;
    border-left: 2px dashed #e1e1e1;
}

.sortable-ghost {
    opacity: 0.4;
    background: #f0f0f0;
    border: 2px dashed #4361ee;
}

.sortable-drag {
    opacity: 1;
    transform: rotate(2deg);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// 🟢 FIX: Disable WebSocket errors
if (typeof window.WebSocket !== 'undefined') {
    const originalWebSocket = window.WebSocket;
    window.WebSocket = function(url, ...args) {
        if (url.includes('localhost:8081')) {
            console.log('WebSocket connection ignored');
            return {
                send: function() {},
                close: function() {}
            };
        }
        return new originalWebSocket(url, ...args);
    };
}

// Global notification function
function showNotification(message, type = 'info') {
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(message);
    }
}

$(document).ready(function() {
    // 🟢 FIX: Initialize sortable only for containers that have menus
    @foreach(['main', 'top', 'footer', 'sidebar'] as $location)
    let container{{ $location }} = document.getElementById('sortable-{{ $location }}');
    if (container{{ $location }} && container{{ $location }}.dataset.hasMenus === 'true') {
        new Sortable(container{{ $location }}, {
            animation: 150,
            handle: '.menu-handle',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateMenuOrder(evt.from);
            }
        });
    }
    @endforeach
    
    function updateMenuOrder(container) {
        let items = [];
        $(container).find('.menu-item').each(function(index) {
            items.push({
                id: $(this).data('id'),
                sort_order: index
            });
        });
        
        $.ajax({
            url: '{{ route("admin.menus.update-order") }}',
            type: 'POST',
            data: {
                items: items,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Menu order updated!', 'success');
                }
            },
            error: function(xhr) {
                console.error('Order update error:', xhr);
                showNotification('Error updating menu order', 'error');
            }
        });
    }
    
    // 🟢 FIXED: Delete menu with children support
    $(document).on('click', '.delete-menu', function(e) {
        e.preventDefault();
        
        let button = $(this);
        let url = button.data('url');
        let name = button.data('name');
        let menuItem = button.closest('.menu-item');
        
        // Check if menu has children (visible child menus)
        let hasChildren = menuItem.find('.child-menus').length > 0;
        let childCount = menuItem.find('.child-menus .menu-item').length;
        
        // Custom confirmation message based on children
        let confirmMessage = 'Are you sure you want to delete "' + name + '"?';
        if (hasChildren) {
            confirmMessage = '⚠️ This menu has ' + childCount + ' child item(s). All child items will also be deleted. Continue?';
        }
        
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Disable button and show loading
        let originalHtml = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i>');
        button.prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    // Remove menu item with animation
                    menuItem.fadeOut(300, function() {
                        $(this).remove();
                        
                        // If no menus left in this location, update the container
                        let locationTab = menuItem.closest('.tab-pane');
                        let menuContainer = locationTab.find('.menu-items');
                        
                        if (locationTab.find('.menu-item').length === 0) {
                            menuContainer.attr('data-has-menus', 'false');
                            menuContainer.html(`
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-bars fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">No menus in this location</h6>
                                    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Add Menu
                                    </a>
                                </div>
                            `);
                        }
                    });
                } else {
                    button.html(originalHtml);
                    button.prop('disabled', false);
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                console.error('Delete error:', xhr);
                button.html(originalHtml);
                button.prop('disabled', false);
                
                let message = 'Error deleting menu';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showNotification(message, 'error');
            }
        });
    });
    
    // Duplicate menu functionality
    $(document).on('click', '.duplicate-menu', function(e) {
        e.preventDefault();
        
        let button = $(this);
        let url = button.data('url');
        let name = button.data('name');
        
        // Disable button and show loading
        let originalHtml = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i>');
        button.prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    // Reload to show duplicated menu
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    button.html(originalHtml);
                    button.prop('disabled', false);
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                console.error('Duplicate error:', xhr);
                button.html(originalHtml);
                button.prop('disabled', false);
                
                let message = 'Error duplicating menu';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showNotification(message, 'error');
            }
        });
    });
});
</script>
@endpush