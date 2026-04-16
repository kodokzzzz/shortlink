@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 animate-fade-in-up animate-delay-1" style="opacity:0;">
        <div class="card card-glass stat-card stat-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-link-45deg"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $stats['total_links'] }}">0</div>
                    <div class="stat-label">Total Links</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-fade-in-up animate-delay-2" style="opacity:0;">
        <div class="card card-glass stat-card stat-success">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $stats['active_links'] }}">0</div>
                    <div class="stat-label">Active</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-fade-in-up animate-delay-3" style="opacity:0;">
        <div class="card card-glass stat-card stat-info">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-cursor"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $stats['total_clicks'] }}">0</div>
                    <div class="stat-label">Total Clicks</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 animate-fade-in-up animate-delay-4" style="opacity:0;">
        <div class="card card-glass stat-card stat-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $stats['inactive_links'] }}">0</div>
                    <div class="stat-label">Inactive</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="card card-glass mb-4 animate-fade-in-up">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-5">
                <form method="GET" action="{{ route('links.index') }}" class="input-icon-wrapper">
                    <i class="bi bi-search input-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Search links..."
                           value="{{ request('search') }}">
                </form>
            </div>
            <div class="col-6 col-md-3">
                <form method="GET" action="{{ route('links.index') }}" id="filterForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </form>
            </div>
            <div class="col-6 col-md-4 text-end">
                <a href="{{ route('links.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Create Link
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Links List -->
@if ($links->count() > 0)
    <div class="animate-fade-in-up">
        @foreach ($links as $link)
            <div class="link-item d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <a href="{{ route('links.show', $link) }}" class="link-slug">
                            {{ $link->slug }}
                        </a>
                        <span class="badge {{ $link->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($link->status) }}
                        </span>
                    </div>
                    @if ($link->title)
                        <div class="fw-500 small mb-1">{{ $link->title }}</div>
                    @endif
                    <div class="link-url" title="{{ $link->original_url }}">
                        <i class="bi bi-box-arrow-up-right me-1"></i>{{ $link->original_url }}
                    </div>
                    <div class="link-meta mt-1">
                        <span><i class="bi bi-cursor me-1"></i>{{ number_format($link->total_clicks) }} clicks</span>
                        <span class="mx-2">·</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $link->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <button class="btn btn-copy btn-sm" data-copy="{{ $link->short_url }}" title="Copy shortlink">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                    <a href="{{ route('links.show', $link) }}" class="btn btn-sm btn-outline-primary" title="View details">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('links.edit', $link) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('links.toggle', $link) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $link->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                title="{{ $link->is_active ? 'Deactivate' : 'Activate' }}">
                            <i class="bi {{ $link->is_active ? 'bi-pause-fill' : 'bi-play-fill' }}"></i>
                        </button>
                    </form>
                    <form action="{{ route('links.destroy', $link) }}" method="POST" class="d-inline" data-confirm-delete>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $links->links() }}
        </div>
    </div>
@else
    <div class="card card-glass">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-link-45deg"></i>
            </div>
            <h5>No links yet</h5>
            <p class="mb-3">Create your first shortlink to get started!</p>
            <a href="{{ route('links.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Create Your First Link
            </a>
        </div>
    </div>
@endif
@endsection
