<x-layouts.public :seo="$seo">
    <section class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[.8fr_1.2fr] lg:py-20">
        <div>
            <p class="font-script text-coral text-2xl">Let’s connect</p>
            <h1 class="font-display text-forest mt-2 text-5xl">{{ $page->title }}</h1>
            <x-markdown :content="$page->body" class="text-ink/75 mt-5 text-base leading-7" />
        </div>

        <form
            action="{{ route('contact.store') }}"
            method="post"
            class="bg-paper shadow-paper grid gap-5 rounded-[24px] p-6 sm:grid-cols-2 sm:p-8"
        >
            @csrf
            <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />
            <input type="hidden" name="source_page" value="{{ request()->path() }}" />

            @if (session('contact_success'))
                <p class="bg-sage/20 text-forest rounded-xl p-4 text-sm sm:col-span-2" role="status">
                    {{ session('contact_success') }}
                </p>
            @endif

            <div>
                <label for="name" class="text-ink text-sm font-semibold">Name</label>
                <input
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    maxlength="120"
                    class="focus-ring border-forest/15 mt-2 w-full rounded-xl border bg-white px-4 py-3"
                />
                @error('name')
                    <p class="mt-1 text-xs text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="contact-email" class="text-ink text-sm font-semibold">Email</label>
                <input
                    id="contact-email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    maxlength="255"
                    class="focus-ring border-forest/15 mt-2 w-full rounded-xl border bg-white px-4 py-3"
                />
                @error('email')
                    <p class="mt-1 text-xs text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone" class="text-ink text-sm font-semibold">
                    Phone
                    <span class="text-ink/50 font-normal">(optional)</span>
                </label>
                <input
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    maxlength="50"
                    class="focus-ring border-forest/15 mt-2 w-full rounded-xl border bg-white px-4 py-3"
                />
            </div>
            <div>
                <label for="subject" class="text-ink text-sm font-semibold">Subject</label>
                <input
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    required
                    maxlength="180"
                    class="focus-ring border-forest/15 mt-2 w-full rounded-xl border bg-white px-4 py-3"
                />
                @error('subject')
                    <p class="mt-1 text-xs text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="text-ink text-sm font-semibold">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="7"
                    required
                    maxlength="5000"
                    class="focus-ring border-forest/15 mt-2 w-full rounded-xl border bg-white px-4 py-3"
                >
{{ old('message') }}</textarea
                >
                @error('message')
                    <p class="mt-1 text-xs text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="focus-ring bg-forest hover:bg-pine w-fit rounded-full px-7 py-3.5 text-sm font-semibold text-white sm:col-span-2"
            >
                Send message →
            </button>
        </form>
    </section>
</x-layouts.public>
