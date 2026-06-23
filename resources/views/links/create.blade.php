@extends('layouts.app')

@section('title', 'Create Link')
@section('header', 'Create New Link')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Link</li>
            </ol>
        </nav>

        <div class="card card-glass animate-fade-in-up">
            <div class="card-body p-4">
                <h4 class="fw-700 mb-4">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Create New Shortlink
                </h4>

                <form method="POST" action="{{ route('links.store') }}">
                    @csrf

                    <!-- Destination URL -->
                    <div class="mb-4">
                        <label for="original_url" class="form-label fw-600">
                            Destination URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-globe"></i></span>
                            <input type="url" class="form-control @error('original_url') is-invalid @enderror"
                                   id="original_url" name="original_url" value="{{ old('original_url') }}"
                                   placeholder="https://example.com/your-long-url-here" required autofocus>
                        </div>
                        @error('original_url')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter the long URL you want to shorten.</div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-600">
                            Title <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}"
                               placeholder="e.g., Spring Campaign 2026" maxlength="150">
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">A friendly name to help you identify this link.</div>
                    </div>

                    <!-- Custom Slug -->
                    <div class="mb-4">
                        <label for="slugInput" class="form-label fw-600">
                            Custom Slug <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">{{ url('/') }}/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slugInput" name="slug" value="{{ old('slug') }}"
                                   placeholder="my-custom-link" maxlength="100">
                        </div>
                        <div id="slugFeedback" class="mt-1"></div>
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to auto-generate. Use letters, numbers, hyphens, and underscores only.</div>
                    </div>

                    <hr class="my-4">

                    <!-- Protection & Scheduling -->
                    <h6 class="fw-700 text-uppercase text-muted small mb-3">
                        <i class="bi bi-shield-lock me-1"></i> Protection &amp; Scheduling
                    </h6>

                    <!-- Password protection -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-600">
                            Password protection <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" value="{{ old('password') }}"
                                   placeholder="Set a password to protect this link" maxlength="255" autocomplete="off">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Visitors must enter this password before being redirected.</div>
                    </div>

                    <!-- Active window -->
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="starts_at" class="form-label fw-600">
                                Active from <span class="text-muted fw-normal">(optional)</span>
                            </label>
                            <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror"
                                   id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                            @error('starts_at')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="expires_at" class="form-label fw-600">
                                Active until <span class="text-muted fw-normal">(optional)</span>
                            </label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                   id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                            @error('expires_at')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-text mb-4">
                        <i class="bi bi-clock me-1"></i>
                        Times are in <strong>WIB (UTC+7)</strong>. Leave blank for no time limit.
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-link-45deg me-1"></i> Create Shortlink
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
