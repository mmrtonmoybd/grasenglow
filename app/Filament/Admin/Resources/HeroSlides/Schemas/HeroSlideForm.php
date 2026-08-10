<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\HeroSlides\Schemas;

use App\Filament\Forms\Components\PublicImageUpload;
use App\Rules\SafeUrl;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

final class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('internal_name')->required()->maxLength(255),
                TextInput::make('eyebrow')
                    ->label('Small label')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('heading')
                    ->label('Right panel heading (Select any text to apply colors & bold)')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'textColor', 'clearFormatting'],
                    ])
                    ->textColors(self::getRichEditorTextColors())
                    ->customTextColors()
                    ->required()
                    ->columnSpanFull(),
                Repeater::make('feature_items')
                    ->label('Right panel feature rows')
                    ->default([
                        [
                            'icon' => 'recycle',
                            'tone' => 'forest',
                            'title' => 'We collect textile waste',
                            'body' => 'We collect textile waste from local sources.',
                        ],
                        [
                            'icon' => 'scissors',
                            'tone' => 'rose',
                            'title' => 'We upcycle it into quilts, bags & more.',
                            'body' => 'We upcycle it into quilts, bags, and practical handmade pieces.',
                        ],
                        [
                            'icon' => 'paw',
                            'tone' => 'gold',
                            'title' => 'We support stray animals',
                            'body' => 'We support stray animals through food and medical care.',
                        ],
                    ])
                    ->schema([
                        Select::make('icon')
                            ->options([
                                'recycle' => 'Recycle',
                                'scissors' => 'Needle & thread',
                                'paw' => 'Paw',
                                'leaf' => 'Leaf',
                                'heart' => 'Heart',
                            ])
                            ->required(),
                        Select::make('tone')
                            ->options([
                                'forest' => 'Forest',
                                'rose' => 'Rose',
                                'gold' => 'Gold',
                            ])
                            ->required()
                            ->default('forest'),
                        TextInput::make('title')->required()->maxLength(255),
                        \Filament\Forms\Components\Textarea::make('body')->required()->rows(2)->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                RichEditor::make('closing_text')
                    ->label('Closing message (Select any text to apply colors & bold)')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'textColor', 'clearFormatting'],
                    ])
                    ->textColors(self::getRichEditorTextColors())
                    ->customTextColors()
                    ->columnSpanFull(),
                PublicImageUpload::make('image')->label('Left image')->required(),
                PublicImageUpload::make('mobile_image')->label('Mobile image')->required(),
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

    /**
     * @return array<string, TextColor>
     */
    private static function getRichEditorTextColors(): array
    {
        $colors = [
            'forest' => TextColor::make('Forest Green', '#2f5233'),
            'coral' => TextColor::make('Rose / Coral', '#d98a75'),
            'gold' => TextColor::make('Gold', '#b48a44'),
            'ink' => TextColor::make('Dark Ink', '#1e271f'),
        ];

        $shades = [300, 400, 500, 600, 700, 800, 900];

        foreach (Color::all() as $name => $palette) {
            foreach ($shades as $shade) {
                $color = $palette[$shade] ?? null;

                if (! filled($color)) {
                    continue;
                }

                $hexColor = str_starts_with($color, '#') ? $color : "#{$color}";

                $colors[Str::slug("{$name}-{$shade}")] = TextColor::make(
                    Str::title(str_replace('-', ' ', "{$name} {$shade}")),
                    $hexColor,
                );
            }
        }

        return $colors;
    }
}
