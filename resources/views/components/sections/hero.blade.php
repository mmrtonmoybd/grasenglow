@props([
    'section',
    'slides',
])

@php
    $showcase = $slides->sortBy('sort_order')->first()
        ?? (object) [
            'eyebrow' => $section->eyebrow,
            'heading' => $section->heading,
            'subheading' => $section->subheading,
            'body' => $section->body,
            'feature_items' => [],
            'closing_text' => null,
            'image' => $section->image,
            'mobile_image' => $section->mobile_image,
            'image_alt' => $section->image_alt,
        ];

    $featureItems = collect($showcase->feature_items ?? [])->filter(fn ($item): bool => filled($item['title'] ?? null));
    $toneClasses = [
        'forest' => 'bg-forest text-white',
        'rose' => 'bg-coral/75 text-white',
        'gold' => 'bg-[#b48a44] text-white',
    ];
@endphp

<section id="home" class="pt-5 sm:pt-6 lg:pt-8" aria-label="Grace & Glow highlights">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="bg-paper grid items-stretch overflow-hidden rounded-[2rem] ring-1 ring-forest/10 lg:grid-cols-[50%_50%]">
            <div class="bg-cream relative h-full">
                <picture class="block h-full w-full">
                    <source media="(max-width: 767px)" srcset="{{ asset('storage/' . $showcase->mobile_image) }}" />
                    <x-public-image
                        :path="$showcase->image"
                        :alt="$showcase->image_alt"
                        width="1200"
                        height="1400"
                        loading="eager"
                        fetchpriority="high"
                        class="block h-full w-full object-contain"
                    />
                </picture>
            </div>

            <div class="flex items-center px-5 py-6 sm:px-8 sm:py-8 lg:pl-12 lg:pr-12 xl:pl-16 xl:pr-16">
                <div class="ml-auto mr-0 w-full max-w-[34rem]">
                    @if ($showcase->eyebrow)
                        <p class="text-forest mb-4 text-center text-[10px] font-semibold tracking-[0.28em] uppercase">
                            {{ $showcase->eyebrow }}
                        </p>
                    @endif

                    <h1 class="font-display text-ink prose-rich-text text-[clamp(1.55rem,2.2vw,2.65rem)] leading-[1.14] tracking-[-0.03em] [&_strong]:text-forest [&_strong]:font-semibold [&_p]:inline">
                        {!! $showcase->heading !!}
                    </h1>

                    @if ($featureItems->isNotEmpty())
                        <div class="my-5 flex items-center gap-3">
                            <div class="h-px flex-1 bg-forest/30"></div>
                            <svg class="text-forest/75 h-8 w-8 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M11 20c5 0 9-4 9-9V4h-7c-5 0-9 4-9 9v7h7Z" />
                                <path d="M8 16c2-3 5-5 9-6" />
                            </svg>
                            <div class="h-px flex-1 bg-forest/30"></div>
                        </div>

                        <div class="space-y-4">
                            @foreach ($featureItems as $item)
                                @php
                                    $toneClass = $toneClasses[$item['tone'] ?? 'forest'] ?? $toneClasses['forest'];
                                @endphp

                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="{{ $toneClass }} grid h-12 w-12 shrink-0 place-items-center rounded-full text-white shadow-sm">
                                        @switch($item['icon'] ?? 'recycle')
                                            @case('scissors')
                                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <circle cx="6" cy="6" r="2.5" />
                                                    <circle cx="6" cy="18" r="2.5" />
                                                    <path d="M20 4 8.12 15.88M14.47 14.48 20 20M8.12 8.12 12 12" />
                                                </svg>
                                                @break
                                            @case('paw')
                                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M8.5 11.5c-1.4 0-2.5 1.4-2.5 3.1 0 1.6 1 2.9 2.3 2.9.8 0 1.5-.4 2-1.1.5-.7.7-1.6.5-2.5-.3-1.4-1.2-2.4-2.3-2.4Zm7 0c-1.1 0-2 1-2.3 2.4-.2.9 0 1.8.5 2.5.5.7 1.2 1.1 2 1.1 1.3 0 2.3-1.3 2.3-2.9 0-1.7-1.1-3.1-2.5-3.1ZM6.5 5.2c-1.1 0-2 1.2-2 2.6s.9 2.6 2 2.6 2-1.2 2-2.6-.9-2.6-2-2.6Zm11 0c-1.1 0-2 1.2-2 2.6s.9 2.6 2 2.6 2-1.2 2-2.6-.9-2.6-2-2.6ZM12 13.5c-2.6 0-5.3 2-5.3 4.4 0 1.7 1.2 2.9 3 2.9.9 0 1.5-.3 2.3-.7.8-.4 1.3-.7 2-.7s1.2.3 2 .7c.8.4 1.4.7 2.3.7 1.8 0 3-1.2 3-2.9 0-2.4-2.7-4.4-5.3-4.4Z" />
                                                </svg>
                                                @break
                                            @case('leaf')
                                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M11 20c5 0 9-4 9-9V4h-7c-5 0-9 4-9 9v7h7Z" />
                                                    <path d="M8 16c2-3 5-5 9-6" />
                                                </svg>
                                                @break
                                            @case('heart')
                                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 21s-6.7-4.35-9.2-8.1C.8 9.86 2.03 6 5.7 6c2.12 0 3.32 1.21 4.03 2.41C10.44 7.21 11.64 6 13.76 6c3.67 0 4.9 3.86 2.9 6.9C18.7 16.65 12 21 12 21Z" />
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M21 12a9 9 0 1 1-2.64-6.36" />
                                                    <path d="M21 3v6h-6" />
                                                    <path d="M8 12h8" />
                                                    <path d="M12 8v8" />
                                                </svg>
                                        @endswitch
                                    </div>

                                    <div class="pt-0.5">
                                        <h2 class="font-display text-ink text-[1.28rem] leading-[1.14]">
                                            {!! $item['title'] !!}
                                        </h2>
                                        @if (filled($item['body'] ?? null))
                                            <p class="text-ink/75 mt-1 text-sm leading-5 sm:text-[0.94rem]">
                                                {!! $item['body'] !!}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($showcase->closing_text)
                        <div class="my-5 flex items-center gap-3">
                            <div class="h-px flex-1 bg-forest/30"></div>
                            <svg class="text-forest/75 h-7 w-7 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 21s-6.7-4.35-9.2-8.1C.8 9.86 2.03 6 5.7 6c2.12 0 3.32 1.21 4.03 2.41C10.44 7.21 11.64 6 13.76 6c3.67 0 4.9 3.86 2.9 6.9C18.7 16.65 12 21 12 21Z" />
                            </svg>
                            <div class="h-px flex-1 bg-forest/30"></div>
                        </div>
                        <div class="font-display text-ink prose-rich-text text-center text-[1.5rem] leading-[1.22] sm:text-[1.85rem] [&_strong]:text-forest [&_strong]:font-semibold [&_p]:inline">
                            {!! $showcase->closing_text !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
