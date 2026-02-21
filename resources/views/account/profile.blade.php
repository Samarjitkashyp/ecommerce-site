@extends('layouts.master')

@section('title', 'My Profile')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section py-2 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}" class="text-decoration-none">My Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Profile Section -->
<section class="profile-section py-4">
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
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i> My Orders
                        </a>
                        <a href="{{ route('account.wishlist') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-heart me-2"></i> Wishlist
                        </a>
                        <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-map-marker-alt me-2"></i> Addresses
                        </a>
                        <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action active">
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
            
            <!-- Profile Content -->
            <div class="col-lg-9">
                <div class="profile-card card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-edit text-primary me-2"></i>
                            Edit Profile
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" method="POST" action="{{ route('account.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                           maxlength="10" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ (old('gender', auth()->user()->gender) == 'male') ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ (old('gender', auth()->user()->gender) == 'female') ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ (old('gender', auth()->user()->gender) == 'other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                           id="dob" name="dob" value="{{ old('dob', auth()->user()->dob ? auth()->user()->dob->format('Y-m-d') : '') }}"
                                           max="{{ date('Y-m-d') }}">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Change Password Section -->
                <div class="password-card card mt-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-lock text-primary me-2"></i>
                            Change Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="passwordForm" method="POST" action="{{ route('account.password.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" name="new_password" required>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                           id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="updatePasswordBtn">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                            </div>
                        </form>
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
}

.account-sidebar .list-group-item:hover {
    background-color: #fff9f0;
    color: #febd69;
    padding-left: 25px;
}

.account-sidebar .list-group-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.profile-card, .password-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.profile-card .card-header, .password-card .card-header {
    border-bottom: 1px solid #f0f0f0;
    padding: 15px 20px;
}

.form-control {
    border-radius: 8px;
    padding: 10px 15px;
    border: 2px solid #e1e1e1;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #febd69;
    box-shadow: none;
}

@media (max-width: 768px) {
    .profile-card .row > [class*="col-"] {
        margin-bottom: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Global notification function define karo
function showNotification(message, type = 'info') {
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(message);
    }
}

$(document).ready(function() {
    console.log('Profile page loaded');
    
    // Profile form submission - FIXED VERSION
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let btn = $('#updateProfileBtn');
        let originalText = btn.html();
        
        console.log('Submitting profile form...');
        console.log('Form data:', form.serialize());
        
        // Disable button
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Updating...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',  // PUT method ko POST se bhejna hai with _method field
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Profile update success:', response);
                
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    // Update UI with new values if needed
                    // Kuch update karna ho to yahan karo
                }
                
                // Button restore
                btn.html(originalText);
                btn.prop('disabled', false);
            },
            error: function(xhr) {
                console.error('Profile update error:', xhr);
                
                btn.html(originalText);
                btn.prop('disabled', false);
                
                let errorMessage = 'Update failed. Please try again.';
                
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    
                    $.each(errors, function(key, value) {
                        errorMessages.push(value[0]);
                        // Highlight the field with error
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });
                    
                    errorMessage = errorMessages.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // Password form submission
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let btn = $('#updatePasswordBtn');
        let originalText = btn.html();
        
        console.log('Submitting password form...');
        
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Changing...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',  // PUT method ko POST se bhejna hai
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Password change success:', response);
                
                if (response.success) {
                    showNotification(response.message, 'success');
                    form[0].reset(); // Clear form
                }
                
                btn.html(originalText);
                btn.prop('disabled', false);
            },
            error: function(xhr) {
                console.error('Password change error:', xhr);
                
                btn.html(originalText);
                btn.prop('disabled', false);
                
                let errorMessage = 'Password change failed.';
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    
                    $.each(errors, function(key, value) {
                        errorMessages.push(value[0]);
                        $('#' + key).addClass('is-invalid');
                    });
                    
                    errorMessage = errorMessages.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // Remove validation errors on input change
    $('#name, #email, #phone, #gender, #dob, #current_password, #new_password').on('input change', function() {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
    
    // Phone number validation
    $('#phone').on('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
    
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
});
</script>
@endpush