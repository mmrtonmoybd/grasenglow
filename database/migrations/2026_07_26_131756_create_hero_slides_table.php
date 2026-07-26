<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table): void {
            $table->id();
            $table->string('internal_name');
            $table->string('eyebrow');
            $table->string('heading');
            $table->string('subheading');
            $table->text('body');
            $table->string('image');
            $table->string('mobile_image');
            $table->string('image_alt');
            $table->string('primary_cta_label', 80);
            $table->string('primary_cta_url', 2048);
            $table->string('secondary_cta_label', 80);
            $table->string('secondary_cta_url', 2048);
            $table->unsignedTinyInteger('duration_seconds')->default(7);
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_enabled')->default(true)->index();
            $table->string('source_url', 2048);
            $table->string('license', 120);
            $table->string('attribution');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['is_enabled', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
