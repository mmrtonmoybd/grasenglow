<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Enums\AnnouncementTone;
use App\Filament\Forms\Components\PublicImageUpload;
use App\Models\Page as PageModel;
use App\Models\SiteSetting;
use App\Rules\HexColor;
use App\Rules\SafeUrl;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

final class SiteSettings extends Page
{
    /** @var array<string, mixed> */
    public array $data = [];

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.admin.pages.site-settings';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin')
            || auth()->user()?->can('View:SiteSettings')
            || app()->environment('local');
    }

    public function mount(): void
    {
        $this->form->fill(
            SiteSetting::query()->firstOrCreate(['singleton_key' => 'default'])->attributesToArray(),
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('Brand')->schema([
                            Section::make('Identity')->schema([
                                TextInput::make('site_name')->required()->maxLength(120),
                                TextInput::make('short_site_name')->maxLength(60),
                                TextInput::make('primary_tagline')->maxLength(180),
                                TextInput::make('secondary_tagline')->maxLength(180),
                                PublicImageUpload::make('logo'),
                                PublicImageUpload::make('dark_logo'),
                                PublicImageUpload::make('mobile_logo'),
                                PublicImageUpload::make('favicon'),
                            ])->columns(2),
                        ]),
                        Tab::make('Contact')->schema([
                            Section::make('Public contact information')->schema([
                                TextInput::make('email')->email()->maxLength(255),
                                TextInput::make('secondary_email')->email()->maxLength(255),
                                TextInput::make('phone')->tel()->maxLength(50),
                                TextInput::make('whatsapp_number')->maxLength(50),
                                TextInput::make('address_line_1')->maxLength(255),
                                TextInput::make('address_line_2')->maxLength(255),
                                TextInput::make('city')->maxLength(120),
                                TextInput::make('postal_code')->maxLength(40),
                                TextInput::make('country')->maxLength(120),
                                TextInput::make('map_url')->rule(new SafeUrl)->maxLength(2048),
                                Textarea::make('business_hours')->maxLength(1000)->columnSpanFull(),
                            ])->columns(2),
                        ]),
                        Tab::make('Theme')->schema([
                            Section::make('Validated theme controls')->schema([
                                ColorPicker::make('primary_color')->rule(new HexColor)->required(),
                                ColorPicker::make('secondary_color')->rule(new HexColor)->required(),
                                ColorPicker::make('accent_color')->rule(new HexColor)->required(),
                                ColorPicker::make('background_color')->rule(new HexColor)->required(),
                                ColorPicker::make('text_color')->rule(new HexColor)->required(),
                                Select::make('heading_font')->options([
                                    'Playfair Display' => 'Playfair Display',
                                    'DM Sans' => 'DM Sans',
                                    'Georgia' => 'Georgia',
                                ])->required(),
                                Select::make('body_font')->options([
                                    'DM Sans' => 'DM Sans',
                                    'Arial' => 'Arial',
                                    'Georgia' => 'Georgia',
                                ])->required(),
                            ])->columns(2),
                        ]),
                        Tab::make('Footer & announcement')->schema([
                            Toggle::make('display_announcement')
                                ->label('Show announcement bar')
                                ->helperText('Displays a site-wide banner above the header on every public page.')
                                ->live(),
                            Select::make('announcement_tone')
                                ->label('Announcement style')
                                ->options(AnnouncementTone::class)
                                ->default(AnnouncementTone::Construction->value)
                                ->required()
                                ->visible(fn (Get $get): bool => (bool) $get('display_announcement')),
                            TextInput::make('announcement_text')
                                ->label('Announcement message')
                                ->placeholder('Our website is under construction — some pages are still being updated.')
                                ->requiredWith('display_announcement')
                                ->maxLength(255)
                                ->visible(fn (Get $get): bool => (bool) $get('display_announcement'))
                                ->columnSpanFull(),
                            TextInput::make('announcement_url')
                                ->label('Announcement link (optional)')
                                ->rule(new SafeUrl)
                                ->maxLength(2048)
                                ->visible(fn (Get $get): bool => (bool) $get('display_announcement')),
                            TextInput::make('announcement_button_label')
                                ->label('Announcement button label (optional)')
                                ->requiredWith('announcement_url')
                                ->maxLength(80)
                                ->visible(fn (Get $get): bool => (bool) $get('display_announcement')),
                            Toggle::make('announcement_is_dismissible')
                                ->label('Visitors can dismiss it')
                                ->helperText('Dismissal is remembered per browser until the message changes.')
                                ->visible(fn (Get $get): bool => (bool) $get('display_announcement'))
                                ->columnSpanFull(),
                            Textarea::make('footer_description')->maxLength(1000),
                            Textarea::make('footer_thank_you_text')->maxLength(1000),
                            TextInput::make('copyright_text')->maxLength(255),
                            Select::make('privacy_page_id')
                                ->options(fn () => PageModel::query()->orderBy('title')->pluck('title', 'id'))
                                ->searchable(),
                            Select::make('terms_page_id')
                                ->options(fn () => PageModel::query()->orderBy('title')->pluck('title', 'id'))
                                ->searchable(),
                        ])->columns(2),
                        Tab::make('SEO')->schema([
                            TextInput::make('default_meta_title')->maxLength(70),
                            Textarea::make('default_meta_description')->maxLength(320),
                            Textarea::make('default_meta_keywords')->maxLength(1000),
                            PublicImageUpload::make('default_open_graph_image'),
                            TextInput::make('organization_schema_name')->maxLength(255),
                            Textarea::make('organization_schema_description')->maxLength(1000),
                            PublicImageUpload::make('organization_schema_logo'),
                            TextInput::make('canonical_domain')->url()->maxLength(2048),
                            Toggle::make('robots_index_enabled'),
                            Toggle::make('sitemap_enabled'),
                        ])->columns(2),
                        Tab::make('Integrations')->schema([
                            TextInput::make('google_analytics_id')->regex('/^G-[A-Z0-9]+$/')->maxLength(40),
                            TextInput::make('google_tag_manager_id')->regex('/^GTM-[A-Z0-9]+$/')->maxLength(40),
                            TextInput::make('search_console_verification')->maxLength(255),
                        ])->columns(2),
                    ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        abort_unless(self::canAccess(), 403);

        SiteSetting::query()->updateOrCreate(
            ['singleton_key' => 'default'],
            $this->form->getState(),
        );

        Notification::make()->title('Site settings saved')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save settings')
                ->action('save')
                ->keyBindings(['mod+s']),
        ];
    }
}
