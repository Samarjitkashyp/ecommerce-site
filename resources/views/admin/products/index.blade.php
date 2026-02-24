{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Products Management')
@section('page-title', 'Products Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2 text-primary"></i>
                    All Products
                </h5>
                <div>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select" id="categoryFilter">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search products...">
                    </div>
                </div>

                @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="productsTable">
                        <thead>
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input select-item" type="checkbox" value="{{ $product->id }}">
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://via.placeholder.com/50' }}" 
                                         alt="{{ $product->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->badge)
                                        <span class="badge bg-{{ $product->badge == 'NEW' ? 'success' : ($product->badge == 'TRENDING' ? 'warning' : 'danger') }} ms-2">
                                            {{ $product->badge }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>
                                    ₹{{ number_format($product->price) }}
                                    @if($product->original_price)
                                        <br><small class="text-muted text-decoration-line-through">₹{{ number_format($product->original_price) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($product->in_stock)
                                        <span class="badge bg-success">In Stock</span>
                                        <br><small>{{ $product->stock_quantity }} units</small>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $product->id }}"
                                               data-url="{{ route('admin.products.toggle-status', $product->id) }}"
                                               {{ $product->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-url="{{ route('admin.products.destroy', $product->id) }}"
                                            data-name="{{ $product->name }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-box fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No products found!</h5>
                    <p class="text-muted">Create your first product.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select all
    $('#selectAll').on('change', function() {
        $('.select-item').prop('checked', $(this).is(':checked'));
    });

    // Status toggle
    $(document).on('change', '.status-toggle', function() {
        let checkbox = $(this);
        let url = checkbox.data('url');
        let isChecked = checkbox.is(':checked');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                checkbox.prop('checked', !isChecked);
                toastr.error('Error updating status');
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function() {
        let btn = $(this);
        let url = btn.data('url');
        let name = btn.data('name');
        
        if (confirm('Delete product "' + name + '"?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error('Error deleting product');
                }
            });
        }
    });

    // Filters
    $('#categoryFilter, #statusFilter, #searchInput').on('change keyup', function() {
        // In real app, you would reload the page with filters
        // For now, just show message
        toastr.info('Filters applied (demo)');
    });
});
</script>
@endpush