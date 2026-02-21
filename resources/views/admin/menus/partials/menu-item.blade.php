{{-- resources/views/admin/menus/partials/menu-item.blade.php --}}
<div class="menu-item" data-id="{{ $menu->id }}" id="menu-{{ $menu->id }}">
    <div class="menu-item-content">
        <div class="menu-handle">
            <i class="fas fa-grip-vertical"></i>
        </div>
        
        <div class="menu-icon">
            <i class="{{ $menu->icon ?: 'fas fa-link' }}"></i>
        </div>
        
        <div class="menu-info">
            <div class="menu-name">
                {{ $menu->name }}
                <span class="menu-badge">{{ $menu->type }}</span>
                @if($menu->is_active)
                    <span class="menu-badge active">Active</span>
                @endif
            </div>
            <div class="menu-url">
                @if($menu->type == 'category' && $menu->category)
                    <i class="fas fa-folder me-1"></i> Category: {{ $menu->category->name }}
                @elseif($menu->url)
                    <i class="fas fa-link me-1"></i> {{ $menu->url }}
                @elseif($menu->route)
                    <i class="fas fa-route me-1"></i> {{ $menu->route }}
                @endif
            </div>
        </div>
        
        <div class="menu-actions">
            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-outline-danger delete-menu" 
                    data-url="{{ route('admin.menus.destroy', $menu->id) }}"
                    data-name="{{ $menu->name }}">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    
    @if($menu->children->count() > 0)
        <div class="child-menus">
            @foreach($menu->children->sortBy('sort_order') as $child)
                @include('admin.menus.partials.menu-item', ['menu' => $child])
            @endforeach
        </div>
    @endif
</div>