<?php

namespace App\Http\Controllers;

use App\Jobs\RecordClickEvent;
use App\Models\Link;
use Illuminate\Http\Request;

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

        // Dispatch async click logging (non-blocking)
        RecordClickEvent::dispatch(
            $link->id,
            $request->header('referer'),
            $request->userAgent(),
            $request->ip(),
        );

        // 302 redirect to destination
        return redirect()->away($link->original_url, 302);
    }
}
