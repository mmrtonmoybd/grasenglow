<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ImpactStory;
use App\Models\Post;
use App\Models\Project;
use App\Models\ResearchPublication;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

final readonly class ContentController
{
    public function __construct(private SeoService $seo) {}

    public function news(): View
    {
        return $this->indexView(Post::class, 'content.news-index', 'posts', 'News');
    }

    public function post(Post $post): View
    {
        abort_unless($post->isPubliclyVisible(), 404);
        $post->load(['category', 'author:id,name']);

        return view('content.post', ['post' => $post, 'seo' => $this->seo->for($post)]);
    }

    public function projects(): View
    {
        return $this->indexView(Project::class, 'content.projects-index', 'projects', 'Projects');
    }

    public function project(Project $project): View
    {
        abort_unless(Project::query()->published()->whereKey($project->getKey())->exists(), 404);

        return view('content.project', ['project' => $project, 'seo' => $this->seo->for($project)]);
    }

    public function research(): View
    {
        return $this->indexView(ResearchPublication::class, 'content.research-index', 'publications', 'Research');
    }

    public function publication(ResearchPublication $researchPublication): View
    {
        abort_unless(ResearchPublication::query()->published()->whereKey($researchPublication->getKey())->exists(), 404);

        return view('content.research', ['publication' => $researchPublication, 'seo' => $this->seo->for($researchPublication)]);
    }

    public function impact(): View
    {
        return $this->indexView(ImpactStory::class, 'content.impact-index', 'stories', 'Impact');
    }

    public function impactStory(ImpactStory $impactStory): View
    {
        abort_unless($impactStory->isPubliclyVisible(), 404);

        return view('content.impact', ['story' => $impactStory, 'seo' => $this->seo->for($impactStory)]);
    }

    private function indexView(string $model, string $view, string $key, string $title): View
    {
        return view($view, [
            $key => $model::query()->published()->latest('published_at')->paginate(10),
            'seo' => $this->seo->for(fallbackTitle: $title),
        ]);
    }
}
