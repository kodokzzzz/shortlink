@extends('layouts.guest')

@section('title', 'Link Inactive')

@section('content')
<div class="auth-wrapper bg-body">
    <div class="text-center animate-fade-in-up">
        <div class="mb-4">
            <div class="d-inline-block rounded-circle bg-warning bg-opacity-10 p-4 mb-3">
                <i class="bi bi-pause-circle text-warning" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h1 class="fw-800 display-5 mb-2">Link Inactive</h1>
        <h4 class="fw-600 mb-3">This link has been deactivated</h4>
        <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
            The owner has temporarily disabled this shortlink. Please contact them for more information.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-house me-1"></i> Go Home
        </a>
    </div>
</div>
@endsection
