<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ContactMessageStatus;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final readonly class ContactController
{
    public function __construct(private SeoService $seo) {}

    public function create(): View
    {
        $page = Page::query()->where('slug', 'contact')->published()->firstOrFail();

        return view('pages.contact', ['page' => $page, 'seo' => $this->seo->for($page)]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create([
            ...$request->safe()->except(['website']),
            'status' => ContactMessageStatus::New,
            'submitted_at' => now(),
        ]);

        return back()->with('contact_success', 'Thank you. Your message has been received.');
    }
}
