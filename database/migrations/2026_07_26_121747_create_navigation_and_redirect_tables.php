<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('location')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('navigation_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('navigation_menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->cascadeOnDelete();
            $table->string('label');
            $table->string('link_type')->default('internal');
            $table->string('link_value', 2048);
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('open_in_new_tab')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->boolean('show_on_desktop')->default(true);
            $table->boolean('show_on_mobile')->default(true);
            $table->timestamps();
            $table->index(['navigation_menu_id', 'parent_id', 'sort_order'], 'nav_items_menu_parent_sort_idx');
        });

        Schema::create('redirects', function (Blueprint $table): void {
            $table->id();
            $table->string('old_path')->unique();
            $table->string('destination_url', 2048);
            $table->unsignedSmallInteger('status_code')->default(301);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedBigInteger('hit_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('navigation_menus');
    }
};
