@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-wrapper" style="background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);">
    <div class="animate-fade-in-up">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <h3 class="fw-800 mb-1">
                    <i class="bi bi-link-45deg text-gradient"></i>
                    <span class="text-gradient">Shortlink</span>
                </h3>
            </a>
            <p class="text-muted">Enter your email and we'll send you a reset link.</p>
        </div>

        <div class="auth-card">
            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-600">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-600">
                    <i class="bi bi-envelope-arrow-up me-1"></i> Send Reset Link
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Back to login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
