<?php

namespace App\Jobs;

use App\Models\ClickEvent;
use App\Models\Link;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Jenssegers\Agent\Agent;

class RecordClickEvent implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private int $linkId,
        private ?string $referrer,
        private ?string $userAgent,
        private ?string $ipAddress,
    ) {}

    public function handle(): void
    {
        // Parse user agent
        $agent = new Agent();
        $agent->setUserAgent($this->userAgent ?? '');

        $browser = $agent->browser();
        $deviceType = $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : ($agent->isMobile() ? 'mobile' : 'other'));

        // Hash IP for privacy
        $ipHash = $this->ipAddress ? hash('sha256', $this->ipAddress . config('app.key')) : null;

        // Create click event
        ClickEvent::create([
            'link_id' => $this->linkId,
            'clicked_at' => now(),
            'referrer' => $this->referrer,
            'user_agent' => $this->userAgent,
            'browser' => $browser ?: null,
            'device_type' => $deviceType,
            'ip_hash' => $ipHash,
        ]);

        // Increment total clicks
        Link::where('id', $this->linkId)->increment('total_clicks');
    }
}
