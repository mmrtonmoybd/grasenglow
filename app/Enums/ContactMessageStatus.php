<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ContactMessageStatus: string implements HasColor, HasLabel
{
    case New = 'new';
    case Read = 'read';
    case InProgress = 'in_progress';
    case Replied = 'replied';
    case Archived = 'archived';
    case Spam = 'spam';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::New => 'danger',
            self::Read => 'info',
            self::InProgress => 'warning',
            self::Replied => 'success',
            self::Archived, self::Spam => 'gray',
        };
    }
}
