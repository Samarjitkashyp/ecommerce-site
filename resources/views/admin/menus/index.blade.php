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
                                <div class="menu-items" id="sortable-{{ $location }}">
                                    @foreach($parentMenus as $menu)
                                        @include('admin.menus.partials.menu-item', ['menu' => $menu])
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-bars fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">No menus in this location</h6>
                                    <a href="{{ route('admin.menus.create', ['location' => $location]) }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Add Menu
                                    </a>
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
    border-color: var(--primary-color);
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
    color: var(--primary-color);
}

.menu-icon {
    width: 32px;
    height: 32px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
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
    background: var(--success-color);
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
    border: 2px dashed var(--primary-color);
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
$(document).ready(function() {
    // Initialize sortable for each location
    @foreach(['main', 'top', 'footer', 'sidebar'] as $location)
    new Sortable(document.getElementById('sortable-{{ $location }}'), {
        animation: 150,
        handle: '.menu-handle',
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd: function(evt) {
            updateMenuOrder(evt.from);
        }
    });
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
                items: items
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Menu order updated!', 'success');
                }
            },
            error: function() {
                showNotification('Error updating menu order', 'error');
            }
        });
    }
    
    // Delete menu
    $(document).on('click', '.delete-menu', function(e) {
        e.preventDefault();
        
        let url = $(this).data('url');
        let name = $(this).data('name');
        
        if (confirm('Are you sure you want to delete "' + name + '"?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    showNotification(xhr.responseJSON?.message || 'Error deleting menu', 'error');
                }
            });
        }
    });
});
</script>
@endpush