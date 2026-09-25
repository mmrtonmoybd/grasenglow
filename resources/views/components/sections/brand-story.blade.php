@props([
    'section',
])

<section id="about-story" class="mx-auto max-w-[1450px] px-4 py-4 sm:px-6 lg:px-10">
    <article class="paper-texture shadow-card grid overflow-hidden rounded-[24px] lg:grid-cols-[1fr_1.2fr]">
        @if ($section->image)
            <div class="group relative min-h-[360px] overflow-hidden bg-cream/40 flex items-center justify-center">
                <x-public-image
                    :path="$section->image"
                    :alt="$section->image_alt"
                    width="312"
                    height="251"
                    class="h-full w-full object-contain transition duration-700 group-hover:scale-105"
                />
            </div>
        @endif

        <div class="flex flex-col justify-center p-7 sm:p-10">
            <p class="font-script text-coral text-2xl">Our story</p>
            <h2 class="font-display text-forest mt-2 text-3xl leading-tight sm:text-4xl">{{ $section->heading }}</h2>
            <x-markdown :content="$section->body" class="text-ink/78 mt-5 text-sm leading-7 sm:text-base" />

            @if ($section->primary_cta_label && $section->primary_cta_url)
                <x-button-link :href="$section->primary_cta_url" class="mt-7 w-fit">
                    {{ $section->primary_cta_label }}
                </x-button-link>
            @endif
        </div>
    </article>
</section>
