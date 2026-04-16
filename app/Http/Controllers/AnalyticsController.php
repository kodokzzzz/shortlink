<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    /**
     * Get analytics data for a link (JSON endpoint for charts).
     */
    public function clicksPerDay(Request $request, Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $days = $request->get('days', 30);
        $days = min((int) $days, 90);

        $clicksPerDay = $link->clickEvents()
            ->selectRaw('DATE(clicked_at) as date, COUNT(*) as count')
            ->where('clicked_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing days with 0
        $filled = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $filled[$date] = $clicksPerDay[$date] ?? 0;
        }

        return response()->json([
            'labels' => array_keys($filled),
            'data' => array_values($filled),
        ]);
    }
}
