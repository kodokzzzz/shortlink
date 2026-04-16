@extends('layouts.guest')

@section('title', 'Register')

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
            <p class="text-muted">Create your free account to get started.</p>
        </div>

        <div class="auth-card">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="John Doe">
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-600">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-600">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                               id="password" name="password" required placeholder="Min. 8 characters">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-600">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control border-start-0"
                               id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-600">
                    <i class="bi bi-person-plus me-1"></i> Create Account
                </button>
            </form>

            <div class="text-center mt-4">
                <span class="text-muted small">Already have an account?</span>
                <a href="{{ route('login') }}" class="small fw-600 text-decoration-none ms-1">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection
