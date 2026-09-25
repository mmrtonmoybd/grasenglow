<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('announcement_tone', 20)->default('construction')->after('announcement_button_label');
            $table->boolean('announcement_is_dismissible')->default(true)->after('announcement_tone');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn(['announcement_tone', 'announcement_is_dismissible']);
        });
    }
};
