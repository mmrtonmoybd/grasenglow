@props([
    'section',
    'categories',
])

<section id="products" class="mx-auto max-w-[1450px] px-4 py-8 sm:px-6 lg:px-10">
    <div class="text-center">
        <h2 class="leaf-line font-display text-forest flex items-center justify-center text-3xl sm:text-4xl">
            {{ $section->heading }}
        </h2>
        <x-markdown :content="$section->body" class="text-ink/70 mt-2 text-sm" />
    </div>

    <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($categories as $category)
            <article class="group border-forest/8 shadow-card overflow-hidden rounded-[20px] border bg-[#eee8db]">
                @if ($category->featured_image)
                    <div class="aspect-[4/2.6] overflow-hidden bg-cream/40">
                        <x-public-image
                            :path="$category->featured_image"
                            :alt="$category->featured_image_alt"
                            width="233"
                            height="149"
                            class="h-full w-full object-contain transition duration-700 group-hover:scale-105"
                        />
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4 p-4">
                    <div>
                        <h3 class="font-display text-forest text-xl">{{ $category->name }}</h3>
                        @if ($category->short_description)
                            <p class="text-ink/65 mt-1 text-xs">{{ $category->short_description }}</p>
                        @endif
                    </div>
                    <a
                        href="{{ route('product-categories.show', $category) }}"
                        class="focus-ring border-forest text-forest hover:bg-forest grid h-10 w-10 shrink-0 place-items-center rounded-full border transition hover:text-white"
                        aria-label="Explore {{ $category->name }}"
                    >
                        →
                    </a>
                </div>
            </article>
        @endforeach

        @if ($section->primary_cta_label && $section->primary_cta_url)
            <aside class="border-forest/8 shadow-card relative overflow-hidden rounded-[20px] border bg-[#efe7d9] p-6">
                <h3 class="font-display text-forest text-2xl leading-tight">
                    Every Piece
                    <br />
                    Tells a Story
                </h3>
                <div class="bg-forest/30 my-5 h-px w-24"></div>
                <p class="text-ink/70 text-sm leading-6">
                    What was once discarded is now handcrafted with purpose and care.
                </p>
                <x-button-link :href="$section->primary_cta_url" variant="secondary" class="mt-6">
                    {{ $section->primary_cta_label }}
                </x-button-link>
            </aside>
        @endif
    </div>
</section>
