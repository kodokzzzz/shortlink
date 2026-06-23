@extends('layouts.guest')

@section('title', 'Link Not Yet Active')

@section('content')
<div class="auth-wrapper bg-body">
    <div class="text-center animate-fade-in-up">
        <div class="mb-4">
            <div class="d-inline-block rounded-circle bg-info bg-opacity-10 p-4 mb-3">
                <i class="bi bi-clock-history text-info" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h1 class="fw-800 display-5 mb-2">Not Yet Active</h1>
        <h4 class="fw-600 mb-3">This link isn't available yet</h4>
        <p class="text-muted mb-4" style="max-width: 420px; margin: 0 auto;">
            This shortlink is scheduled to become active later.
            @if ($link->starts_at)
                <br><span class="small">Available from {{ $link->starts_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
            @endif
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-house me-1"></i> Go Home
        </a>
    </div>
</div>
@endsection
