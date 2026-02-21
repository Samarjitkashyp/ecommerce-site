{{-- resources/views/account/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'My Account Dashboard')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="account-section py-4">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="account-sidebar card">
                    <div class="card-body text-center p-4">
                        <div class="avatar-wrapper mb-3 position-relative">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #febd69;">
                            <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                                    style="width: 35px; height: 35px;" 
                                    onclick="document.getElementById('avatarInput').click();">
                                <i class="fas fa-camera"></i>
                            </button>
                            <form id="avatarForm" style="display: none;">
                                @csrf
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                            </form>
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                        <div class="d-grid">
                            <a href="{{ route('account.profile') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i> My Orders
                            @if(isset($pendingOrders) && $pendingOrders > 0)
                            <span class="badge bg-warning float-end">{{ $pendingOrders }}</span>
                            @endif
                        </a>
                        <a href="{{ route('account.wishlist') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-heart me-2"></i> Wishlist
                            @if($wishlistCount > 0)
                            <span class="badge bg-danger float-end">{{ $wishlistCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-map-marker-alt me-2"></i> Addresses
                            @if($addressCount > 0)
                            <span class="badge bg-info float-end">{{ $addressCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-cog me-2"></i> Profile Settings
                        </a>
                        <a href="#" class="list-group-item list-group-item-action text-danger" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Welcome Banner -->
                <div class="welcome-banner card mb-4 bg-primary text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-hand-peace fa-3x"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h4>
                                <p class="mb-0 opacity-75">Manage your account, track orders, and more.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stats-card card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="stats-icon bg-primary bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                    <i class="fas fa-shopping-bag text-primary fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $totalOrders ?? 0 }}</h3>
                                <p class="text-muted mb-0">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-card card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="stats-icon bg-success bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                    <i class="fas fa-clock text-success fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $pendingOrders ?? 0 }}</h3>
                                <p class="text-muted mb-0">Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-card card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="stats-icon bg-info bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                    <i class="fas fa-check-circle text-info fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $deliveredOrders ?? 0 }}</h3>
                                <p class="text-muted mb-0">Delivered</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-card card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="stats-icon bg-danger bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                    <i class="fas fa-heart text-danger fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $wishlistCount ?? 0 }}</h3>
                                <p class="text-muted mb-0">Wishlist</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="recent-orders-card card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>
                            Recent Orders
                        </h5>
                        <a href="{{ route('account.orders') }}" class="btn btn-link text-decoration-none">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">#{{ $order->order_number }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted small">
                                                    <i class="far fa-calendar me-1"></i>
                                                    {{ $order->created_at->format('d M, Y') }}
                                                </span>
                                            </td>
                                            <td>{{ $order->items->count() }} item(s)</td>
                                            <td>
                                                <span class="fw-bold">₹{{ number_format($order->total) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'info',
                                                        'processing' => 'primary',
                                                        'shipped' => 'secondary',
                                                        'out_for_delivery' => 'dark',
                                                        'delivered' => 'success',
                                                        'cancelled' => 'danger',
                                                        'returned' => 'danger',
                                                    ];
                                                    $color = $statusColors[$order->order_status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ str_replace('_', ' ', ucfirst($order->order_status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('account.order.detail', $order->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state mb-3">
                                    <i class="fas fa-shopping-bag fa-4x text-muted opacity-50"></i>
                                </div>
                                <h6 class="text-muted mb-3">No orders yet!</h6>
                                <a href="{{ url('/') }}" class="btn btn-primary">
                                    <i class="fas fa-home me-2"></i>Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions mt-4">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('category', 'fashion') }}" class="text-decoration-none">
                                <div class="action-card card h-100 border-0 shadow-sm text-center p-3">
                                    <i class="fas fa-tshirt fa-2x text-primary mb-2"></i>
                                    <span class="small">Shop Fashion</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('category', 'electronics') }}" class="text-decoration-none">
                                <div class="action-card card h-100 border-0 shadow-sm text-center p-3">
                                    <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                                    <span class="small">Electronics</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('account.wishlist') }}" class="text-decoration-none">
                                <div class="action-card card h-100 border-0 shadow-sm text-center p-3">
                                    <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                    <span class="small">Wishlist</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('account.addresses') }}" class="text-decoration-none">
                                <div class="action-card card h-100 border-0 shadow-sm text-center p-3">
                                    <i class="fas fa-map-marker-alt fa-2x text-info mb-2"></i>
                                    <span class="small">Add Address</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.account-sidebar {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-radius: 10px;
    overflow: hidden;
}

.account-sidebar .list-group-item {
    border: none;
    padding: 12px 20px;
    color: #333;
    font-size: 14px;
    transition: all 0.3s ease;
}

.account-sidebar .list-group-item i {
    width: 20px;
    color: #666;
}

.account-sidebar .list-group-item:hover {
    background-color: #fff9f0;
    color: #febd69;
    padding-left: 25px;
}

.account-sidebar .list-group-item:hover i {
    color: #febd69;
}

.account-sidebar .list-group-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.account-sidebar .list-group-item.active i {
    color: white;
}

.stats-card {
    transition: all 0.3s ease;
    border-radius: 10px;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.stats-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.welcome-banner .card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
}

.recent-orders-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.recent-orders-card .card-header {
    border-bottom: 1px solid #f0f0f0;
    padding: 15px 20px;
}

.table th {
    font-size: 13px;
    font-weight: 600;
    color: #666;
}

.table td {
    font-size: 14px;
    vertical-align: middle;
}

.action-card {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.action-card:hover i,
.action-card:hover span {
    color: white !important;
}

.action-card i {
    transition: all 0.3s ease;
}

.action-card span {
    color: #333;
    font-weight: 500;
}

@media (max-width: 768px) {
    .stats-icon {
        width: 50px;
        height: 50px;
    }
    
    .stats-icon i {
        font-size: 20px !important;
    }
    
    .stats-card h3 {
        font-size: 18px;
    }
    
    .stats-card p {
        font-size: 12px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Avatar upload
    $('#avatarInput').on('change', function() {
        let formData = new FormData();
        formData.append('avatar', this.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: '{{ route("account.profile.avatar") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('.avatar-wrapper img').attr('src', response.avatar_url + '?t=' + new Date().getTime());
                    showNotification(response.message, 'success');
                }
            },
            error: function(xhr) {
                let message = 'Error uploading avatar';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showNotification(message, 'error');
            }
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            alert(message);
        }
    }
});
</script>
@endpush