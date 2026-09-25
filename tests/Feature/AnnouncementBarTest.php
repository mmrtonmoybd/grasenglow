<?php

declare(strict_types=1);

use App\Enums\AnnouncementTone;
use App\Enums\PageTemplate;
use App\Models\Page;
use App\Models\SiteSetting;

beforeEach(function (): void {
    SiteSetting::factory()->create();
    Page::factory()->create(['slug' => 'home', 'page_template' => PageTemplate::Homepage]);
});

function updateAnnouncement(array $attributes): void
{
    SiteSetting::query()->firstOrFail()->update($attributes);
}

it('hides the announcement bar while it is disabled', function () {
    updateAnnouncement([
        'display_announcement' => false,
        'announcement_text' => 'Site under construction',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertDontSee('Site under construction')
        ->assertDontSee('data-announcement-bar', false);
});

it('hides the announcement bar when no message has been written', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_text' => '   ',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertDontSee('data-announcement-bar', false);
});

it('renders the announcement bar with its tone, message and call to action', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_tone' => AnnouncementTone::Construction,
        'announcement_text' => 'Our website is **under construction** — pages are still being updated.',
        'announcement_url' => '/products',
        'announcement_button_label' => 'Browse products',
        'announcement_is_dismissible' => true,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('announcement-bar--construction', false)
        ->assertSee('<strong>under construction</strong>', false)
        ->assertSee('Browse products')
        ->assertSee('href="/products"', false)
        ->assertSee('data-announcement-dismiss', false);
});

it('omits the call to action when the link or label is missing', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_text' => 'Site maintenance in progress',
        'announcement_url' => '/products',
        'announcement_button_label' => null,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Site maintenance in progress')
        ->assertDontSee('announcement-bar__cta', false);
});

it('omits the dismiss control when the announcement is not dismissible', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_text' => 'Permanent notice',
        'announcement_is_dismissible' => false,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Permanent notice')
        ->assertDontSee('data-announcement-dismiss', false)
        ->assertDontSee('announcement-bar__close', false)
        ->assertDontSee('localStorage', false);
});

it('strips raw html from the announcement message', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_text' => 'Careful <script>alert(1)</script> now',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertDontSee('<script>alert(1)</script>', false);
});

it('changes the dismissal key when the announcement changes', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_text' => 'First notice',
    ]);

    $first = $this->get(route('home'))->assertSuccessful()->getContent();

    updateAnnouncement(['announcement_text' => 'Second notice']);

    $second = $this->get(route('home'))->assertSuccessful()->getContent();

    $extractKey = fn (string $html): string => str($html)->after('data-announcement-key="')->before('"')->toString();

    expect($extractKey($first))->not->toBe($extractKey($second));
});

it('persists the announcement presentation settings with their casts', function () {
    updateAnnouncement([
        'display_announcement' => 1,
        'announcement_text' => 'Tone check',
        'announcement_tone' => 'celebration',
        'announcement_is_dismissible' => 0,
    ]);

    $settings = SiteSetting::query()->firstOrFail()->fresh();

    expect($settings->announcement_tone)->toBe(AnnouncementTone::Celebration)
        ->and($settings->announcement_is_dismissible)->toBeFalse()
        ->and($settings->display_announcement)->toBeTrue();
});

it('renders the default under construction notice shipped with the site', function () {
    updateAnnouncement([
        'display_announcement' => true,
        'announcement_tone' => AnnouncementTone::Construction,
        'announcement_text' => 'Our new website is **under construction** — a few pages are still being stitched together. Everything here is live, so please explore.',
        'announcement_url' => '/products',
        'announcement_button_label' => 'Explore products',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Our new website is', false)
        ->assertSee('<strong>under construction</strong>', false)
        ->assertSee('still being stitched together', false)
        ->assertSee('Explore products');
});
