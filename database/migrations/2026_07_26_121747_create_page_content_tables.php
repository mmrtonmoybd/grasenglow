<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('navigation_label')->nullable();
            $table->string('page_template')->default('standard');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_image_alt')->nullable();
            $table->string('primary_cta_label', 80)->nullable();
            $table->string('primary_cta_url', 2048)->nullable();
            $table->string('secondary_cta_label', 80)->nullable();
            $table->string('secondary_cta_url', 2048)->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_indexable')->default(true);
            $table->string('canonical_url', 2048)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('open_graph_title')->nullable();
            $table->string('open_graph_description', 320)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->string('twitter_card_type')->default('summary_large_image');
            $table->string('schema_type')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'published_at']);
        });

        Schema::create('page_sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('section_type');
            $table->string('internal_name');
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->longText('body')->nullable();
            $table->string('image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_image_alt')->nullable();
            $table->string('primary_cta_label', 80)->nullable();
            $table->string('primary_cta_url', 2048)->nullable();
            $table->string('secondary_cta_label', 80)->nullable();
            $table->string('secondary_cta_url', 2048)->nullable();
            $table->json('settings')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_enabled')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['page_id', 'is_enabled', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
    }
};
