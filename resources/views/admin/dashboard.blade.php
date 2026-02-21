{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10">
                <i class="fas fa-shopping-cart text-primary"></i>
            </div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 12% from last month
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10">
                <i class="fas fa-rupee-sign text-success"></i>
            </div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₹{{ number_format($stats['total_revenue']) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 8% from last month
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-info bg-opacity-10">
                <i class="fas fa-users text-info"></i>
            </div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 15% from last month
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10">
                <i class="fas fa-folder text-warning"></i>
            </div>
            <div class="stat-label">Categories</div>
            <div class="stat-value">{{ number_format($stats['total_categories']) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 3 new this week
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Revenue Overview</h5>
                <select class="form-select form-select-sm w-auto" id="revenuePeriod">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                    <option value="365">This Year</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart" height="300"></canvas>
                
                <div class="mt-3">
                    @foreach($orderStatus as $status)
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <span class="badge bg-{{ $status->order_status == 'delivered' ? 'success' : ($status->order_status == 'cancelled' ? 'danger' : 'warning') }}" style="width: 10px; height: 10px;"></span>
                            {{ ucfirst($status->order_status) }}
                        </span>
                        <span class="fw-bold">{{ $status->total }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Orders</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
            View All <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <span class="fw-bold">#{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $order->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($order->user->name) }}" 
                                     alt="{{ $order->user->name }}" 
                                     class="rounded-circle me-2" 
                                     style="width: 32px; height: 32px; object-fit: cover;">
                                <div>
                                    <div class="fw-500">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->items->count() }} items</td>
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
                            <span class="text-muted small">
                                <i class="far fa-calendar me-1"></i>
                                {{ $order->created_at->format('d M, Y') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">No orders found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue (₹)',
                data: [45000, 52000, 48000, 58000, 62000, 59000, 68000, 72000, 69000, 75000, 82000, 89000],
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const statusData = @json($orderStatus);
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => ucfirst(item.order_status)),
            datasets: [{
                data: statusData.map(item => item.total),
                backgroundColor: [
                    '#f59e0b', // pending
                    '#3b82f6', // confirmed
                    '#8b5cf6', // processing
                    '#64748b', // shipped
                    '#1e293b', // out_for_delivery
                    '#10b981', // delivered
                    '#ef4444', // cancelled
                    '#ef4444'  // returned
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
    
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).replace(/_/g, ' ');
    }
    
    // Period change
    $('#revenuePeriod').on('change', function() {
        let period = $(this).val();
        
        $.ajax({
            url: '{{ route("admin.dashboard.stats") }}',
            data: { period: period },
            success: function(response) {
                if (response.success) {
                    // Update chart data
                    revenueChart.data.labels = response.data.labels;
                    revenueChart.data.datasets[0].data = response.data.revenue;
                    revenueChart.update();
                }
            }
        });
    });
});
</script>
@endpush