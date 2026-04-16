<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Show QR code as inline SVG.
     */
    public function show(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $qrCode = QrCode::size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($link->short_url);

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Download QR code as SVG.
     */
    public function download(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $qrCode = QrCode::size(400)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($link->short_url);

        $filename = 'qr-' . $link->slug . '.svg';

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
