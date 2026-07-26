<?php

declare(strict_types=1);

use App\Enums\PageTemplate;
use App\Models\Page;
use App\Models\SiteSetting;

test('the application returns a successful response', function () {
    SiteSetting::factory()->create();
    Page::factory()->create(['slug' => 'home', 'page_template' => PageTemplate::Homepage]);

    $response = $this->get('/');

    $response->assertSuccessful();
});
