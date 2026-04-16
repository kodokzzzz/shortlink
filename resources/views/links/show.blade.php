@extends('layouts.app')

@section('title', $link->title ?? $link->slug)
@section('header', 'Link Detail')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $link->slug }}</li>
    </ol>
</nav>

<!-- Link Info Card -->
<div class="card card-glass mb-4 animate-fade-in-up">
    <div class="card-body p-4">
        <div class="row align-items-start">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="fw-800 mb-0">{{ $link->title ?? $link->slug }}</h4>
                    <span class="badge {{ $link->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ ucfirst($link->status) }}
                    </span>
                </div>

                <!-- Short URL -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-body-secondary rounded-3 px-3 py-2 flex-grow-1 d-flex align-items-center">
                        <i class="bi bi-link-45deg text-primary me-2"></i>
                        <a href="{{ $link->short_url }}" target="_blank" class="fw-600 text-decoration-none text-primary">
                            {{ $link->short_url }}
                        </a>
                    </div>
                    <button class="btn btn-primary btn-copy" data-copy="{{ $link->short_url }}">
                        <i class="bi bi-clipboard me-1"></i> Copy
                    </button>
                </div>

                <!-- Original URL -->
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Destination URL</small>
                    <a href="{{ $link->original_url }}" target="_blank" class="text-decoration-none small" style="word-break: break-all;">
                        <i class="bi bi-box-arrow-up-right me-1"></i>{{ $link->original_url }}
                    </a>
                </div>

                <!-- Meta -->
                <div class="d-flex flex-wrap gap-3 text-muted small">
                    <span><i class="bi bi-calendar me-1"></i>Created {{ $link->created_at->format('M d, Y H:i') }}</span>
                    @if ($lastClicked)
                        <span><i class="bi bi-cursor me-1"></i>Last click {{ $lastClicked->diffForHumans() }}</span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('links.edit', $link) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('links.toggle', $link) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $link->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                            <i class="bi {{ $link->is_active ? 'bi-pause-fill' : 'bi-play-fill' }} me-1"></i>
                            {{ $link->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form action="{{ route('links.destroy', $link) }}" method="POST" class="d-inline" data-confirm-delete>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- QR Code -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="qr-container">
                    <div class="mb-2">
                        <img src="{{ route('links.qrcode', $link) }}" alt="QR Code for {{ $link->slug }}"
                             style="max-width: 180px; height: auto;">
                    </div>
                    <a href="{{ route('links.qrcode.download', $link) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Download QR
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Section -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card card-glass stat-card stat-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="bi bi-cursor"></i></div>
                <div>
                    <div class="stat-value" data-count="{{ $link->total_clicks }}">0</div>
                    <div class="stat-label">Total Clicks</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-glass stat-card stat-success">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <div>
                    <div class="stat-value" data-count="{{ array_sum($clicksPerDay) }}">0</div>
                    <div class="stat-label">Last 30 Days</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-glass stat-card stat-info">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="bi bi-clock"></i></div>
                <div>
                    <div class="stat-value small fw-700">{{ $lastClicked ? $lastClicked->diffForHumans(null, true) : 'Never' }}</div>
                    <div class="stat-label">Last Click</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-glass stat-card stat-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                <div>
                    <div class="stat-value" data-count="{{ count($clicksPerDay) > 0 ? round(array_sum($clicksPerDay) / count($clicksPerDay), 1) : 0 }}">0</div>
                    <div class="stat-label">Avg/Day</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clicks Chart -->
<div class="card card-glass mb-4 animate-fade-in-up">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-700 mb-0"><i class="bi bi-bar-chart-line text-primary me-2"></i>Click Trends</h5>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-primary active" data-days="7">7D</button>
                <button type="button" class="btn btn-outline-primary" data-days="30">30D</button>
                <button type="button" class="btn btn-outline-primary" data-days="90">90D</button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="clicksChart"></canvas>
        </div>
    </div>
</div>

<!-- Browser & Device Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-glass h-100">
            <div class="card-body">
                <h6 class="fw-700 mb-3"><i class="bi bi-globe text-primary me-2"></i>Top Browsers</h6>
                @if (count($browserStats) > 0)
                    @foreach ($browserStats as $browser => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">{{ $browser }}</span>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="width: 80px; height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $link->total_clicks > 0 ? ($count / $link->total_clicks) * 100 : 0 }}%"></div>
                                </div>
                                <span class="small fw-600 text-muted">{{ $count }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small mb-0">No data yet</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-glass h-100">
            <div class="card-body">
                <h6 class="fw-700 mb-3"><i class="bi bi-phone text-success me-2"></i>Devices</h6>
                @if (count($deviceStats) > 0)
                    @foreach ($deviceStats as $device => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">
                                <i class="bi {{ $device === 'desktop' ? 'bi-laptop' : ($device === 'mobile' ? 'bi-phone' : ($device === 'tablet' ? 'bi-tablet' : 'bi-question-circle')) }} me-1"></i>
                                {{ ucfirst($device) }}
                            </span>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="width: 80px; height: 6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $link->total_clicks > 0 ? ($count / $link->total_clicks) * 100 : 0 }}%"></div>
                                </div>
                                <span class="small fw-600 text-muted">{{ $count }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small mb-0">No data yet</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-glass h-100">
            <div class="card-body">
                <h6 class="fw-700 mb-3"><i class="bi bi-box-arrow-in-right text-info me-2"></i>Top Referrers</h6>
                @if (count($referrerStats) > 0)
                    @foreach ($referrerStats as $referrer => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-truncate" style="max-width: 120px;" title="{{ $referrer }}">
                                {{ Str::limit($referrer, 20) }}
                            </span>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="width: 80px; height: 6px;">
                                    <div class="progress-bar bg-info" style="width: {{ $link->total_clicks > 0 ? ($count / $link->total_clicks) * 100 : 0 }}%"></div>
                                </div>
                                <span class="small fw-600 text-muted">{{ $count }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small mb-0">No data yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const linkId = {{ $link->id }};
    const ctx = document.getElementById('clicksChart').getContext('2d');

    let clicksChart = null;

    function loadChart(days) {
        fetch(`/links/${linkId}/analytics/clicks-per-day?days=${days}`)
            .then(r => r.json())
            .then(data => {
                if (clicksChart) clicksChart.destroy();

                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const gridColor = isDark ? 'rgba(148, 163, 184, 0.1)' : 'rgba(0, 0, 0, 0.05)';
                const textColor = isDark ? '#94a3b8' : '#64748b';

                clicksChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels.map(d => {
                            const date = new Date(d);
                            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        }),
                        datasets: [{
                            label: 'Clicks',
                            data: data.data,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#1e293b' : '#fff',
                                titleColor: isDark ? '#e2e8f0' : '#1e293b',
                                bodyColor: isDark ? '#94a3b8' : '#64748b',
                                borderColor: isDark ? '#334155' : '#e2e8f0',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                            },
                        },
                        scales: {
                            x: {
                                grid: { color: gridColor },
                                ticks: { color: textColor, font: { size: 11 } },
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: {
                                    color: textColor,
                                    font: { size: 11 },
                                    stepSize: 1,
                                },
                            },
                        },
                    },
                });
            });
    }

    // Load default 30 days
    loadChart(30);

    // Date range buttons
    document.querySelectorAll('[data-days]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('[data-days]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadChart(this.dataset.days);
        });
    });
});
</script>
@endsection
