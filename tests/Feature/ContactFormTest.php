<?php

declare(strict_types=1);

use App\Enums\PageTemplate;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

beforeEach(function (): void {
    SiteSetting::factory()->create();
    Page::factory()->create(['slug' => 'contact', 'title' => 'Contact Us', 'page_template' => PageTemplate::Contact]);
});

it('accepts a valid contact submission and stores it in the admin data layer', function () {
    $response = $this->post(route('contact.store'), [
        'name' => 'Grace Visitor',
        'email' => 'visitor@example.com',
        'subject' => 'Product inquiry',
        'message' => 'I would like to learn more about your work.',
        'source_page' => '/contact',
        'website' => '',
    ]);

    $response->assertRedirect()->assertSessionHas('contact_success');
    expect(ContactMessage::query()->where('email', 'visitor@example.com')->exists())->toBeTrue();
});

it('enforces required fields and valid email addresses', function () {
    $this->post(route('contact.store'), [
        'email' => 'not-an-email',
    ])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
});

it('enforces safe maximum lengths', function () {
    $this->post(route('contact.store'), [
        'name' => str_repeat('a', 121),
        'email' => 'visitor@example.com',
        'subject' => str_repeat('a', 181),
        'message' => str_repeat('a', 5001),
    ])->assertSessionHasErrors(['name', 'subject', 'message']);
});

it('rejects honeypot submissions', function () {
    $this->post(route('contact.store'), [
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'subject' => 'Spam',
        'message' => 'Spam content',
        'website' => 'https://spam.example',
    ])->assertSessionHasErrors(['website']);

    expect(ContactMessage::query()->count())->toBe(0);
});

it('rate limits repeated submissions', function () {
    $payload = [
        'name' => 'Visitor',
        'email' => 'visitor@example.com',
        'subject' => 'Question',
        'message' => 'A valid message',
        'website' => '',
    ];

    foreach (range(1, 5) as $attempt) {
        $this->post(route('contact.store'), $payload)->assertRedirect();
    }

    $this->post(route('contact.store'), $payload)->assertTooManyRequests();
});

it('keeps csrf protection in the web middleware group', function () {
    $middleware = Route::getRoutes()->getByName('contact.store')->gatherMiddleware();

    expect($middleware)->toContain('web');
});
