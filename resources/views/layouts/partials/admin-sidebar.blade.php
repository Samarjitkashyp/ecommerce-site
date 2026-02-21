{{-- resources/views/layouts/partials/admin-sidebar.blade.php --}}
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h3 class="logo-text">{{ config('app.name') }}</h3>
        <div class="logo-mini">
            <i class="fas fa-store"></i>
        </div>
    </div>
    
    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        @foreach($adminMenu as $key => $item)
            @php
                $isActive = request()->routeIs($item['route'] . '*');
                $hasSubmenu = isset($item['submenu']);
            @endphp
            
            <div class="menu-item {{ $hasSubmenu ? 'has-submenu' : '' }} {{ $isActive ? 'open' : '' }}">
                <a href="{{ $hasSubmenu ? '#' : route($item['route']) }}" 
                   class="menu-link {{ $isActive ? 'active' : '' }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="menu-text">{{ $item['name'] }}</span>
                    @if($hasSubmenu)
                        <i class="fas fa-chevron-right menu-arrow"></i>
                    @endif
                </a>
                
                @if($hasSubmenu)
                    <ul class="submenu">
                        @foreach($item['submenu'] as $subItem)
                            <li class="submenu-item">
                                <a href="{{ route($subItem['route']) }}" 
                                   class="menu-link {{ request()->routeIs($subItem['route']) ? 'active' : '' }}">
                                    <span class="menu-text">{{ $subItem['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="version-info">
            <small>Version 1.0.0</small>
        </div>
    </div>
</aside>

<style>
.sidebar-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 15px 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
    text-align: center;
    font-size: 12px;
    color: rgba(255,255,255,0.5);
}

.version-info {
    opacity: 0.8;
}

.sidebar.collapsed .sidebar-footer {
    display: none;
}
</style>