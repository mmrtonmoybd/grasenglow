<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

abstract class CmsModel extends Model
{
    use LogsActivity;

    final public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept([
                'email', 'secondary_email', 'phone', 'whatsapp_number', 'address_line_1',
                'address_line_2', 'map_url', 'message', 'internal_notes',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function booted(): void
    {
        static::creating(function (Model $model): void {
            if (Auth::check() && $model->isFillable('created_by')) {
                $model->setAttribute('created_by', Auth::id());
            }

            if (Auth::check() && $model->isFillable('updated_by')) {
                $model->setAttribute('updated_by', Auth::id());
            }
        });

        static::updating(function (Model $model): void {
            if ($model->isFillable('created_by') && $model->isDirty('created_by')) {
                $model->setAttribute('created_by', $model->getOriginal('created_by'));
            }

            if (Auth::check() && $model->isFillable('updated_by')) {
                $model->setAttribute('updated_by', Auth::id());
            }
        });

        $flushCaches = static function (): void {
            Cache::forget('cms.site-settings');
            Cache::forget('cms.navigation');
            Cache::forget('cms.social-links');
            Cache::forget('cms.homepage');
            Cache::forget('cms.sitemap');
            Cache::forget('cms.dashboard-counts');
        };

        static::saved($flushCaches);
        static::deleted($flushCaches);

        static::updated(function (Model $model): void {
            if (! $model->isDirty('slug')) {
                return;
            }

            $prefix = match ($model::class) {
                Page::class => '',
                Product::class => '/products',
                ProductCategory::class => '/product-categories',
                ProductCollection::class => '/collections',
                Post::class => '/news',
                Project::class => '/projects',
                ResearchPublication::class => '/research',
                ImpactStory::class => '/impact',
                default => null,
            };

            if ($prefix === null) {
                return;
            }

            Redirect::query()->updateOrCreate(
                ['old_path' => $prefix.'/'.$model->getOriginal('slug')],
                ['destination_url' => $prefix.'/'.$model->getAttribute('slug'), 'status_code' => 301, 'is_active' => true],
            );
        });
    }
}
