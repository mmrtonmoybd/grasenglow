<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

final class NewsletterController
{
    public function __invoke(StoreNewsletterSubscriptionRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => $request->string('email')->lower()->toString()],
            ['source_page' => $request->string('source_page')->toString(), 'subscribed_at' => now(), 'is_active' => true],
        );

        return back()->with('newsletter_success', 'Thank you for joining our journey.');
    }
}
