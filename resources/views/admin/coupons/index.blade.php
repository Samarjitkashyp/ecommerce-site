{{-- resources/views/admin/coupons/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Coupon Management')
@section('page-title', 'Coupon Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2 text-primary"></i>
                    All Coupons
                </h5>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Coupon
                </a>
            </div>
            <div class="card-body">
                @if($coupons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Order</th>
                                <th>Usage</th>
                                <th>Expiry</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>
                                    <span class="badge bg-primary p-2">{{ $coupon->code }}</span>
                                </td>
                                <td>{{ $coupon->name }}</td>
                                <td>
                                    @if($coupon->type == 'percentage')
                                        <span class="badge bg-info">Percentage</span>
                                    @else
                                        <span class="badge bg-success">Fixed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->type == 'percentage')
                                        {{ $coupon->value }}%
                                    @else
                                        ₹{{ number_format($coupon->value) }}
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->min_order_amount)
                                        ₹{{ number_format($coupon->min_order_amount) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $coupon->total_used ?? 0 }}
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->expires_at)
                                        {{ $coupon->expires_at->format('d M Y') }}
                                        @if($coupon->expires_at->isPast())
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $coupon->id }}"
                                               data-url="{{ route('admin.coupons.toggle-status', $coupon->id) }}"
                                               {{ $coupon->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-url="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                            data-name="{{ $coupon->name }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-tags fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No coupons found!</h5>
                    <p class="text-muted">Create your first coupon.</p>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add New Coupon
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
                    showNotification(response.message, 'success');
                }
            },
            error: function() {
                checkbox.prop('checked', !isChecked);
                showNotification('Error updating status', 'error');
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function() {
        let btn = $(this);
        let url = btn.data('url');
        let name = btn.data('name');
        
        if (confirm('Delete coupon "' + name + '"?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(xhr) {
                    let message = 'Error deleting coupon';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showNotification(message, 'error');
                }
            });
        }
    });
});
</script>
@endpush