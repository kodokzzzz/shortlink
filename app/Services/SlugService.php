<?php

namespace App\Services;

use App\Models\Link;
use App\Models\ReservedSlug;
use Hashids\Hashids;

class SlugService
{
    private Hashids $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(config('app.key', 'shortlink-salt'), 6, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    }

    /**
     * Generate a unique slug from a given ID.
     */
    public function generate(int $id): string
    {
        $slug = $this->hashids->encode($id, time() % 10000);

        // Ensure uniqueness — extremely unlikely to collide but safety first
        while (!$this->isAvailable($slug)) {
            $slug = $this->hashids->encode($id, random_int(1, 999999));
        }

        return $slug;
    }

    /**
     * Check if a slug is available (not taken and not reserved).
     */
    public function isAvailable(string $slug): bool
    {
        if ($this->isReserved($slug)) {
            return false;
        }

        return !Link::where('slug', $slug)->where('status', '!=', 'deleted')->exists();
    }

    /**
     * Check if a slug is reserved by the system.
     */
    public function isReserved(string $slug): bool
    {
        return ReservedSlug::where('slug', strtolower($slug))->exists();
    }
}
