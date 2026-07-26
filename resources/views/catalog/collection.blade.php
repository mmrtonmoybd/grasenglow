<x-layouts.public :seo="$seo">
    <section class="mx-auto max-w-[1450px] px-4 py-14 sm:px-6 lg:px-10">
        <nav class="text-ink/55 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('products.index') }}">Products</a>
            / {{ $collection->name }}
        </nav>
        <h1 class="font-display text-forest mt-5 text-5xl">{{ $collection->name }}</h1>
        @if ($collection->subtitle)
            <p class="font-script text-coral mt-2 text-3xl">{{ $collection->subtitle }}</p>
        @endif

        @if ($collection->description)
            <p class="text-ink/70 mt-5 max-w-3xl leading-7">{{ $collection->description }}</p>
        @endif

        <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p>No published products are currently listed in this collection.</p>
            @endforelse
        </div>
        <div class="mt-9">{{ $products->links() }}</div>
    </section>
</x-layouts.public>
