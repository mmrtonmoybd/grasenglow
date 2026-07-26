<?php

declare(strict_types=1);

namespace App\Providers;

use App\Policies\ActivityPolicy;
use App\Services\NavigationService;
use App\Services\SiteSettingsService;
use Filament\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Models\Activity;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        RateLimiter::for('contact', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip()));
        RateLimiter::for('newsletter', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip()));

        View::composer('components.layouts.public', function ($view): void {
            $navigation = app(NavigationService::class);

            $view->with([
                'siteSettings' => app(SiteSettingsService::class)->get(),
                'headerNavigation' => $navigation->for('header'),
                'footerQuickNavigation' => $navigation->for('footer-quick'),
                'footerHelpNavigation' => $navigation->for('footer-help'),
                'socialLinks' => $navigation->socialLinks(),
            ]);
        });
        Gate::policy(Activity::class, ActivityPolicy::class);
        Page::formActionsAlignment(Alignment::Right);
        Notifications::alignment(Alignment::End);
        Notifications::verticalAlignment(VerticalAlignment::End);
        Page::$reportValidationErrorUsing = function (ValidationException $exception): void {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();
        };
    }
}
