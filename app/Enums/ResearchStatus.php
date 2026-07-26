<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ResearchStatus: string implements HasLabel
{
    case Planned = 'planned';
    case Ongoing = 'ongoing';
    case Submitted = 'submitted';
    case Published = 'published';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
