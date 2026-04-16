@extends('layouts.app')

@section('title', 'Profile')
@section('header', 'Profile Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Update Profile -->
        <div class="card card-glass mb-4 animate-fade-in-up">
            <div class="card-body p-4">
                <h5 class="fw-700 mb-1"><i class="bi bi-person text-primary me-2"></i>Profile Information</h5>
                <p class="text-muted small mb-4">Update your account's profile information and email address.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-600">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-600">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Save Changes
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success small ms-2"><i class="bi bi-check2"></i> Saved.</span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card card-glass mb-4 animate-fade-in-up">
            <div class="card-body p-4">
                <h5 class="fw-700 mb-1"><i class="bi bi-lock text-primary me-2"></i>Update Password</h5>
                <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-600">Current Password</label>
                        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                               id="current_password" name="current_password">
                        @error('current_password', 'updatePassword')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-600">New Password</label>
                        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                               id="password" name="password">
                        @error('password', 'updatePassword')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-600">Confirm Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-key me-1"></i> Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success small ms-2"><i class="bi bi-check2"></i> Saved.</span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card card-glass border-danger border-opacity-25 animate-fade-in-up">
            <div class="card-body p-4">
                <h5 class="fw-700 mb-1 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Delete Account</h5>
                <p class="text-muted small mb-3">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-1"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title fw-700 text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone. Please enter your password to confirm.</p>
                    <div>
                        <label for="delete_password" class="form-label fw-600">Password</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required placeholder="Enter your password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
