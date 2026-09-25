@props([
    'section',
])

<section class="mx-auto max-w-[1450px] px-4 py-4 sm:px-6 lg:px-10">
    <div
        class="from-pine to-forest shadow-card grid items-center gap-5 rounded-[24px] bg-gradient-to-r px-5 py-5 text-white md:grid-cols-[1fr_1.15fr] md:px-8"
    >
        <div class="flex items-center gap-5">
            <span
                class="text-forest grid h-14 w-14 shrink-0 place-items-center rounded-full bg-[#e6d6af]"
                aria-hidden="true"
            >
                ✉
            </span>
            <div>
                <h2 class="font-display text-xl sm:text-2xl">{{ $section->heading }}</h2>
                <x-markdown :content="$section->body" class="mt-1 text-xs text-white/75 sm:text-sm" />
            </div>
        </div>
        <form class="flex min-w-0 flex-col gap-3 sm:flex-row" action="{{ route('newsletter.store') }}" method="post">
            @csrf
            <label class="sr-only" for="newsletter-email">Email address</label>
            <input
                id="newsletter-email"
                name="email"
                type="email"
                required
                maxlength="255"
                placeholder="Enter your email"
                class="focus-ring text-ink placeholder:text-ink/45 min-w-0 flex-1 rounded-full border border-white/20 bg-white px-6 py-3.5 text-sm"
            />
            <input type="text" name="company" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />
            <input type="hidden" name="source_page" value="{{ request()->path() }}" />
            <button
                type="submit"
                class="focus-ring bg-forest hover:text-forest inline-flex items-center justify-center rounded-full border border-white px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white"
            >
                Subscribe →
            </button>
        </form>
        @if (session('newsletter_success'))
            <p class="text-sm md:col-span-2" role="status">{{ session('newsletter_success') }}</p>
        @endif
    </div>
</section>
