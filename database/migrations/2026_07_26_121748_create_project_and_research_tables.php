<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('objective')->nullable();
            $table->longText('methodology')->nullable();
            $table->longText('results')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('planned')->index();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->json('gallery')->nullable();
            $table->text('partners')->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->string('document')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('publication_status')->default('draft')->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['publication_status', 'published_at'], 'projects_publication_idx');
        });

        Schema::create('research_publications', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('abstract')->nullable();
            $table->text('authors')->nullable();
            $table->string('publication_name')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('research_status')->default('ongoing')->index();
            $table->string('document')->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->text('keywords')->nullable();
            $table->string('publication_status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['publication_status', 'published_at'], 'research_publication_idx');
        });

        Schema::create('impact_stories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('related_project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('beneficiary_type')->nullable();
            $table->date('impact_date')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_stories');
        Schema::dropIfExists('research_publications');
        Schema::dropIfExists('projects');
    }
};
