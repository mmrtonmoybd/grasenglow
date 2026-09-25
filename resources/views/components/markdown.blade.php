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
@endphp

@if ($markdownHtml !== '')
    <div {{ $attributes->class(['markdown-content']) }}>{!! $markdownHtml !!}</div>
@endif
