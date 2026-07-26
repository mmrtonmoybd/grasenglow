@props([
    'section',
    'products',
])

<section class="mx-auto max-w-[1450px] px-4 py-8 sm:px-6 lg:px-10">
    <h2 class="font-display text-forest text-3xl">{{ $section->heading }}</h2>
    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
