{{-- resources/views/admin/search/results.blade.php --}}
@extends('layouts.admin')

@section('title', 'Search Results: ' . $query)
@section('page-title', 'Search Results for "' . $query . '"')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Search Results</h5>
            </div>
            <div class="card-body">
                <!-- Users Section -->
                @if($results['users']->count() > 0)
                <h6 class="mb-3">Users ({{ $results['users']->count() }})</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['users'] as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                
                <!-- Orders Section -->
                @if($results['orders']->count() > 0)
                <h6 class="mb-3">Orders ({{ $results['orders']->count() }})</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['orders'] as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                
                @if($results['users']->count() == 0 && $results['orders']->count() == 0 && (!isset($results['products']) || $results['products']->count() == 0) && $results['categories']->count() == 0)
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h5>No results found for "{{ $query }}"</h5>
                    <p class="text-muted">Try different keywords</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection