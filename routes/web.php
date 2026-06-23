<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RedirectController;
use App\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// =============================================
// Public Routes
// =============================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =============================================
// API Routes (for AJAX)
// =============================================
Route::get('/api/check-slug', function (Request $request) {
    $slug = $request->get('slug', '');
    $slugService = app(SlugService::class);
    return response()->json([
        'available' => $slugService->isAvailable($slug),
        'slug' => $slug,
    ]);
})->middleware('auth')->name('api.check-slug');

// =============================================
// Authenticated Routes
// =============================================
Route::middleware('auth')->group(function () {
    // Dashboard (redirects to links index)
    Route::get('/dashboard', [LinkController::class, 'index'])->name('dashboard');

    // Link Management
    Route::resource('links', LinkController::class);
    Route::patch('/links/{link}/toggle', [LinkController::class, 'toggleStatus'])->name('links.toggle');

    // Analytics
    Route::get('/links/{link}/analytics/clicks-per-day', [AnalyticsController::class, 'clicksPerDay'])
        ->name('links.analytics.clicks');

    // QR Code
    Route::get('/links/{link}/qrcode', [QrCodeController::class, 'show'])->name('links.qrcode');
    Route::get('/links/{link}/qrcode/download', [QrCodeController::class, 'download'])->name('links.qrcode.download');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================================
// Auth Routes (must be before catch-all)
// =============================================
require __DIR__.'/auth.php';

// =============================================
// Redirect Handler (MUST be last — catch-all)
// =============================================
Route::get('/{slug}', [RedirectController::class, 'handle'])
    ->name('redirect')
    ->where('slug', '[a-zA-Z0-9_-]+');

// Password submission for protected links.
Route::post('/{slug}', [RedirectController::class, 'unlock'])
    ->name('redirect.unlock')
    ->where('slug', '[a-zA-Z0-9_-]+');
