<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\HeroSlides\Schemas;

use App\Filament\Forms\Components\PublicImageUpload;
use App\Rules\SafeUrl;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('internal_name')->required()->maxLength(255),
                TextInput::make('eyebrow')->required()->maxLength(255),
                TextInput::make('heading')->required()->maxLength(255),
                TextInput::make('subheading')->required()->maxLength(255),
                Textarea::make('body')->required()->rows(4)->columnSpanFull(),
                PublicImageUpload::make('image')->required(),
                PublicImageUpload::make('mobile_image')->required(),
                TextInput::make('image_alt')->required()->maxLength(255)->columnSpanFull(),
                TextInput::make('primary_cta_label')->required()->maxLength(80),
                TextInput::make('primary_cta_url')->required()->rules([new SafeUrl]),
                TextInput::make('secondary_cta_label')->required()->maxLength(80),
                TextInput::make('secondary_cta_url')->required()->rules([new SafeUrl]),
                TextInput::make('duration_seconds')
                    ->required()
                    ->integer()
                    ->minValue(2)
                    ->maxValue(10)
                    ->default(3),
                TextInput::make('sort_order')->required()->integer()->minValue(0)->default(0),
                Toggle::make('is_enabled')->required()->default(true),
                TextInput::make('source_url')->required()->url()->maxLength(2048)->columnSpanFull(),
                TextInput::make('license')->required()->maxLength(120),
                TextInput::make('attribution')->required()->maxLength(255),
            ]);
    }
}
