<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\HomepageService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

final readonly class HomeController
{
    public function __construct(
        private HomepageService $homepage,
        private SeoService $seo,
    ) {}

    public function __invoke(): View
    {
        $data = $this->homepage->data();

        return view('pages.home', [
            ...$data,
            'seo' => $this->seo->for($data['page']),
        ]);
    }
}
