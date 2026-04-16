<?php

namespace Database\Seeders;

use App\Models\ReservedSlug;
use Illuminate\Database\Seeder;

class ReservedSlugSeeder extends Seeder
{
    public function run(): void
    {
        $slugs = [
            'admin', 'api', 'login', 'register', 'dashboard',
            'logout', 'password', 'links', 'analytics', 'settings',
            'profile', 'home', 'about', 'help', 'support',
            'contact', 'terms', 'privacy', 'favicon', 'robots',
            'sitemap', 'health', 'status', 'auth', 'oauth',
            'callback', 'verify', 'reset', 'confirm', 'email',
            'user', 'users', 'account', 'billing', 'pricing',
            'docs', 'blog', 'news', 'feed', 'rss',
            'app', 'static', 'assets', 'public', 'storage',
            'uploads', 'images', 'css', 'js', 'fonts',
        ];

        foreach ($slugs as $slug) {
            ReservedSlug::firstOrCreate(['slug' => $slug]);
        }
    }
}
