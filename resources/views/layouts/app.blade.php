<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Create short, memorable links with analytics and QR codes. Track clicks and manage your links easily.">

    <title>{{ config('app.name', 'Shortlink') }} — @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>
                <i class="bi bi-link-45deg text-gradient"></i>
                <span class="text-gradient">Shortlink</span>
            </h4>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('links.index') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
            <a href="{{ route('links.create') }}" class="nav-link {{ request()->routeIs('links.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i>
                Create Link
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i>
                Profile
            </a>

            <hr class="mx-3 my-2 opacity-25">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <nav class="navbar navbar-expand-lg border-bottom bg-body px-3 px-lg-4 sticky-top">
            <div class="container-fluid">
                <!-- Mobile toggle -->
                <button class="btn btn-sm d-lg-none me-2" id="sidebarToggle" type="button">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <span class="navbar-text fw-600 d-none d-lg-block">
                    @yield('header', 'Dashboard')
                </span>

                <div class="d-flex align-items-center gap-2 ms-auto">
                    <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:0.8rem;font-weight:700;">
                                {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->name ?? Auth::user()->email }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-left me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="p-3 p-lg-4">
            @yield('content')
        </main>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="toast align-items-center text-bg-danger border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    @yield('scripts')
</body>
</html>
