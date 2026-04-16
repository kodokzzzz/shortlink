@extends('layouts.guest')

@section('title', 'Reset Password')

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
            <p class="text-muted">Set your new password below.</p>
        </div>

        <div class="auth-card">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label fw-600">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-600">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-600">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-600">
                    <i class="bi bi-key me-1"></i> Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
