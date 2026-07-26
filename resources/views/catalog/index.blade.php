<x-layouts.public :seo="$seo">
    <section class="mx-auto max-w-[1450px] px-4 py-14 sm:px-6 lg:px-10">
        <h1 class="font-display text-forest text-5xl sm:text-6xl">Our Products</h1>
        <nav class="mt-6 flex flex-wrap gap-2" aria-label="Product categories">
            @foreach ($categories as $category)
                <a
                    href="{{ route('product-categories.show', $category) }}"
                    class="focus-ring border-forest/15 text-forest hover:bg-forest rounded-full border px-4 py-2 text-sm hover:text-white"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>
        <div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="bg-paper text-ink/70 rounded-2xl p-6 sm:col-span-2 lg:col-span-3">
                    No products are published yet.
                </p>
            @endforelse
        </div>
        <div class="mt-9">{{ $products->links() }}</div>
    </section>
</x-layouts.public>
