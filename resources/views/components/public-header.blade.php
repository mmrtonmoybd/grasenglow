@props([
    'siteSettings',
    'headerNavigation',
])

<header class="border-forest/10 bg-cream/95 sticky top-0 z-50 border-b backdrop-blur-md">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-6 px-4 py-3 sm:px-6 lg:px-10">
        <a
            href="{{ route('home') }}"
            class="focus-ring shrink-0 rounded-xl"
            aria-label="{{ $siteSettings->site_name }} home"
        >
            <x-site-logo :settings="$siteSettings" compact />
        </a>

        <nav class="text-ink hidden items-center gap-7 text-[13px] font-medium lg:flex" aria-label="Primary navigation">
            @foreach ($headerNavigation->where('show_on_desktop', true) as $item)
                @php($active = url()->current() === url($item->resolvedUrl()))
                <a
                    href="{{ $item->resolvedUrl() }}"
                    @if ($item->open_in_new_tab) target="_blank" @endif
                    rel="{{ collect([$item->open_in_new_tab ? 'noopener noreferrer' : null, $item->nofollow ? 'nofollow' : null])->filter()->join(' ') }}"
                    @class(['focus-ring rounded', 'border-forest text-forest border-b pb-1' => $active])
                    @if ($active) aria-current="page" @endif
                >
                    {{ $item->label }}
                </a>
            @endforeach
        </nav>

        <button
            type="button"
            class="focus-ring border-forest text-forest grid h-11 w-11 place-items-center rounded-full border lg:hidden"
            aria-controls="mobile-menu"
            aria-expanded="false"
            aria-label="Toggle navigation"
            data-mobile-menu-button
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <nav
        id="mobile-menu"
        class="border-forest/10 bg-paper border-t px-4 py-4 lg:hidden"
        aria-label="Mobile navigation"
        data-mobile-menu
        hidden
    >
        <div class="mx-auto grid max-w-2xl grid-cols-2 gap-2 text-sm font-medium">
            @foreach ($headerNavigation->where('show_on_mobile', true) as $item)
                <a
                    href="{{ $item->resolvedUrl() }}"
                    @class([
                        'focus-ring hover:bg-forest/5 rounded-xl px-4 py-3',
                        'bg-forest text-white' => url()->current() === url($item->resolvedUrl()),
                    ])
                >
                    {{ $item->label }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
