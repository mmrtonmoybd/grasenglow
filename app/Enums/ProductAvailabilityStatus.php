<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductAvailabilityStatus: string implements HasLabel
{
    case InquiryOnly = 'inquiry_only';
    case Available = 'available';
    case MadeToOrder = 'made_to_order';
    case Unavailable = 'unavailable';

    public function getLabel(): string
    {
        return str($this->value)->headline()->toString();
    }
}
