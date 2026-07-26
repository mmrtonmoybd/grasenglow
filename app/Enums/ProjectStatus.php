<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasLabel
{
    case Planned = 'planned';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
    case Paused = 'paused';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
