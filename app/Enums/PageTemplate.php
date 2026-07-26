<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PageTemplate: string implements HasLabel
{
    case Homepage = 'homepage';
    case Standard = 'standard';
    case Contact = 'contact';
    case Faq = 'faq';
    case Products = 'products';
    case Impact = 'impact';
    case Projects = 'projects';
    case Research = 'research';
    case News = 'news';
    case Legal = 'legal';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
