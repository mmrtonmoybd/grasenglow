<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SitemapService;
use App\Services\SiteSettingsService;
use Illuminate\Http\Response;

final readonly class SitemapController
{
    public function __construct(
        private SitemapService $sitemap,
        private SiteSettingsService $settings,
    ) {}

    public function __invoke(): Response
    {
        return response()
            ->view('seo.sitemap', ['urls' => $this->sitemap->urls()])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $settings = $this->settings->get();
        $rules = $settings->robots_index_enabled
            ? "User-agent: *\nAllow: /\nDisallow: /admin\n"
            : "User-agent: *\nDisallow: /\n";

        if ($settings->sitemap_enabled) {
            $rules .= 'Sitemap: '.route('sitemap')."\n";
        }

        return response($rules)->header('Content-Type', 'text/plain');
    }
}
