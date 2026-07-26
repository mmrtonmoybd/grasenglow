@props([
    'section',
    'slides',
])

@php
    $carouselSlides = $slides->isNotEmpty()
        ? $slides
        : collect([
            (object) [
                'eyebrow' => $section->eyebrow,
                'heading' => $section->heading,
                'subheading' => $section->subheading,
                'body' => $section->body,
                'image' => $section->image,
                'mobile_image' => $section->mobile_image,
                'image_alt' => $section->image_alt,
                'primary_cta_label' => $section->primary_cta_label,
                'primary_cta_url' => $section->primary_cta_url,
                'secondary_cta_label' => $section->secondary_cta_label,
                'secondary_cta_url' => $section->secondary_cta_url,
                'duration_seconds' => 3,
                'attribution' => null,
                'source_url' => null,
            ],
        ]);
@endphp

<section
    id="home"
    class="hero-carousel relative overflow-hidden"
    data-hero-carousel
    aria-roledescription="carousel"
    aria-label="Grace & Glow highlights"
>
    <div class="grid min-h-[680px]">
        @foreach ($carouselSlides as $slide)
            <article
                id="hero-slide-{{ $loop->iteration }}"
                class="hero-carousel__slide col-start-1 row-start-1 transition-[opacity,visibility,transform] duration-300 ease-out"
                data-hero-slide
                data-duration="{{ $slide->duration_seconds * 1000 }}"
                aria-roledescription="slide"
                aria-label="{{ $loop->iteration }} of {{ $carouselSlides->count() }}"
                aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                @if (! $loop->first) inert @endif
            >
                <div class="mx-auto grid min-h-[680px] max-w-[1500px] lg:grid-cols-[42%_58%]">
                    <div
                        class="relative z-10 flex items-center px-5 py-20 pb-28 sm:px-10 lg:px-14 lg:py-20 lg:pb-28 xl:px-20"
                    >
                        <div class="max-w-xl">
                            <div
                                class="text-forest mb-4 flex items-center gap-2 text-xs font-semibold tracking-[.09em] uppercase"
                            >
                                <span
                                    class="bg-sage/30 grid h-6 w-6 place-items-center rounded-full"
                                    aria-hidden="true"
                                >
                                    ❧
                                </span>
                                {{ $slide->eyebrow }}
                            </div>

                            <h1
                                class="font-display text-forest text-[clamp(2.75rem,6.2vw,5.7rem)] leading-[.94] tracking-[-.045em] [overflow-wrap:anywhere]"
                            >
                                {{ $slide->heading }}
                                <span
                                    class="font-script text-forest/90 mt-2 flex flex-wrap items-end gap-x-4 gap-y-1 text-[.7em] font-medium tracking-normal"
                                >
                                    {{ $slide->subheading }}
                                    <span class="text-coral mb-2" aria-hidden="true">♥</span>
                                </span>
                            </h1>

                            <p class="text-ink/80 mt-7 max-w-lg text-base leading-7 sm:text-lg">{{ $slide->body }}</p>

                            <div class="mt-8 flex flex-wrap gap-3">
                                <x-button-link :href="$slide->primary_cta_url">
                                    {{ $slide->primary_cta_label }}
                                </x-button-link>
                                <x-button-link :href="$slide->secondary_cta_url" variant="secondary">
                                    {{ $slide->secondary_cta_label }}
                                </x-button-link>
                            </div>
                        </div>
                    </div>

                    <div
                        class="hero-image bg-cream relative min-h-[460px] overflow-hidden lg:min-h-[680px]"
                    >
                        <picture class="block h-full w-full">
                            <source
                                media="(max-width: 767px)"
                                srcset="{{ asset('storage/' . $slide->mobile_image) }}"
                            />
                            <x-public-image
                                :path="$slide->image"
                                :alt="$slide->image_alt"
                                width="1200"
                                height="900"
                                :loading="$loop->first ? 'eager' : 'lazy'"
                                :fetchpriority="$loop->first ? 'high' : 'auto'"
                                class="absolute inset-0 h-full w-full object-contain object-center"
                            />
                        </picture>

                        @if ($slide->attribution && $slide->source_url)
                            <a
                                href="{{ $slide->source_url }}"
                                rel="noopener noreferrer"
                                target="_blank"
                                class="focus-ring absolute right-3 bottom-3 z-10 rounded bg-black/60 px-2 py-1 text-[10px] text-white/90"
                            >
                                Image: {{ $slide->attribution }}
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    @if ($carouselSlides->count() > 1)
        <div
            class="absolute right-0 bottom-6 left-0 z-20 mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-5 sm:px-10 lg:px-14 xl:px-20"
        >
            <div class="flex items-center gap-2" role="tablist" aria-label="Choose a hero slide">
                @foreach ($carouselSlides as $slide)
                    <button
                        type="button"
                        class="hero-carousel__dot focus-ring bg-coral h-3 w-8 rounded-full border border-white/80 shadow-md transition-all"
                        data-hero-dot
                        role="tab"
                        aria-controls="hero-slide-{{ $loop->iteration }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="Show slide {{ $loop->iteration }}"
                    ></button>
                @endforeach
            </div>

            <div class="flex gap-2">
                <button
                    type="button"
                    class="focus-ring bg-forest/85 grid h-11 w-11 place-items-center rounded-full border border-white/40 text-xl text-white shadow-lg backdrop-blur"
                    data-hero-previous
                    aria-label="Previous slide"
                >
                    ←
                </button>
                <button
                    type="button"
                    class="focus-ring bg-forest/85 grid h-11 w-11 place-items-center rounded-full border border-white/40 text-xl text-white shadow-lg backdrop-blur"
                    data-hero-next
                    aria-label="Next slide"
                >
                    →
                </button>
            </div>
        </div>

        <p class="sr-only" aria-live="polite" data-hero-status>Slide 1 of {{ $carouselSlides->count() }}</p>
    @endif
</section>
