@props([
    'siteSettings',
    'footerQuickNavigation',
    'footerHelpNavigation',
    'socialLinks',
])

<footer class="mx-auto max-w-[1450px] px-5 py-8 sm:px-6 sm:py-10 lg:px-10">
    <div
        class="border-forest/10 grid grid-cols-2 gap-x-6 gap-y-9 border-b pb-8 md:grid-cols-4 lg:grid-cols-[1.2fr_.9fr_.55fr_.65fr_1fr]"
    >
        <a
            href="{{ route('home') }}"
            class="focus-ring col-span-2 mx-auto w-fit rounded-xl md:col-span-4 md:mx-0 lg:col-span-1"
        >
            <x-site-logo :settings="$siteSettings" />
        </a>

        <div class="text-ink/75 col-span-2 grid grid-cols-2 gap-6 text-xs leading-7 md:col-span-2 lg:col-span-1">
            <div>
                <h2 class="text-ink mb-2 font-semibold">Quick Links</h2>
                @foreach ($footerQuickNavigation->chunk(3)->first() ?? [] as $item)
                    <a class="hover:text-forest block" href="{{ $item->resolvedUrl() }}">{{ $item->label }}</a>
                @endforeach
            </div>
            <div class="pt-7">
                @foreach ($footerQuickNavigation->chunk(3)->get(1) ?? [] as $item)
                    <a class="hover:text-forest block" href="{{ $item->resolvedUrl() }}">{{ $item->label }}</a>
                @endforeach
            </div>
        </div>

        <div class="text-ink/75 text-xs leading-7">
            <h2 class="text-ink mb-2 font-semibold">Help</h2>
            @foreach ($footerHelpNavigation as $item)
                <a class="hover:text-forest block" href="{{ $item->resolvedUrl() }}">{{ $item->label }}</a>
            @endforeach
        </div>

        <div>
            <h2 class="text-ink mb-4 text-xs font-semibold">Follow Us</h2>
            <div class="flex gap-3">
                @foreach ($socialLinks as $link)
                    <a
                        class="focus-ring bg-forest grid h-9 w-9 place-items-center rounded-full text-xs font-bold text-white"
                        href="{{ $link->url }}"
                        aria-label="{{ $link->label }}"
                        @if ($link->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif
                    >
                        {{ mb_strtoupper(mb_substr($link->label, 0, 2)) }}
                    </a>
                @endforeach
            </div>
        </div>

        @if ($siteSettings->footer_thank_you_text)
            <div
                class="border-forest/10 bg-paper col-span-2 flex items-center gap-4 rounded-2xl border p-4 md:col-span-4 lg:col-span-1 lg:border-y-0 lg:border-r-0 lg:bg-transparent lg:py-0 lg:pr-0 lg:pl-7"
            >
                <svg
                    class="text-coral h-11 w-11 shrink-0"
                    viewBox="0 0 48 48"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.2"
                    aria-hidden="true"
                >
                    <path d="M24 40S6 29 6 16c0-9 11-11 18-1 7-10 18-8 18 1 0 13-18 24-18 24Z" />
                </svg>
                <p class="text-ink/80 text-xs leading-6">{{ $siteSettings->footer_thank_you_text }}</p>
            </div>
        @endif
    </div>

    <div
        class="text-ink/55 flex flex-col items-center gap-5 pt-6 text-center text-[11px] sm:flex-row sm:justify-between sm:text-left"
    >
        <div class="flex flex-col items-center gap-2 sm:items-start">
            <p>© {{ now()->year }} {{ $siteSettings->copyright_text ?: $siteSettings->site_name }}</p>
            <div class="flex gap-5">
                @if ($siteSettings->privacy_page_id)
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-forest">Privacy Policy</a>
                @endif

                @if ($siteSettings->terms_page_id)
                    <a href="{{ url('/terms-and-conditions') }}" class="hover:text-forest">Terms</a>
                @endif
            </div>
        </div>

        <a
            href="https://www.facebook.com/mmrtonmoy"
            target="_blank"
            rel="noopener noreferrer"
            class="focus-ring bg-forest hover:bg-pine shadow-paper group order-first inline-flex items-center gap-3 rounded-full px-4 py-2.5 text-white transition hover:-translate-y-0.5 sm:order-last"
            aria-label="Visit developer Moshiur Rahman's Facebook profile"
        >
            <span class="bg-coral grid h-8 w-8 place-items-center rounded-full" aria-hidden="true">
                <svg
                    class="h-4 w-4 stroke-current"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="m8 9-3 3 3 3M16 9l3 3-3 3M14 5l-4 14" />
                </svg>
            </span>
            <span class="text-left leading-tight">
                <span class="block text-[9px] font-semibold tracking-[0.16em] text-white/70 uppercase">
                    Developed by
                </span>
                <span class="mt-0.5 block text-xs font-bold">Moshiur Rahman</span>
            </span>
        </a>
    </div>
</footer>
