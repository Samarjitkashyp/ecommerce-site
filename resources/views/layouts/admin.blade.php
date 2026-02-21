{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #4895ef;
            --dark-color: #1e1e2c;
            --light-color: #f8f9fa;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fc;
            overflow-x: hidden;
        }
        
        /* Admin Wrapper */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        }
        
        .admin-sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 1px;
        }
        
        .sidebar-header .logo-mini {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-header h3 {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-header .logo-mini {
            display: block;
            font-size: 28px;
        }
        
        /* Sidebar Menu */
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            margin-bottom: 5px;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .menu-link:hover,
        .menu-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #ffd700;
        }
        
        .menu-link i {
            width: 24px;
            font-size: 18px;
            margin-right: 12px;
            text-align: center;
        }
        
        .menu-text {
            flex: 1;
            font-size: 14px;
            font-weight: 500;
        }
        
        .menu-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .menu-item.open .menu-arrow {
            transform: rotate(90deg);
        }
        
        /* Submenu */
        .submenu {
            list-style: none;
            padding-left: 0;
            margin: 0;
            background: rgba(0,0,0,0.1);
            display: none;
        }
        
        .menu-item.open > .submenu {
            display: block;
        }
        
        .submenu-item .menu-link {
            padding-left: 56px;
            font-size: 13px;
        }
        
        /* Collapsed State */
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .menu-arrow {
            display: none;
        }
        
        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 15px;
        }
        
        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 20px;
        }
        
        .sidebar.collapsed .submenu {
            display: none !important;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }
        
        .admin-main.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Header */
        .admin-header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            padding: 0 30px;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
        
        .sidebar-toggle {
            background: transparent;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            margin-left: auto;
            gap: 20px;
        }
        
        /* Search Box */
        .header-search {
            position: relative;
        }
        
        .header-search input {
            width: 300px;
            height: 40px;
            padding: 8px 40px 8px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .header-search input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .header-search button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #999;
            cursor: pointer;
        }
        
        /* Notifications */
        .notifications-dropdown {
            position: relative;
        }
        
        .notifications-btn {
            background: transparent;
            border: none;
            font-size: 20px;
            color: #555;
            cursor: pointer;
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }
        
        .notifications-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 350px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            margin-top: 10px;
            display: none;
            z-index: 1000;
        }
        
        .notifications-menu.show {
            display: block;
        }
        
        .notifications-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .notifications-header h6 {
            margin: 0;
            font-weight: 600;
        }
        
        .notifications-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .notification-item:hover {
            background: #f8f9fa;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .notification-time {
            font-size: 11px;
            color: #999;
        }
        
        .notifications-footer {
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }
        
        .notifications-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-btn {
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .user-btn:hover {
            background: #f5f5f5;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 11px;
            color: #999;
        }
        
        .user-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            margin-top: 10px;
            display: none;
            z-index: 1000;
        }
        
        .user-menu.show {
            display: block;
        }
        
        .user-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .user-menu-item:hover {
            background: #f5f5f5;
            color: var(--primary-color);
        }
        
        .user-menu-item i {
            width: 18px;
            font-size: 14px;
        }
        
        .user-menu-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 5px 0;
        }
        
        /* Content Area */
        .content-wrapper {
            padding: 30px;
        }
        
        /* Footer */
        .admin-footer {
            padding: 20px 30px;
            background: white;
            border-top: 1px solid #f0f0f0;
            text-align: center;
            color: #999;
            font-size: 13px;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-change {
            font-size: 12px;
        }
        
        .stat-change.positive {
            color: #10b981;
        }
        
        .stat-change.negative {
            color: #ef4444;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .header-search input {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .header-search {
                display: none;
            }
            
            .user-info {
                display: none;
            }
            
            .notifications-menu {
                width: 300px;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Table Styles */
        .data-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }
        
        .data-table thead th {
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
            padding: 15px;
        }
        
        .data-table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        
        .data-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Form Styles */
        .form-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }
        
        /* Button Styles */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        /* Badge Styles */
        .badge {
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge.bg-success {
            background: #10b981 !important;
        }
        
        .badge.bg-danger {
            background: #ef4444 !important;
        }
        
        .badge.bg-warning {
            background: #f59e0b !important;
        }
        
        .badge.bg-info {
            background: #3b82f6 !important;
        }
        
        /* Status Toggle */
        .status-toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .status-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: var(--success-color);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Toastr Customization */
        .toast-success {
            background-color: #10b981 !important;
        }
        
        .toast-error {
            background-color: #ef4444 !important;
        }
        
        .toast-warning {
            background-color: #f59e0b !important;
        }
        
        .toast-info {
            background-color: #3b82f6 !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('layouts.partials.admin-sidebar')
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            @include('layouts.partials.admin-header')
            
            <!-- Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            
            <!-- Footer -->
            @include('layouts.partials.admin-footer')
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // Global notification function
        function showNotification(message, type = 'info') {
            toastr[type](message);
        }
        
        // CSRF token setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            console.log('✅ Admin panel initialized');
            
            // Toastr configuration
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            // Sidebar toggle
            $('.sidebar-toggle').on('click', function() {
                $('.admin-sidebar').toggleClass('collapsed');
                $('.admin-main').toggleClass('expanded');
            });
            
            // Menu toggle
            $('.menu-item.has-submenu > .menu-link').on('click', function(e) {
                e.preventDefault();
                $(this).parent().toggleClass('open');
            });
            
            // Notifications toggle
            $('.notifications-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.notifications-menu').toggleClass('show');
            });
            
            // User menu toggle
            $('.user-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.user-menu').toggleClass('show');
            });
            
            // Close dropdowns on click outside
            $(document).on('click', function() {
                $('.notifications-menu, .user-menu').removeClass('show');
            });
            
            // Prevent closing when clicking inside dropdown
            $('.notifications-menu, .user-menu').on('click', function(e) {
                e.stopPropagation();
            });
            
            // Mobile sidebar
            $('.mobile-menu-toggle').on('click', function() {
                $('.admin-sidebar').toggleClass('show');
            });
            
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            
            // Initialize Flatpickr
            $('.datepicker').flatpickr({
                dateFormat: 'Y-m-d'
            });
            
            $('.datetimepicker').flatpickr({
                enableTime: true,
                dateFormat: 'Y-m-d H:i:S'
            });
            
            // Initialize DataTables
            $('.data-table').DataTable({
                pageLength: 25,
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
                }
            });
            
            // Handle delete confirmations
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                
                let url = $(this).data('url') || $(this).attr('href');
                let message = $(this).data('message') || 'Are you sure you want to delete this item?';
                
                if (confirm(message)) {
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
                            showNotification(xhr.responseJSON?.message || 'Error deleting item', 'error');
                        }
                    });
                }
            });
            
            // Bulk actions
            $('#selectAll').on('change', function() {
                $('.select-item').prop('checked', $(this).is(':checked'));
            });
            
            $('#bulkDeleteBtn').on('click', function() {
                let ids = [];
                $('.select-item:checked').each(function() {
                    ids.push($(this).val());
                });
                
                if (ids.length === 0) {
                    showNotification('Please select items to delete', 'warning');
                    return;
                }
                
                if (confirm('Are you sure you want to delete ' + ids.length + ' item(s)?')) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification(response.message, 'success');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500);
                            }
                        },
                        error: function(xhr) {
                            showNotification(xhr.responseJSON?.message || 'Error deleting items', 'error');
                        }
                    });
                }
            });
            
            // Status toggle
            $(document).on('change', '.status-toggle input', function() {
                let id = $(this).data('id');
                let url = $(this).data('url');
                let status = $(this).is(':checked') ? 1 : 0;
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        is_active: status
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                        }
                    },
                    error: function() {
                        showNotification('Error updating status', 'error');
                        $(this).prop('checked', !status);
                    }
                });
            });
            
            // Image preview
            $(document).on('change', '.image-upload', function() {
                let input = this;
                let preview = $(this).data('preview');
                
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $(preview).attr('src', e.target.result).show();
                    };
                    
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>