<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('new')->index();
            $table->string('source_page')->nullable();
            $table->timestamp('submitted_at')->index();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('internal_notes')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table): void {
            $table->id();
            $table->string('platform');
            $table->string('label');
            $table->string('url', 2048);
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('open_in_new_tab')->default(true);
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->string('source_page')->nullable();
            $table->timestamp('subscribed_at');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('contact_messages');
    }
};
