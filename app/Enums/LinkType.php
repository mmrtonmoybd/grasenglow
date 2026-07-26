<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LinkType: string implements HasLabel
{
    case Internal = 'internal';
    case External = 'external';
    case Anchor = 'anchor';
    case Page = 'page';
    case ProductCategory = 'product_category';
    case Collection = 'collection';
    case Project = 'project';
    case News = 'news';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
