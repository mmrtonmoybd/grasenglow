@props([
    'settings',
])

@php
    $announcementText = trim((string) ($settings->announcement_text ?? ''));
@endphp

@if ($settings->display_announcement && $announcementText !== '')
    @php
        $tone = $settings->announcement_tone ?? \App\Enums\AnnouncementTone::Construction;
        $announcementUrl = trim((string) ($settings->announcement_url ?? ''));
        $announcementButtonLabel = trim((string) ($settings->announcement_button_label ?? ''));
        $hasAnnouncementCta = $announcementUrl !== '' && $announcementButtonLabel !== '';
        $isDismissible = (bool) ($settings->announcement_is_dismissible ?? true);
        $announcementKey =
            'gg.announcement.' .
            substr(sha1($tone->value . '|' . $announcementText . '|' . $announcementUrl . '|' . $announcementButtonLabel), 0, 12);
        $announcementHtml = \Illuminate\Support\Str::inlineMarkdown($announcementText, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    @endphp

    <aside
        class="announcement-bar announcement-bar--{{ $tone->value }}"
        role="region"
        aria-label="Site announcement"
        data-announcement-bar
        data-announcement-key="{{ $announcementKey }}"
    >
        <span class="announcement-bar__tape" aria-hidden="true"></span>
        <span class="announcement-bar__sheen" aria-hidden="true"></span>

        <div class="announcement-bar__inner">
            <span class="announcement-bar__badge" aria-hidden="true">
                <span class="announcement-bar__pulse"></span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-[18px] w-[18px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tone->iconPath() }}" />
                </svg>
            </span>

            <p class="announcement-bar__text">{!! $announcementHtml !!}</p>

            @if ($hasAnnouncementCta)
                <a href="{{ $announcementUrl }}" class="announcement-bar__cta focus-ring">
                    {{ $announcementButtonLabel }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif

            @if ($isDismissible)
                <button
                    type="button"
                    class="announcement-bar__close focus-ring"
                    data-announcement-dismiss
                    aria-label="Dismiss announcement"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </aside>

    @if ($isDismissible)
        <script>
            (function () {
                try {
                    var bar = document.currentScript.previousElementSibling
                    if (bar && window.localStorage.getItem(bar.dataset.announcementKey) === 'dismissed') {
                        bar.remove()
                    }
                } catch (error) {}
            })()
        </script>
    @endif
@endif
