@extends('layouts.app')

@section('title', 'Pengaturan User')
@section('header', 'Manajemen Pengguna')

@section('content')
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-4 animate-fade-in-up animate-delay-1">
        <div class="card card-glass stat-card stat-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 animate-fade-in-up animate-delay-2">
        <div class="card card-glass stat-card stat-success">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($stats['admin_users']) }}</div>
                    <div class="stat-label">Administrator</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 animate-fade-in-up animate-delay-3">
        <div class="card card-glass stat-card stat-info">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($stats['regular_users']) }}</div>
                    <div class="stat-label">Pengguna Biasa</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="card card-glass mb-4 animate-fade-in-up">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="input-icon-wrapper">
                    <i class="bi bi-search input-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau email pengguna..."
                           value="{{ request('search') }}">
                </form>
            </div>
            <div class="col-12 col-md-4">
                <form method="GET" action="{{ route('admin.users.index') }}" id="filterRoleForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="role" class="form-select" onchange="document.getElementById('filterRoleForm').submit()">
                        <option value="">Semua Tingkatan Role</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </form>
            </div>
            <div class="col-12 col-md-2 text-end">
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Users List -->
@if ($users->count() > 0)
    <div class="animate-fade-in-up">
        @foreach ($users as $u)
            <div class="link-item d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.2rem; font-weight: 700;">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>

                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="fw-bold fs-6">{{ $u->name }}</span>
                        <span class="badge {{ $u->role === 'admin' ? 'badge-active' : 'badge-inactive' }}">
                            {{ strtoupper($u->role) }}
                        </span>
                    </div>
                    <div class="link-url text-muted" style="font-size: 0.875rem;">
                        <i class="bi bi-envelope me-1"></i>{{ $u->email }}
                    </div>
                    <div class="link-meta mt-1">
                        <span><i class="bi bi-link-45deg me-1"></i>{{ number_format($u->links_count) }} shortlink dibuat</span>
                        <span class="mx-2">·</span>
                        <span><i class="bi bi-calendar3 me-1"></i>Bergabung {{ $u->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">
                        <i class="bi bi-key me-1"></i> Edit & Reset Password
                    </button>

                    @if ($u->id !== Auth::id())
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini beserta seluruh linknya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pengguna">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Modal Edit & Reset Password -->
            <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card-glass border-0">
                        <form action="{{ route('admin.users.update', $u) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-person-gear me-2"></i>Edit Pengguna: {{ $u->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tingkatan Role</label>
                                    <select name="role" class="form-select" required>
                                        <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User Biasa</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-danger">Reset Password Baru</label>
                                    <input type="text" name="password" class="form-control border-danger" placeholder="Masukkan password baru...">
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin merubah/mereset password pengguna ini.
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer border-top">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
@else
    <div class="card card-glass">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-people"></i>
            </div>
            <h5>Pengguna Tidak Ditemukan</h5>
            <p class="mb-0">Tidak ada pengguna yang sesuai dengan pencarian atau filter Anda.</p>
        </div>
    </div>
@endif
@endsection
