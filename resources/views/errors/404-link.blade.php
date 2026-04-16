@extends('layouts.guest')

@section('title', 'Link Not Found')

@section('content')
<div class="auth-wrapper bg-body">
    <div class="text-center animate-fade-in-up">
        <div class="mb-4">
            <div class="d-inline-block rounded-circle bg-danger bg-opacity-10 p-4 mb-3">
                <i class="bi bi-link-45deg text-danger" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h1 class="fw-800 display-5 mb-2">404</h1>
        <h4 class="fw-600 mb-3">Link Not Found</h4>
        <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
            The shortlink <strong class="text-body">/{{ $slug ?? 'unknown' }}</strong> doesn't exist or has been removed.
        </p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house me-1"></i> Go Home
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
