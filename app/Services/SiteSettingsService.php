<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

final class SiteSettingsService
{
    public function get(): SiteSetting
    {
        return Cache::rememberForever(
            'cms.site-settings',
            fn (): SiteSetting => SiteSetting::query()->firstOrNew(
                ['singleton_key' => 'default'],
                ['site_name' => 'Grace & Glow'],
            ),
        );
    }
}
