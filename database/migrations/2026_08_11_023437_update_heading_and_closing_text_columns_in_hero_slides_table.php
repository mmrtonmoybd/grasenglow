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
            $table->text('heading')->change();
            $table->text('closing_text')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table): void {
            $table->string('heading', 255)->change();
            $table->string('closing_text', 255)->nullable()->change();
        });
    }
};
