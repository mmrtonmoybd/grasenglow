<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SectionType: string implements HasLabel
{
    case Hero = 'hero';
    case RichText = 'rich_text';
    case ImageText = 'image_text';
    case ImpactMetrics = 'impact_metrics';
    case ValuesGrid = 'values_grid';
    case ProductCategories = 'product_categories';
    case FeaturedProducts = 'featured_products';
    case FeaturedCollections = 'featured_collections';
    case BrandStory = 'brand_story';
    case Mission = 'mission';
    case ProcessSteps = 'process_steps';
    case Projects = 'projects';
    case Research = 'research';
    case News = 'news';
    case Testimonials = 'testimonials';
    case Faqs = 'faqs';
    case Gallery = 'gallery';
    case Artisans = 'artisans';
    case Partners = 'partners';
    case ContactCta = 'contact_cta';
    case CustomCta = 'custom_cta';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
