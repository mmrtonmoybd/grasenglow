<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;

final class PublicImageUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->disk('public')
            ->directory('cms')
            ->visibility('public')
            ->image()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
            ->maxSize(5120)
            ->imageEditor()
            ->helperText('JPEG, PNG, WebP, or AVIF. Maximum 5 MB. Add descriptive alternative text.');
    }
}
