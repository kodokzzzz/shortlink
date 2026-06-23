@extends('layouts.guest')

@section('title', 'Protected Link')

@section('content')
<div class="auth-wrapper bg-body">
    <div class="card card-glass animate-fade-in-up" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4 p-md-5 text-center">
            <div class="mb-4">
                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-4">
                    <i class="bi bi-shield-lock text-primary" style="font-size: 2.5rem;"></i>
                </div>
            </div>

            <h1 class="fw-800 h3 mb-2">Protected Link</h1>
            <p class="text-muted mb-4">
                This link is password protected. Please enter the password to continue.
            </p>

            <form method="POST" action="{{ route('redirect.unlock', $link->slug) }}">
                @csrf

                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-600">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               placeholder="Enter password" required autofocus autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-unlock me-1"></i> Unlock & Continue
                </button>
            </form>

            <div class="mt-4 small text-muted">
                <i class="bi bi-link-45deg"></i> {{ config('app.name', 'Shortlink') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endsection
