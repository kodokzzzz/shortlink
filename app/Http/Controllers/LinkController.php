<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function __construct(
        private SlugService $slugService,
    ) {}

    /**
     * Display the user's links (dashboard).
     */
    public function index(Request $request)
    {
        $query = Link::forUser(Auth::id())->notDeleted()->latest();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('original_url', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            if (in_array($status, ['active', 'inactive'])) {
                $query->where('status', $status);
            }
        }

        $links = $query->paginate(15)->withQueryString();

        // Stats for dashboard
        $stats = [
            'total_links' => Link::forUser(Auth::id())->notDeleted()->count(),
            'active_links' => Link::forUser(Auth::id())->active()->count(),
            'total_clicks' => Link::forUser(Auth::id())->notDeleted()->sum('total_clicks'),
            'inactive_links' => Link::forUser(Auth::id())->inactive()->count(),
        ];

        return view('links.index', compact('links', 'stats'));
    }

    /**
     * Show the create link form.
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created link.
     */
    public function store(StoreLinkRequest $request)
    {
        $validated = $request->validated();

        // Create link first to get ID for slug generation
        $link = Link::create([
            'user_id' => Auth::id(),
            'original_url' => $validated['original_url'],
            'slug' => $validated['slug'] ?? 'temp-' . uniqid(), // temporary slug
            'title' => $validated['title'] ?? null,
            'status' => 'active',
        ]);

        // Generate slug if not custom
        if (empty($validated['slug'])) {
            $link->slug = $this->slugService->generate($link->id);
            $link->save();
        }

        return redirect()->route('links.show', $link)
            ->with('success', 'Shortlink created successfully! 🎉');
    }

    /**
     * Display the link detail with analytics.
     */
    public function show(Link $link)
    {
        // Authorization
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $link->load('clickEvents');

        // Analytics data
        $clicksPerDay = $link->clickEvents()
            ->selectRaw('DATE(clicked_at) as date, COUNT(*) as count')
            ->where('clicked_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $browserStats = $link->clickEvents()
            ->selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'browser')
            ->toArray();

        $deviceStats = $link->clickEvents()
            ->selectRaw('device_type, COUNT(*) as count')
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->pluck('count', 'device_type')
            ->toArray();

        $referrerStats = $link->clickEvents()
            ->selectRaw('COALESCE(referrer, "Direct") as referrer_source, COUNT(*) as count')
            ->groupBy('referrer_source')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'referrer_source')
            ->toArray();

        $lastClicked = $link->clickEvents()->latest('clicked_at')->first()?->clicked_at;

        return view('links.show', compact(
            'link', 'clicksPerDay', 'browserStats', 'deviceStats', 'referrerStats', 'lastClicked'
        ));
    }

    /**
     * Show the edit link form.
     */
    public function edit(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        return view('links.edit', compact('link'));
    }

    /**
     * Update the link.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        $validated = $request->validated();

        $oldSlug = $link->slug;

        $link->update([
            'original_url' => $validated['original_url'],
            'title' => $validated['title'] ?? $link->title,
            'slug' => $validated['slug'] ?? $link->slug,
        ]);

        $message = 'Link updated successfully!';
        if ($oldSlug !== $link->slug) {
            $message .= ' QR code has been updated to reflect the new slug.';
        }

        return redirect()->route('links.show', $link)
            ->with('success', $message);
    }

    /**
     * Delete the link (soft delete via status).
     */
    public function destroy(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $link->update(['status' => 'deleted']);

        return redirect()->route('links.index')
            ->with('success', 'Link deleted successfully.');
    }

    /**
     * Toggle link active/inactive status.
     */
    public function toggleStatus(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $newStatus = $link->status === 'active' ? 'inactive' : 'active';
        $link->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "Link is now {$newStatus}.");
    }
}
