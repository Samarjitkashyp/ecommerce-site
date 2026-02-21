{{-- resources/views/layouts/partials/admin-header.blade.php --}}
<header class="admin-header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
    </div>
    
    <div class="header-right">
        <!-- Search -->
        <div class="header-search">
            <form action="{{ route('admin.search') }}" method="GET">
                <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <!-- Notifications -->
        <div class="notifications-dropdown">
            <button class="notifications-btn" id="notificationsBtn">
                <i class="far fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            
            <div class="notifications-menu" id="notificationsMenu">
                <div class="notifications-header">
                    <h6>Notifications</h6>
                    <span class="badge bg-primary">3 new</span>
                </div>
                
                <div class="notifications-list">
                    <div class="notification-item">
                        <div class="notification-icon bg-primary bg-opacity-10">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">New Order #12345</div>
                            <div class="notification-time">5 minutes ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <div class="notification-icon bg-success bg-opacity-10">
                            <i class="fas fa-user text-success"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">New User Registered</div>
                            <div class="notification-time">1 hour ago</div>
                        </div>
                    </div>
                    
                    <div class="notification-item">
                        <div class="notification-icon bg-warning bg-opacity-10">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Low Stock Alert</div>
                            <div class="notification-time">3 hours ago</div>
                        </div>
                    </div>
                </div>
                
                <div class="notifications-footer">
                    <a href="{{ route('admin.notifications') }}">View All Notifications</a>
                </div>
            </div>
        </div>
        
        <!-- User Dropdown -->
        <div class="user-dropdown">
            <button class="user-btn" id="userBtn">
                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=667eea&color=fff&bold=true' }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="user-avatar">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
            </button>
            
            <div class="user-menu" id="userMenu">
                <a href="{{ route('admin.profile') }}" class="user-menu-item">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
                
                <a href="{{ url('/admin/settings') }}" class="user-menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                
                <a href="{{ route('admin.activity') }}" class="user-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Activity Log</span>
                </a>
                
                <div class="user-menu-divider"></div>
                
                <a href="{{ route('home') }}" class="user-menu-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Visit Website</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none;">
                    @csrf
                </form>
                
                <a href="#" class="user-menu-item text-danger" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>