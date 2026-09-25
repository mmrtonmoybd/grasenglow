@props([
    'content' => null,
])

@php
    $markdownSource = trim((string) ($content ?? ''));
    $markdownHtml = $markdownSource === ''
        ? ''
        : \Illuminate\Support\Str::markdown($markdownSource, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

    /** Let uploaded images load lazily and decode off the main thread. */
    $markdownHtml = str_replace('<img src=', '<img loading="lazy" decoding="async" src=', $markdownHtml);
@endphp

@if ($markdownHtml !== '')
    <div {{ $attributes->class(['markdown-content']) }}>{!! $markdownHtml !!}</div>
@endif
