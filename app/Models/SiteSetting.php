<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AnnouncementTone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SiteSetting extends CmsModel
{
    /** @use HasFactory<\Database\Factories\SiteSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'singleton_key', 'site_name', 'short_site_name', 'primary_tagline', 'secondary_tagline',
        'logo', 'dark_logo', 'mobile_logo', 'favicon', 'default_share_image', 'email', 'secondary_email',
        'phone', 'whatsapp_number', 'address_line_1', 'address_line_2', 'city', 'postal_code', 'country',
        'map_url', 'business_hours', 'primary_color', 'secondary_color', 'accent_color', 'background_color',
        'text_color', 'heading_font', 'body_font', 'display_announcement', 'announcement_text',
        'announcement_url', 'announcement_button_label', 'announcement_tone', 'announcement_is_dismissible',
        'footer_description', 'footer_thank_you_text',
        'copyright_text', 'privacy_page_id', 'terms_page_id', 'default_meta_title', 'default_meta_description',
        'default_meta_keywords', 'default_open_graph_image', 'organization_schema_name',
        'organization_schema_description', 'organization_schema_logo', 'canonical_domain',
        'robots_index_enabled', 'sitemap_enabled', 'google_analytics_id', 'google_tag_manager_id',
        'search_console_verification', 'created_by', 'updated_by',
    ];

    public function privacyPage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'privacy_page_id');
    }

    public function termsPage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'terms_page_id');
    }

    protected function casts(): array
    {
        return [
            'display_announcement' => 'boolean',
            'announcement_is_dismissible' => 'boolean',
            'announcement_tone' => AnnouncementTone::class,
            'robots_index_enabled' => 'boolean',
            'sitemap_enabled' => 'boolean',
        ];
    }
}
