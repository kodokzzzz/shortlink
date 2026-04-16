@extends('layouts.guest')

@section('title', 'Login')

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
            <p class="text-muted">Welcome back! Sign in to your account.</p>
        </div>

        <div class="auth-card">
            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
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

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label fw-600">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                               id="password" name="password" required placeholder="••••••••">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-600">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                </button>
            </form>

            <div class="text-center mt-4">
                <span class="text-muted small">Don't have an account?</span>
                <a href="{{ route('register') }}" class="small fw-600 text-decoration-none ms-1">Create one</a>
            </div>
        </div>
    </div>
</div>
@endsection
