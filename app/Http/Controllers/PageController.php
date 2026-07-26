<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

final readonly class PageController
{
    public function __construct(private SeoService $seo) {}

    public function show(Page $page): View
    {
        abort_unless($page->isPubliclyVisible(), 404);
        $page->load(['sections' => fn ($query) => $query->where('is_enabled', true)->orderBy('sort_order')]);

        return view('pages.show', [
            'page' => $page,
            'seo' => $this->seo->for($page),
            'faqs' => $page->page_template->value === 'faq'
                ? Faq::query()->where('is_active', true)->orderBy('sort_order')->get()
                : collect(),
        ]);
    }
}
