<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('cms:refresh-publication-cache')]
#[Description('Refresh caches that can contain scheduled public content')]
final class RefreshPublicationCache extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Cache::forget('cms.homepage');
        Cache::forget('cms.sitemap');
        Cache::forget('cms.dashboard.content-overview');

        $this->components->info('Publication caches refreshed.');

        return self::SUCCESS;
    }
}
