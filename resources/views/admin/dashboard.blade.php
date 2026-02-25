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
                <i class="fas fa-arrow-up"></i> {{ $stats['order_growth'] ?? 12 }}% from last month
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
                <i class="fas fa-arrow-up"></i> {{ $stats['revenue_growth'] ?? 8 }}% from last month
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
                <i class="fas fa-arrow-up"></i> {{ $stats['user_growth'] ?? 15 }}% from last month
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
                <i class="fas fa-arrow-up"></i> {{ $stats['new_categories'] ?? 3 }} new this week
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
        <div class="card" style="min-height: 400px;">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body d-flex flex-column">
                {{-- Canvas with fixed height --}}
                <div style="height: 200px; position: relative;">
                    <canvas id="orderStatusChart" style="max-height: 200px; width: 100%;"></canvas>
                </div>
                
                {{-- Status List with Fixed Height and Scroll if needed --}}
                <div style="max-height: 150px; overflow-y: auto; margin-top: 15px;" class="pr-2">
                    @if(isset($orderStatus) && !is_null($orderStatus) && $orderStatus->count() > 0)
                        @foreach($orderStatus as $status)
                            @if(isset($status->order_status) && isset($status->total))
                            <div class="d-flex justify-content-between mb-2">
                                <span>
                                    <span class="badge bg-{{ $status->order_status == 'delivered' ? 'success' : ($status->order_status == 'cancelled' ? 'danger' : 'warning') }}" style="width: 10px; height: 10px;"></span>
                                    {{ ucfirst($status->order_status) }}
                                </span>
                                <span class="fw-bold">{{ $status->total }}</span>
                            </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Default data --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge bg-warning" style="width: 10px; height: 10px;"></span> Pending</span>
                            <span class="fw-bold">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge bg-primary" style="width: 10px; height: 10px;"></span> Processing</span>
                            <span class="fw-bold">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge bg-success" style="width: 10px; height: 10px;"></span> Delivered</span>
                            <span class="fw-bold">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge bg-danger" style="width: 10px; height: 10px;"></span> Cancelled</span>
                            <span class="fw-bold">0</span>
                        </div>
                    @endif
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
    // Revenue chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!},
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
    
    // Order Status Chart with fixed height
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    
    // Default data
    let chartLabels = ['Pending', 'Processing', 'Delivered', 'Cancelled'];
    let chartValues = [0, 0, 0, 0];
    let chartColors = ['#f59e0b', '#8b5cf6', '#10b981', '#ef4444'];
    
    // Try to get real data
    try {
        let statusData = @json($orderStatus ?? []);
        
        if (statusData && Array.isArray(statusData) && statusData.length > 0) {
            let tempLabels = [];
            let tempValues = [];
            let tempColors = [];
            
            statusData.forEach(item => {
                if (item && item.order_status) {
                    let label = item.order_status;
                    tempLabels.push(label.charAt(0).toUpperCase() + label.slice(1).replace(/_/g, ' '));
                    tempValues.push(item.total || 0);
                    
                    // Set color
                    switch(item.order_status) {
                        case 'pending': tempColors.push('#f59e0b'); break;
                        case 'confirmed': tempColors.push('#3b82f6'); break;
                        case 'processing': tempColors.push('#8b5cf6'); break;
                        case 'shipped': tempColors.push('#64748b'); break;
                        case 'out_for_delivery': tempColors.push('#1e293b'); break;
                        case 'delivered': tempColors.push('#10b981'); break;
                        case 'cancelled': tempColors.push('#ef4444'); break;
                        case 'returned': tempColors.push('#ef4444'); break;
                        default: tempColors.push('#64748b');
                    }
                }
            });
            
            if (tempLabels.length > 0) {
                chartLabels = tempLabels;
                chartValues = tempValues;
                chartColors = tempColors;
            }
        }
    } catch(e) {
        console.log('Using default chart data');
    }
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartValues,
                backgroundColor: chartColors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
    
    // Period change - load dynamic data
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
            },
            error: function() {
                if (typeof showNotification !== 'undefined') {
                    showNotification('Could not load revenue data', 'error');
                } else {
                    console.log('Could not load revenue data');
                }
            }
        });
    });
});
</script>
@endpush