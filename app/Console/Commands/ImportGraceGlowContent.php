<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\AnnouncementTone;
use App\Enums\ContentStatus;
use App\Enums\LinkType;
use App\Enums\PageTemplate;
use App\Enums\ProjectStatus;
use App\Enums\SectionType;
use App\Models\BrandValue;
use App\Models\ImpactMetric;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Services\DemoContentImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class ImportGraceGlowContent extends Command
{
    protected $signature = 'cms:import-grace-glow
        {--source=/home/tonmoy/web/grace-glow-tailwind/grace-glow : Path to the supplied frontend}
        {--skip-public-downloads : Keep existing public-source images instead of downloading them}';

    protected $description = 'Idempotently import the supplied Grace & Glow design assets and initial CMS content';

    public function handle(DemoContentImporter $demoContentImporter): int
    {
        $source = mb_rtrim((string) $this->option('source'), '/');

        if (! is_file($source.'/index.html')) {
            $this->error('The supplied frontend could not be found at '.$source);

            return self::FAILURE;
        }

        foreach (['hero.jpg', 'product-quilt.jpg', 'product-tote.jpg', 'product-decor.jpg'] as $asset) {
            $contents = file_get_contents($source.'/assets/'.$asset);

            if ($contents === false) {
                $this->error('Unable to read '.$asset);

                return self::FAILURE;
            }

            Storage::disk('public')->put('grace-glow/'.$asset, $contents);
        }

        $this->importSettings();
        $pages = $this->importPages();
        $this->importHomepageSections($pages['home']);
        $this->importMetrics();
        $this->importBrandValues();
        $this->importCategoriesAndCollections();
        $this->importNavigation();
        $this->importCommunityContent();
        $demoContentImporter->import(! $this->option('skip-public-downloads'));

        $this->info('Grace & Glow CMS content imported without duplicating existing records.');

        return self::SUCCESS;
    }

    private function importSettings(): void
    {
        SiteSetting::query()->updateOrCreate(['singleton_key' => 'default'], [
            'site_name' => 'Grace & Glow',
            'short_site_name' => 'Grace & Glow',
            'primary_tagline' => 'Transforming Textile Waste into Hope',
            'secondary_tagline' => 'Sustainable. Handmade. Purposeful.',
            'address_line_1' => 'Tajmahal Road',
            'address_line_2' => 'Mohammadpur',
            'city' => 'Dhaka',
            'postal_code' => '1207',
            'country' => 'Bangladesh',
            'map_url' => 'https://www.openstreetmap.org/search?query=Tajmahal%20Road%20Dhaka%201207',
            'business_hours' => 'Online enquiries are accepted at any time. Response times and in-person availability must be confirmed directly.',
            'display_announcement' => true,
            'announcement_text' => 'Our new website is **under construction** — a few pages are still being stitched together. Everything here is live, so please explore.',
            'announcement_url' => '/products',
            'announcement_button_label' => 'Explore products',
            'announcement_tone' => AnnouncementTone::Construction,
            'announcement_is_dismissible' => true,
            'footer_description' => 'Rescued textiles become handmade lifestyle products that support people, animals, and the planet.',
            'footer_thank_you_text' => 'Thank you for supporting sustainability and compassion. Together, we create hope.',
            'copyright_text' => 'Grace & Glow. All rights reserved.',
            'primary_color' => '#24462d',
            'secondary_color' => '#17381f',
            'accent_color' => '#d98a75',
            'background_color' => '#f5f0e7',
            'text_color' => '#1e271f',
            'heading_font' => 'Playfair Display',
            'body_font' => 'DM Sans',
            'default_meta_title' => 'Grace & Glow — Transforming Textile Waste into Hope',
            'default_meta_description' => 'Grace & Glow transforms rescued textile waste into handmade products that support people, animals, and the planet.',
            'default_meta_keywords' => 'Grace & Glow, Dhaka, circular textiles, handmade, kantha, textile reuse, sustainable craft',
            'default_open_graph_image' => 'grace-glow/public/craft-display.jpg',
            'organization_schema_name' => 'Grace & Glow',
            'organization_schema_description' => 'A Dhaka-based sustainable lifestyle initiative transforming rescued fabric into handmade products.',
            'organization_schema_logo' => 'grace-glow/public/craft-display.jpg',
            'robots_index_enabled' => true,
            'sitemap_enabled' => true,
        ]);
    }

    /** @return array<string, Page> */
    private function importPages(): array
    {
        $definitions = [
            'home' => ['Home', PageTemplate::Homepage, 'Grace & Glow transforms rescued textile waste into handmade products that support people, animals, and the planet.'],
            'about' => ['About Us', PageTemplate::Standard, 'Grace & Glow brings traditional craftsmanship and modern design together to turn rescued fabric into one-of-a-kind lifestyle products.'],
            'mission' => ['Our Mission', PageTemplate::Standard, 'Our mission is to reduce textile waste, create meaningful craft work, and sustain compassionate support for stray animals.'],
            'what-we-do' => ['What We Do', PageTemplate::Standard, 'We collect leftover fabric, sort it by color, size, and material, wash and prepare it, then work with artisans to create useful handmade pieces.'],
            'products' => ['Our Products', PageTemplate::Products, 'Explore handmade lifestyle products created from rescued and leftover fabric.'],
            'impact' => ['Impact', PageTemplate::Impact, 'Our work connects textile-waste diversion, women artisans, tailor-shop partnerships, and support for stray animals.'],
            'projects' => ['Projects', PageTemplate::Projects, 'Explore our textile-waste optimization and sustainability initiatives.'],
            'research' => ['Research', PageTemplate::Research, 'Follow ongoing work in textile-waste optimization and sustainable craftsmanship.'],
            'news' => ['News', PageTemplate::News, 'Updates from Grace & Glow.'],
            'contact' => ['Contact Us', PageTemplate::Contact, 'Send Grace & Glow a message.'],
            'faq' => ['Frequently Asked Questions', PageTemplate::Faq, 'Answers to common questions about Grace & Glow.'],
            'privacy-policy' => ['Privacy Policy', PageTemplate::Legal, null],
            'terms-and-conditions' => ['Terms and Conditions', PageTemplate::Legal, null],
        ];

        $pages = [];

        foreach ($definitions as $slug => [$title, $template, $body]) {
            $pages[$slug] = Page::query()->updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'navigation_label' => $title,
                'page_template' => $template,
                'excerpt' => $body,
                'body' => $body,
                'status' => ContentStatus::Published,
                'published_at' => now(),
                'meta_title' => $title.' | Grace & Glow',
                'meta_description' => $body,
                'is_indexable' => true,
            ]);
        }

        SiteSetting::query()->where('singleton_key', 'default')->update([
            'privacy_page_id' => $pages['privacy-policy']->id,
            'terms_page_id' => $pages['terms-and-conditions']->id,
        ]);

        return $pages;
    }

    private function importHomepageSections(Page $home): void
    {
        $sections = [
            SectionType::Hero->value => [
                'internal_name' => 'Homepage hero',
                'eyebrow' => 'Sustainable. Handmade. Purposeful.',
                'heading' => 'Transforming Textile Waste',
                'subheading' => 'into Hope',
                'body' => 'Every rescued fabric helps protect our planet, and every handcrafted creation helps feed, treat, and care for stray animals.',
                'image' => 'grace-glow/hero.jpg',
                'mobile_image' => 'grace-glow/hero.jpg',
                'image_alt' => 'Patchwork quilt, handmade tote bag, and rescued dog',
                'primary_cta_label' => 'Our Story',
                'primary_cta_url' => '/about',
                'secondary_cta_label' => 'Our Impact',
                'secondary_cta_url' => '/impact',
                'sort_order' => 10,
            ],
            SectionType::ImpactMetrics->value => [
                'internal_name' => 'Homepage impact metrics',
                'heading' => 'Our Impact So Far',
                'body' => 'Every purchase makes a difference. Thank you for being part of our journey.',
                'sort_order' => 20,
            ],
            SectionType::BrandStory->value => [
                'internal_name' => 'Homepage brand story',
                'heading' => 'It started with compassion. It continues with purpose.',
                'body' => 'As an animal lover, I always wanted to do more for stray animals. When I saw how much leftover fabric was wasted in tailor shops, an idea came to life.',
                'image' => 'grace-glow/public/woman-sewing.jpg',
                'image_alt' => 'A woman sewing by hand in the Chittagong Hill Tracts',
                'primary_cta_label' => 'Read Our Story',
                'primary_cta_url' => '/about',
                'sort_order' => 30,
            ],
            SectionType::Mission->value => [
                'internal_name' => 'Homepage mission',
                'heading' => 'The Reason Behind Grace & Glow',
                'body' => 'Grace & Glow was born to turn waste into wonderful creations, creating a sustainable source of income to help feed, treat, and protect stray animals.',
                'primary_cta_label' => 'Our Mission',
                'primary_cta_url' => '/mission',
                'sort_order' => 40,
            ],
            SectionType::ValuesGrid->value => [
                'internal_name' => 'Homepage brand values',
                'heading' => 'What Guides Us',
                'sort_order' => 50,
            ],
            SectionType::ProductCategories->value => [
                'internal_name' => 'Homepage product categories',
                'heading' => 'Our Handmade Creations',
                'body' => 'Thoughtful designs. Timeless pieces. Made from leftovers, made with love.',
                'primary_cta_label' => 'Explore All Products',
                'primary_cta_url' => '/products',
                'sort_order' => 60,
            ],
            SectionType::ContactCta->value => [
                'internal_name' => 'Homepage newsletter',
                'heading' => 'Stay connected with our journey',
                'body' => 'Get updates on our impact, new products, and ways to help.',
                'sort_order' => 70,
            ],
        ];

        foreach ($sections as $type => $attributes) {
            PageSection::query()->updateOrCreate(
                ['page_id' => $home->id, 'section_type' => $type],
                [...$attributes, 'is_enabled' => true],
            );
        }
    }

    private function importMetrics(): void
    {
        $metrics = [
            ['Fabric waste diverted from landfill', 450, '450+', 'KG', 'Fabric waste diverted from landfill', 'recycle'],
            ['Quilts and products created', 160, '160+', null, 'Quilts and products created', 'quilt'],
            ['Tote bags made', 250, '250+', null, 'Tote bags made', 'bag'],
            ['Tailor shops partnered', 18, '18+', null, 'Tailor shops partnered', 'shop'],
            ['Women artisans supported', 9, '9+', null, 'Women artisans supported', 'people'],
            ['Meals provided to stray animals', 1200, '1,200+', null, 'Meals provided to stray animals', 'paw'],
            ['Veterinary treatments supported', 52, '52+', null, 'Veterinary treatments supported', 'heart'],
        ];

        foreach ($metrics as $order => [$title, $number, $display, $unit, $description, $icon]) {
            ImpactMetric::query()->updateOrCreate(['title' => $title], [
                'numeric_value' => $number,
                'display_value' => $display,
                'unit' => $unit,
                'description' => $description,
                'icon' => $icon,
                'sort_order' => ($order + 1) * 10,
                'is_active' => true,
            ]);
        }
    }

    private function importBrandValues(): void
    {
        $values = [
            'Sustainable' => 'We reduce textile waste and protect our environment.',
            'Handmade' => 'Every piece is crafted with care and attention to detail.',
            'Empowering' => 'We support women artisans and create meaningful work.',
            'Compassionate' => 'Our work helps sustain food and veterinary support for stray animals.',
        ];

        foreach ($values as $order => $description) {
            $title = array_search($description, $values, true);
            BrandValue::query()->updateOrCreate(['title' => $title], [
                'description' => $description,
                'icon' => match ($title) {
                    'Sustainable' => 'leaf',
                    'Handmade' => 'hand',
                    'Empowering' => 'people',
                    default => 'heart',
                },
                'sort_order' => (array_search($title, array_keys($values), true) + 1) * 10,
                'is_active' => true,
            ]);
        }
    }

    private function importCategoriesAndCollections(): void
    {
        $categories = [
            'Quilts' => ['Cozy. Colorful. Conscious.', 'grace-glow/product-quilt.jpg', 'Handmade patchwork quilts'],
            'Tote Bags' => ['Stylish. Strong. Sustainable.', 'grace-glow/product-tote.jpg', 'Handmade patchwork tote bags'],
            'Home Décor' => ['Beautiful pieces for a better tomorrow.', 'grace-glow/product-decor.jpg', 'Handmade patchwork cushion'],
            'Sarees' => ['Hand-painted cotton sarees.', null, null],
            'Table Linens' => ['Table linens shaped by sustainable craftsmanship.', null, null],
            'Fabric Accessories' => ['One-of-a-kind accessories made from rescued fabric.', null, null],
            'Floor Mats' => ['Cotton floor mats made with thoughtful reuse.', null, null],
            'Sofa Throws' => ['Patchwork throws combining traditional craft and modern design.', null, null],
            'Textile Art' => ['Textile art made from many colors and rescued materials.', null, null],
        ];

        foreach ($categories as $order => $definition) {
            [$description, $image, $alt] = $definition;
            $name = array_search($definition, $categories, true);
            ProductCategory::query()->updateOrCreate(['slug' => str($name)->slug()], [
                'name' => $name,
                'short_description' => $description,
                'featured_image' => $image,
                'featured_image_alt' => $alt,
                'sort_order' => (array_search($name, array_keys($categories), true) + 1) * 10,
                'is_featured' => $image !== null,
                'is_active' => true,
                'show_when_empty' => $image !== null,
                'meta_title' => $name.' | Grace & Glow',
                'meta_description' => $description,
            ]);
        }

        foreach ([
            'Ronger Golpo' => 'Stories of Many Colors, shaped through rescued textiles and sustainable craftsmanship.',
            'Chitrokatha' => 'A collection informed by textile art, patchwork, and one-of-a-kind making.',
        ] as $name => $description) {
            ProductCollection::query()->updateOrCreate(['slug' => str($name)->slug()], [
                'name' => $name,
                'short_description' => $description,
                'description' => $description,
                'status' => ContentStatus::Published,
                'published_at' => now(),
                'meta_title' => $name.' | Grace & Glow',
                'meta_description' => $description,
            ]);
        }
    }

    private function importNavigation(): void
    {
        $menus = [
            'header' => ['Header', [
                ['Home', '/'], ['About Us', '/about'], ['Our Mission', '/mission'], ['What We Do', '/what-we-do'],
                ['Our Products', '/products'], ['Impact', '/impact'], ['Projects & Research', '/projects'],
                ['News', '/news'], ['Contact Us', '/contact'],
            ]],
            'footer-quick' => ['Footer Quick Links', [
                ['About Us', '/about'], ['Our Mission', '/mission'], ['What We Do', '/what-we-do'],
                ['Our Products', '/products'], ['Impact', '/impact'], ['Projects & Research', '/projects'],
            ]],
            'footer-help' => ['Footer Help', [
                ['News', '/news'], ['Contact Us', '/contact'], ['FAQs', '/faq'],
            ]],
        ];

        foreach ($menus as $location => [$name, $items]) {
            $menu = NavigationMenu::query()->updateOrCreate(['location' => $location], ['name' => $name, 'is_active' => true]);

            foreach ($items as $order => [$label, $url]) {
                NavigationItem::query()->updateOrCreate(
                    ['navigation_menu_id' => $menu->id, 'label' => $label],
                    [
                        'link_type' => LinkType::Internal,
                        'link_value' => $url,
                        'sort_order' => ($order + 1) * 10,
                        'is_active' => true,
                        'show_on_desktop' => true,
                        'show_on_mobile' => true,
                    ],
                );
            }
        }
    }

    private function importCommunityContent(): void
    {
        SocialLink::query()->updateOrCreate(['platform' => 'linkedin'], [
            'label' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/company/grace-glow-sustainable',
            'icon' => 'linkedin',
            'sort_order' => 10,
            'is_active' => true,
            'open_in_new_tab' => true,
        ]);

        Project::query()->updateOrCreate(['slug' => 'textile-waste-optimization'], [
            'title' => 'Textile-Waste Optimization Initiative',
            'short_description' => 'An ongoing initiative exploring responsible collection, sorting, preparation, and use of leftover fabric.',
            'description' => 'Grace & Glow is working on textile-waste optimization through the collection of leftover fabric, sorting by color, size, and material, washing and preparation, and sustainable craftsmanship.',
            'objective' => 'Improve the useful recovery of leftover textile material while supporting sustainable craft practice.',
            'status' => ProjectStatus::Ongoing,
            'publication_status' => ContentStatus::Published,
            'published_at' => now(),
            'is_featured' => true,
            'meta_title' => 'Textile-Waste Optimization Initiative | Grace & Glow',
            'meta_description' => 'An ongoing Grace & Glow textile-waste optimization initiative.',
        ]);
    }
}
