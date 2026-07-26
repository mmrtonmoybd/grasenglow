<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Models\Artisan;
use App\Models\BrandValue;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\ImpactMetric;
use App\Models\ImpactStory;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\NewsletterSubscriber;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\Project;
use App\Models\Redirect;
use App\Models\ResearchPublication;
use App\Models\SocialLink;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

abstract class CmsResource extends Resource
{
    final public static function getNavigationGroup(): string|UnitEnum|null
    {
        return match (static::getModel()) {
            Page::class, PageSection::class, HeroSlide::class, NavigationMenu::class, NavigationItem::class, SocialLink::class => 'Website',
            Product::class, ProductCategory::class, ProductCollection::class, ProductImage::class => 'Products',
            Post::class, PostCategory::class, Faq::class, Testimonial::class => 'Content',
            ImpactMetric::class, ImpactStory::class, BrandValue::class, Artisan::class, Partner::class => 'Impact',
            Project::class, ResearchPublication::class => 'Projects & Research',
            ContactMessage::class, NewsletterSubscriber::class => 'Messages',
            Redirect::class => 'SEO',
            default => null,
        };
    }

    final public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return match (static::getModel()) {
            Page::class => Heroicon::OutlinedDocumentText,
            PageSection::class => Heroicon::OutlinedRectangleGroup,
            HeroSlide::class => Heroicon::OutlinedPhoto,
            NavigationMenu::class => Heroicon::OutlinedBars3,
            NavigationItem::class => Heroicon::OutlinedLink,
            SocialLink::class => Heroicon::OutlinedShare,
            Product::class => Heroicon::OutlinedShoppingBag,
            ProductCategory::class => Heroicon::OutlinedTag,
            ProductCollection::class => Heroicon::OutlinedSwatch,
            ProductImage::class => Heroicon::OutlinedPhoto,
            Post::class => Heroicon::OutlinedNewspaper,
            PostCategory::class => Heroicon::OutlinedTag,
            Faq::class => Heroicon::OutlinedQuestionMarkCircle,
            Testimonial::class => Heroicon::OutlinedChatBubbleLeftRight,
            ImpactMetric::class => Heroicon::OutlinedChartBar,
            ImpactStory::class => Heroicon::OutlinedBookOpen,
            BrandValue::class => Heroicon::OutlinedHeart,
            Artisan::class => Heroicon::OutlinedUserGroup,
            Partner::class => Heroicon::OutlinedBuildingOffice2,
            Project::class => Heroicon::OutlinedBriefcase,
            ResearchPublication::class => Heroicon::OutlinedAcademicCap,
            ContactMessage::class => Heroicon::OutlinedEnvelope,
            NewsletterSubscriber::class => Heroicon::OutlinedUsers,
            Redirect::class => Heroicon::OutlinedArrowUturnRight,
            default => Heroicon::OutlinedRectangleStack,
        };
    }

    final public static function getNavigationBadge(): ?string
    {
        if (static::getModel() === ContactMessage::class) {
            return (string) ContactMessage::query()->where('status', 'new')->count();
        }

        return null;
    }
}
