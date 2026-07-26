<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasPublicationStatus
{
    public function isPubliclyVisible(): bool
    {
        return in_array($this->status, [ContentStatus::Published, ContentStatus::Scheduled], true)
            && ($this->status === ContentStatus::Published && $this->published_at === null || $this->published_at?->isPast());
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query
            ->whereIn('status', [ContentStatus::Published, ContentStatus::Scheduled])
            ->where(function (Builder $query): void {
                $query
                    ->where(fn (Builder $query): Builder => $query->where('status', ContentStatus::Published)->whereNull('published_at'))
                    ->orWhere('published_at', '<=', now());
            });
    }
}
