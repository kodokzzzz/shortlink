@extends('layouts.guest')

@section('title', 'Shorten Your Links')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-body bg-opacity-75" style="backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05);">
    <div class="container">
        <a class="navbar-brand fw-800" href="{{ route('home') }}">
            <i class="bi bi-link-45deg text-gradient"></i>
            <span class="text-gradient">Shortlink</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                <i class="bi bi-moon-fill"></i>
            </button>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Get Started</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-gradient-hero text-white" style="padding: 8rem 0 5rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="animate-fade-in-up">
                    <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 px-3 py-2 mb-3" style="font-size: 0.8rem;">
                        ✨ Free URL Shortener with Analytics
                    </span>
                    <h1 class="display-4 fw-900 mb-3 lh-sm">
                        Shorten, Share &<br>
                        <span style="background: linear-gradient(135deg, #22d3ee, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Track Your Links</span>
                    </h1>
                    <p class="lead mb-4 text-white text-opacity-75" style="font-size: 1.15rem; max-width: 520px;">
                        Transform long, messy URLs into clean, trackable shortlinks. Get analytics, QR codes, and full control over your links.
                    </p>
                    @guest
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 fw-700">
                                <i class="bi bi-rocket-takeoff me-2"></i>Get Started — It's Free
                            </a>
                            <a href="#features" class="btn btn-outline-light btn-lg px-4">
                                Learn More <i class="bi bi-arrow-down ms-1"></i>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('links.create') }}" class="btn btn-light btn-lg px-4 fw-700">
                            <i class="bi bi-plus-circle me-2"></i>Create Shortlink
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-5">
                <div class="animate-fade-in-up animate-delay-2" style="opacity: 0;">
                    <!-- Hero illustration card -->
                    <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15) !important; border-radius: 1.25rem;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="rounded-circle" style="width:12px;height:12px;background:#ef4444;"></div>
                                <div class="rounded-circle" style="width:12px;height:12px;background:#f59e0b;"></div>
                                <div class="rounded-circle" style="width:12px;height:12px;background:#10b981;"></div>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-3">
                                <small class="text-white text-opacity-50 d-block mb-1">Long URL</small>
                                <div class="text-white text-opacity-75 small" style="word-break: break-all;">
                                    https://www.example.com/products/category/electronics/smartphones/samsung-galaxy-s25-ultra?ref=campaign_may&utm_source=social
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <i class="bi bi-arrow-down-circle text-white text-opacity-50 fs-4"></i>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-3 p-3">
                                <small class="text-white text-opacity-50 d-block mb-1">Short URL</small>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-white fw-700">shortlink.app/promo-mei</span>
                                    <span class="badge bg-success bg-opacity-25 text-success-emphasis">
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 text-white text-opacity-50 small">
                                <span><i class="bi bi-bar-chart me-1"></i> 1,247 clicks</span>
                                <span><i class="bi bi-qr-code me-1"></i> QR Ready</span>
                                <span><i class="bi bi-clock me-1"></i> 2 min ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 mb-2">Everything You Need</h2>
            <p class="text-muted" style="max-width: 500px; margin: 0 auto;">Powerful features to help you manage, track, and share your links effectively.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-1" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <h5>Custom Shortlinks</h5>
                    <p>Create branded, memorable links with custom slugs that match your campaign or brand.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-2" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h5>Click Analytics</h5>
                    <p>Track clicks, browsers, devices, and referrers with detailed analytics dashboard.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-3" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    <h5>QR Code Generator</h5>
                    <p>Auto-generate QR codes for every link. Download and use for print or digital media.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-4" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h5>Instant Redirect</h5>
                    <p>Lightning-fast redirects with async analytics logging. No delay for your users.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-5" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>Link Management</h5>
                    <p>Edit, activate, deactivate, or delete links anytime. Full control over your URLs.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 animate-fade-in-up animate-delay-6" style="opacity:0;">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(99,102,241,0.1); color: #6366f1;">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h5>Mobile Friendly</h5>
                    <p>Fully responsive dashboard that works beautifully on any device.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-body-secondary">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 mb-2">How It Works</h2>
            <p class="text-muted">Three simple steps to get started.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="step-number bg-primary text-white">1</div>
                    <div>
                        <h5 class="fw-700 mb-1">Paste Your URL</h5>
                        <p class="text-muted small mb-0">Enter the long URL you want to shorten. Add a custom slug if you'd like.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="step-number bg-success text-white">2</div>
                    <div>
                        <h5 class="fw-700 mb-1">Get Your Shortlink</h5>
                        <p class="text-muted small mb-0">Instantly get a short URL and QR code. Copy and share anywhere.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="step-number" style="background: #6366f1; color: white;">3</div>
                    <div>
                        <h5 class="fw-700 mb-1">Track Performance</h5>
                        <p class="text-muted small mb-0">Monitor clicks, analyze traffic, and optimize your campaigns.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-gradient-primary text-white text-center" style="padding: 5rem 0 !important;">
    <div class="container">
        <h2 class="fw-800 mb-2">Ready to Shorten Your Links?</h2>
        <p class="mb-4 text-white text-opacity-75" style="max-width: 500px; margin: 0 auto;">Join thousands of users who trust Shortlink for their URL management needs.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-700">
                <i class="bi bi-rocket-takeoff me-2"></i>Create Free Account
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-700">
                <i class="bi bi-grid-1x2-fill me-2"></i>Go to Dashboard
            </a>
        @endguest
    </div>
</section>

<!-- Footer -->
<footer class="py-4 bg-body-tertiary border-top">
    <div class="container text-center">
        <p class="mb-0 text-muted small">
            &copy; {{ date('Y') }} Shortlink. Built with <i class="bi bi-heart-fill text-danger"></i> using Laravel & Bootstrap.
        </p>
    </div>
</footer>
@endsection
