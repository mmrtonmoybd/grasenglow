@props([
    'section',
])

<section id="mission" class="mx-auto max-w-[1450px] px-4 py-4 sm:px-6 lg:px-10">
    <div class="bg-sage/15 rounded-[24px] p-7 sm:p-10">
        <h2 class="font-display text-forest text-3xl leading-tight sm:text-4xl">
            {{ $section->heading }}
            <span class="font-script text-coral">♡</span>
        </h2>
        <x-markdown :content="$section->body" class="text-ink/80 mt-5 max-w-4xl text-sm leading-7 sm:text-base" />

        @if ($section->primary_cta_label && $section->primary_cta_url)
            <x-button-link :href="$section->primary_cta_url" variant="secondary" class="mt-7">
                {{ $section->primary_cta_label }}
            </x-button-link>
        @endif
    </div>
</section>
