{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.auth')

@section('title', 'Register - Create Account')
@section('auth-title', 'Create Account')
@section('auth-subtitle', 'Join us and start shopping')

@section('content')
<form id="registerForm" method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" 
               placeholder="Enter your full name" required>
        @error('name')
            <div class="error-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="Enter email" required>
            @error('email')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Mobile Number</label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone') }}" 
                   placeholder="10-digit mobile" maxlength="10" required>
            @error('phone')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" 
                   placeholder="Min. 8 characters" required>
            @error('password')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" 
                   id="password_confirmation" name="password_confirmation" 
                   placeholder="Re-enter password" required>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="gender" class="form-label">Gender (Optional)</label>
            <select class="form-control" id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="dob" class="form-label">Date of Birth (Optional)</label>
            <input type="date" class="form-control" id="dob" name="dob" 
                   value="{{ old('dob') }}" max="{{ date('Y-m-d') }}">
        </div>
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
        <label class="form-check-label" for="terms">
            I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
        </label>
    </div>
    
    <button type="submit" class="btn btn-auth w-100" id="registerBtn">
        <i class="fas fa-user-plus me-2"></i> Register
    </button>
    
    <div class="divider">
        <span>OR</span>
    </div>
    
    <div class="auth-footer">
        <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
    </div>
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Phone number validation
    $('#phone').on('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
    
    // Form submission
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let btn = $('#registerBtn');
        
        // Validate terms
        if (!$('#terms').is(':checked')) {
            showNotification('Please accept Terms & Conditions', 'warning');
            return;
        }
        
        // Disable button
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Registering...');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                btn.html('<i class="fas fa-user-plus me-2"></i> Register');
                btn.prop('disabled', false);
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    
                    $.each(errors, function(key, value) {
                        errorMessages.push(value[0]);
                    });
                    
                    showNotification(errorMessages.join('<br>'), 'error');
                } else {
                    showNotification(xhr.responseJSON.message || 'Registration failed', 'error');
                }
            }
        });
    });
});
</script>
@endpush