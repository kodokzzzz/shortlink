@extends('layouts.app')

@section('title', 'Edit Link')
@section('header', 'Edit Link')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('links.show', $link) }}" class="text-decoration-none">{{ $link->slug }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>

        <div class="card card-glass animate-fade-in-up">
            <div class="card-body p-4">
                <h4 class="fw-700 mb-4">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Link
                </h4>

                <form method="POST" action="{{ route('links.update', $link) }}">
                    @csrf
                    @method('PUT')

                    <!-- Destination URL -->
                    <div class="mb-4">
                        <label for="original_url" class="form-label fw-600">
                            Destination URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-globe"></i></span>
                            <input type="url" class="form-control @error('original_url') is-invalid @enderror"
                                   id="original_url" name="original_url"
                                   value="{{ old('original_url', $link->original_url) }}" required>
                        </div>
                        @error('original_url')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-600">
                            Title <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $link->title) }}"
                               placeholder="e.g., Spring Campaign 2026" maxlength="150">
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Custom Slug -->
                    <div class="mb-4">
                        <label for="slugInput" class="form-label fw-600">
                            Slug
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">{{ url('/') }}/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slugInput" name="slug" value="{{ old('slug', $link->slug) }}"
                                   maxlength="100">
                        </div>
                        <div id="slugFeedback" class="mt-1"></div>
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                            Changing the slug will update the shortlink URL and QR code.
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('links.show', $link) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Update Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
