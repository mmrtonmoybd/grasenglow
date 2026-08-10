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
        Schema::table('hero_slides', function (Blueprint $table): void {
            $table->json('feature_items')->nullable()->after('body');
            $table->text('closing_text')->nullable()->after('feature_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table): void {
            $table->dropColumn(['feature_items', 'closing_text']);
        });
    }
};
