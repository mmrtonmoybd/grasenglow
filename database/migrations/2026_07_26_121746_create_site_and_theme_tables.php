<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('singleton_key')->default('default')->unique();
            $table->string('site_name')->default('Grace & Glow');
            $table->string('short_site_name')->nullable();
            $table->string('primary_tagline')->nullable();
            $table->string('secondary_tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('mobile_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('default_share_image')->nullable();
            $table->string('email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('whatsapp_number', 50)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city', 120)->nullable();
            $table->string('postal_code', 40)->nullable();
            $table->string('country', 120)->nullable();
            $table->string('map_url', 2048)->nullable();
            $table->text('business_hours')->nullable();
            $table->string('primary_color', 7)->default('#24462d');
            $table->string('secondary_color', 7)->default('#17381f');
            $table->string('accent_color', 7)->default('#d98a75');
            $table->string('background_color', 7)->default('#f5f0e7');
            $table->string('text_color', 7)->default('#1e271f');
            $table->string('heading_font')->default('Playfair Display');
            $table->string('body_font')->default('DM Sans');
            $table->boolean('display_announcement')->default(false);
            $table->string('announcement_text')->nullable();
            $table->string('announcement_url', 2048)->nullable();
            $table->string('announcement_button_label', 80)->nullable();
            $table->text('footer_description')->nullable();
            $table->text('footer_thank_you_text')->nullable();
            $table->string('copyright_text')->nullable();
            $table->foreignId('privacy_page_id')->nullable();
            $table->foreignId('terms_page_id')->nullable();
            $table->string('default_meta_title')->nullable();
            $table->string('default_meta_description', 320)->nullable();
            $table->text('default_meta_keywords')->nullable();
            $table->string('default_open_graph_image')->nullable();
            $table->string('organization_schema_name')->nullable();
            $table->text('organization_schema_description')->nullable();
            $table->string('organization_schema_logo')->nullable();
            $table->string('canonical_domain', 2048)->nullable();
            $table->boolean('robots_index_enabled')->default(true);
            $table->boolean('sitemap_enabled')->default(true);
            $table->string('google_analytics_id', 40)->nullable();
            $table->string('google_tag_manager_id', 40)->nullable();
            $table->string('search_console_verification')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
