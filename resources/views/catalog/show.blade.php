@php
    $productSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => strip_tags($product->short_description ?: $product->description),
        'image' => $product->featured_image ? asset('storage/' . $product->featured_image) : null,
        'sku' => $product->sku,
    ]);
@endphp

<x-layouts.public :seo="$seo" :structured-data="[$productSchema]">
    <article class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:py-20">
        <div>
            @if ($product->featured_image)
                <x-public-image
                    :path="$product->featured_image"
                    :alt="$product->featured_image_alt"
                    width="900"
                    height="700"
                    loading="eager"
                    fetchpriority="high"
                    class="shadow-card aspect-[4/3] w-full rounded-[24px] object-contain"
                />
            @endif

            @if ($product->images->isNotEmpty())
                <div class="mt-4 grid grid-cols-3 gap-3">
                    @foreach ($product->images as $image)
                        <x-public-image
                            :path="$image->image"
                            :alt="$image->alt_text"
                            width="300"
                            height="220"
                            class="aspect-[4/3] w-full rounded-xl object-contain"
                        />
                    @endforeach
                </div>
            @endif
        </div>
        <div>
            <nav class="text-ink/55 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('products.index') }}">Products</a>
                @if ($product->category)
                    /
                    <a href="{{ route('product-categories.show', $product->category) }}">
                        {{ $product->category->name }}
                    </a>
                @endif
            </nav>
            <h1 class="font-display text-forest mt-5 text-5xl">{{ $product->name }}</h1>
            @if ($product->short_description)
                <p class="text-ink/70 mt-5 text-lg leading-8">{{ $product->short_description }}</p>
            @endif

            @if ($product->price !== null && $product->currency)
                <p class="text-forest mt-5 text-xl font-semibold">{{ $product->currency }} {{ $product->price }}</p>
            @else
                <p class="text-forest mt-5 text-base font-semibold">
                    Price and current availability are confirmed by enquiry.
                </p>
            @endif

            @foreach (['description' => 'Details', 'story' => 'Product Story', 'materials' => 'Materials', 'craftsmanship_details' => 'Craftsmanship', 'sustainability_details' => 'Sustainability', 'animal_support_details' => 'Animal Support', 'care_instructions' => 'Care'] as $field => $label)
                @if ($product->{$field})
                    <section class="border-forest/10 mt-7 border-t pt-6">
                        <h2 class="font-display text-forest text-2xl">{{ $label }}</h2>
                        <p class="prose-content text-ink/75 mt-3 text-sm">{{ $product->{$field} }}</p>
                    </section>
                @endif
            @endforeach

            @if ($product->inquiry_enabled)
                <x-button-link :href="$product->inquiry_url ?: route('contact.create')" class="mt-8">
                    {{ $product->inquiry_button_label ?: 'Ask about this piece' }}
                </x-button-link>
            @endif
        </div>
    </article>
</x-layouts.public>
