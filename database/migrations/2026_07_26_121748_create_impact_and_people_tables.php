<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_metrics', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->decimal('numeric_value', 14, 2)->nullable();
            $table->string('display_value', 40);
            $table->string('unit', 40)->nullable();
            $table->string('prefix', 20)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->date('last_verified_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('brand_values', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('partner_type')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_alt')->nullable();
            $table->text('description')->nullable();
            $table->string('website', 2048)->nullable();
            $table->string('location')->nullable();
            $table->date('partnership_start_date')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('artisans', function (Blueprint $table): void {
            $table->id();
            $table->string('display_name')->nullable();
            $table->string('role')->nullable();
            $table->longText('biography')->nullable();
            $table->string('photograph')->nullable();
            $table->string('photograph_alt')->nullable();
            $table->text('quote')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('consent_confirmed')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('organization')->nullable();
            $table->text('quote');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('consent_confirmed')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('artisans');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('brand_values');
        Schema::dropIfExists('impact_metrics');
    }
};
