{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.auth')

@section('title', 'Login - Sign In')
@section('auth-title', 'Welcome Back')
@section('auth-subtitle', 'Sign in to continue shopping')

@section('content')
<form id="loginForm" method="POST" action="{{ route('login') }}">
    @csrf
    
    @if(request()->has('redirect'))
    <input type="hidden" name="redirect" value="{{ request()->redirect }}">
    @endif
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="user@example.com" 
               placeholder="Enter your email" required>
        @error('email')
            <div class="error-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="position-relative">
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" value="password" 
                   placeholder="Enter your password" required>
            <i class="fas fa-eye password-toggle" 
               style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>
        @error('password')
            <div class="error-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
    </div>
    
    <button type="submit" class="btn btn-auth w-100" id="loginBtn">
        <i class="fas fa-sign-in-alt me-2"></i> Sign In
    </button>
    
    <div class="divider">
        <span>OR</span>
    </div>
    
    <div class="auth-footer">
        <p>New to our store? <a href="{{ route('register') }}">Create Account</a></p>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Global notification function define karo
function showNotification(message, type = 'info') {
    // Toastr check karo
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        // Alert as backup
        alert(message);
    }
}

$(document).ready(function() {
    // Password toggle
    $('.password-toggle').on('click', function() {
        let input = $('#password');
        let type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    
    // Form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let btn = $('#loginBtn');
        let originalText = btn.html();
        
        // Disable button
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Signing in...');
        btn.prop('disabled', true);
        
        // Debug: console mein data check karo
        console.log('Submitting login form with:', {
            email: $('#email').val(),
            password: $('#password').val(),
            remember: $('#remember').is(':checked')
        });
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Login success:', response);
                
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                console.error('Login error:', error);
                console.error('Response:', xhr.responseText);
                
                btn.html(originalText);
                btn.prop('disabled', false);
                
                let errorMessage = 'Login failed. Please try again.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // WebSocket error ko ignore karo (agar refresh package installed hai)
    if (typeof window.WebSocket !== 'undefined') {
        const originalWebSocket = window.WebSocket;
        window.WebSocket = function(url, ...args) {
            if (url.includes('localhost:8081')) {
                console.log('WebSocket connection ignored');
                return {
                    send: function() {},
                    close: function() {}
                };
            }
            return new originalWebSocket(url, ...args);
        };
    }
});
</script>
@endpush