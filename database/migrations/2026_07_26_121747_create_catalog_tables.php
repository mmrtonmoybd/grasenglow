<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_image_alt')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('show_when_empty')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_collections', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('cover_image_alt')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_image_alt')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
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

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('story')->nullable();
            $table->longText('materials')->nullable();
            $table->longText('craftsmanship_details')->nullable();
            $table->longText('sustainability_details')->nullable();
            $table->longText('animal_support_details')->nullable();
            $table->longText('care_instructions')->nullable();
            $table->string('dimensions')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('color_description')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('compare_price', 12, 2)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('availability_status')->default('inquiry_only')->index();
            $table->unsignedInteger('stock_quantity')->nullable();
            $table->boolean('made_to_order')->default(false);
            $table->string('lead_time')->nullable();
            $table->boolean('inquiry_enabled')->default(true);
            $table->string('inquiry_button_label', 80)->nullable();
            $table->string('inquiry_url', 2048)->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_new')->default(false)->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('open_graph_title')->nullable();
            $table->string('open_graph_description', 320)->nullable();
            $table->string('open_graph_image')->nullable();
            $table->boolean('is_indexable')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'published_at']);
            $table->index(['product_category_id', 'status', 'published_at'], 'products_category_publish_idx');
        });

        Schema::create('product_collection_product', function (Blueprint $table): void {
            $table->foreignId('product_collection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_collection_id', 'product_id'], 'collection_product_primary');
        });

        Schema::create('product_images', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('alt_text');
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_primary')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('related_products', function (Blueprint $table): void {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $table->primary(['product_id', 'related_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('related_products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_collection_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_collections');
        Schema::dropIfExists('product_categories');
    }
};
