<?php

declare(strict_types=1);

use App\Enums\AnnouncementTone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const MESSAGE = 'Our new website is **under construction** — a few pages are still being stitched together. Everything here is live, so please explore.';

    /**
     * Seed the under-construction notice without overwriting a message an editor already wrote.
     */
    public function up(): void
    {
        DB::table('site_settings')
            ->whereNull('announcement_text')
            ->orWhere('announcement_text', '')
            ->update([
                'display_announcement' => true,
                'announcement_text' => self::MESSAGE,
                'announcement_url' => '/products',
                'announcement_button_label' => 'Explore products',
                'announcement_tone' => AnnouncementTone::Construction->value,
                'announcement_is_dismissible' => true,
                'updated_at' => now(),
            ]);

        Cache::forget('cms.site-settings');
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('announcement_text', self::MESSAGE)
            ->update([
                'display_announcement' => false,
                'announcement_text' => null,
                'announcement_url' => null,
                'announcement_button_label' => null,
                'updated_at' => now(),
            ]);

        Cache::forget('cms.site-settings');
    }
};
