<?php

namespace App\Http\Controllers;

use App\Jobs\RecordClickEvent;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    /**
     * Handle shortlink redirect — the most critical endpoint.
     */
    public function handle(Request $request, string $slug)
    {
        $link = Link::where('slug', $slug)->first();

        // 404 — slug not found
        if (!$link || $link->status === 'deleted') {
            return response()->view('errors.404-link', ['slug' => $slug], 404);
        }

        // Inactive link page
        if ($link->status === 'inactive') {
            return response()->view('errors.inactive-link', ['link' => $link], 410);
        }

        // Time-based link — not yet active
        if ($link->isNotYetActive()) {
            return response()->view('errors.not-active-link', ['link' => $link], 403);
        }

        // Time-based link — expired
        if ($link->isExpired()) {
            return response()->view('errors.expired-link', ['link' => $link], 410);
        }

        // Protected link — ask for password unless already unlocked this session
        if ($link->isPasswordProtected() && !$this->isUnlocked($request, $link)) {
            return response()->view('links.password', ['link' => $link]);
        }

        $this->recordClick($request, $link);

        // 302 redirect to destination
        return redirect()->away($link->original_url, 302);
    }

    /**
     * Verify the password for a protected link, then redirect on success.
     */
    public function unlock(Request $request, string $slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (!$link || $link->status !== 'active') {
            return response()->view('errors.404-link', ['slug' => $slug], 404);
        }

        // Re-check the schedule on submit, too.
        if ($link->isNotYetActive()) {
            return response()->view('errors.not-active-link', ['link' => $link], 403);
        }
        if ($link->isExpired()) {
            return response()->view('errors.expired-link', ['link' => $link], 410);
        }

        // Nothing to unlock — just go.
        if (!$link->isPasswordProtected()) {
            $this->recordClick($request, $link);
            return redirect()->away($link->original_url, 302);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Please enter the password.',
        ]);

        if (!Hash::check($request->input('password'), $link->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password. Please try again.',
            ]);
        }

        // Remember the unlock for this browser session.
        $request->session()->put($this->unlockKey($link), true);

        $this->recordClick($request, $link);

        return redirect()->away($link->original_url, 302);
    }

    /**
     * Whether the current session has already unlocked this link.
     */
    private function isUnlocked(Request $request, Link $link): bool
    {
        return (bool) $request->session()->get($this->unlockKey($link), false);
    }

    private function unlockKey(Link $link): string
    {
        return "unlocked_link_{$link->id}";
    }

    /**
     * Dispatch async click logging (non-blocking).
     */
    private function recordClick(Request $request, Link $link): void
    {
        RecordClickEvent::dispatch(
            $link->id,
            $request->header('referer'),
            $request->userAgent(),
            $request->ip(),
        );
    }
}
