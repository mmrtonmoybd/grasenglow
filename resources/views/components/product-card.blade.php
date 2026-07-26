@props([
    'product',
])

<article class="border-forest/8 bg-paper shadow-card overflow-hidden rounded-[20px] border">
    @if ($product->featured_image)
        <a href="{{ route('products.show', $product) }}" class="block aspect-[4/3] overflow-hidden">
            <x-public-image
                :path="$product->featured_image"
                :alt="$product->featured_image_alt"
                width="640"
                height="480"
                class="h-full w-full object-cover transition duration-500 hover:scale-105"
            />
        </a>
    @endif

    <div class="p-5">
        <p class="text-forest/60 text-xs tracking-wider uppercase">{{ $product->category->name }}</p>
        <h2 class="font-display text-forest mt-1 text-2xl">
            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
        </h2>
        @if ($product->short_description)
            <p class="text-ink/70 mt-2 text-sm leading-6">{{ $product->short_description }}</p>
        @endif

        @if ($product->price !== null && $product->currency)
            <p class="text-forest mt-4 font-semibold">{{ $product->currency }} {{ $product->price }}</p>
        @else
            <p class="text-forest mt-4 text-sm font-semibold">Price available by enquiry</p>
        @endif
    </div>
</article>
