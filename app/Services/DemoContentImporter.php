<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ContentStatus;
use App\Enums\ProductAvailabilityStatus;
use App\Enums\ProjectStatus;
use App\Enums\ResearchStatus;
use App\Enums\SectionType;
use App\Models\Artisan;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\ImpactStory;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\Project;
use App\Models\ResearchPublication;
use App\Models\Testimonial;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

final class DemoContentImporter
{
    public function __construct(private readonly HttpFactory $http) {}

    /**
     * @return array<string, array{url: string, source: string, license: string, attribution: string, alt: string}>
     */
    public static function imageManifest(): array
    {
        return [
            'kantha-baby' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Baby_Kantha.jpg/1920px-Baby_Kantha.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Baby_Kantha.jpg',
                'license' => 'CC BY-SA 3.0',
                'attribution' => 'Auyon / Wikimedia Commons',
                'alt' => 'Colorful traditional baby kantha with stitched motifs',
            ],
            'kantha-bed' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/6/64/Bed_Kantha.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Bed_Kantha.jpg',
                'license' => 'CC BY-SA 3.0',
                'attribution' => 'Auyon / Wikimedia Commons',
                'alt' => 'Traditional embroidered bed kantha spread',
            ],
            'kantha-museum' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Kantha_%28Quilt%29_LACMA_AC1994.131.1.jpg/1920px-Kantha_%28Quilt%29_LACMA_AC1994.131.1.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Kantha_(Quilt)_LACMA_AC1994.131.1.jpg',
                'license' => 'Public domain',
                'attribution' => 'Los Angeles County Museum of Art / Wikimedia Commons',
                'alt' => 'Historic Bengali kantha quilt with detailed figurative embroidery',
            ],
            'kantha-closeup' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Kantha_Closeup.jpg/1920px-Kantha_Closeup.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Kantha_Closeup.jpg',
                'license' => 'CC BY-SA 3.0',
                'attribution' => 'Auyon / Wikimedia Commons',
                'alt' => 'Close view of colorful hand stitching on a kantha textile',
            ],
            'kantha-artisan' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Nakshi_Kantha_craftswoman.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Nakshi_Kantha_craftswoman.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'Faizul Latif Chowdhury / Wikimedia Commons',
                'alt' => 'Nakshi kantha craftswoman working on embroidered cloth',
            ],
            'patchwork-quilt' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Patchwork_Quilt_In_Double_Irish_Chain_Pattern.jpg/1920px-Patchwork_Quilt_In_Double_Irish_Chain_Pattern.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Patchwork_Quilt_In_Double_Irish_Chain_Pattern.jpg',
                'license' => 'Public domain',
                'attribution' => 'Missouri History Museum / Wikimedia Commons',
                'alt' => 'Pink, black, and brown patchwork quilt in a chain pattern',
            ],
            'fabric-scraps' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Fabric_scraps.jpg/1920px-Fabric_scraps.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Fabric_scraps.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'Elinkorn / Wikimedia Commons',
                'alt' => 'Assorted colorful fabric scraps ready for creative reuse',
            ],
            'drying-fabric' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Drying_fabrics_under_the_sun.jpg/1920px-Drying_fabrics_under_the_sun.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Drying_fabrics_under_the_sun.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'Pinu Rahman / Wikimedia Commons',
                'alt' => 'Long lengths of colorful fabric drying outdoors in sunlight',
            ],
            'painted-saree' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Starry_Night_Painting_Saree_for_women.jpg/1920px-Starry_Night_Painting_Saree_for_women.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Starry_Night_Painting_Saree_for_women.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'Horitokibd / Wikimedia Commons',
                'alt' => 'Hand-painted blue cotton saree displayed on a mannequin',
            ],
            'table-cloth' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/Cloth%2C_table_%28AM_1992.250%29.jpg/1920px-Cloth%2C_table_%28AM_1992.250%29.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Cloth,_table_(AM_1992.250).jpg',
                'license' => 'CC BY 4.0',
                'attribution' => 'Auckland Museum / Wikimedia Commons',
                'alt' => 'Decorative handmade table cloth with a patterned border',
            ],
            'cushion' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1c/A_White_Butterflies_Cushion.jpg/1920px-A_White_Butterflies_Cushion.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:A_White_Butterflies_Cushion.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'D Eaketts / Wikimedia Commons',
                'alt' => 'Decorative textile cushion with butterfly motifs',
            ],
            'textile-recycling' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d2/T-REC_Textile_Recycling_project.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:T-REC_Textile_Recycling_project.jpg',
                'license' => 'CC BY-SA 3.0',
                'attribution' => 'Fabio Usvardi / Wikimedia Commons',
                'alt' => 'Textile recycling project display with recovered materials',
            ],
            'stray-dog' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Sleeping_stray_dog_in_Bangladesh.jpg/1920px-Sleeping_stray_dog_in_Bangladesh.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Sleeping_stray_dog_in_Bangladesh.jpg',
                'license' => 'CC BY-SA 4.0',
                'attribution' => 'A S M Jobaer / Wikimedia Commons',
                'alt' => 'A stray dog sleeping peacefully in Bangladesh',
            ],
            'woman-sewing' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Adivasi_%28Indigenous%29_Woman_Sewing_-_Chittagong_Hill_Tracts_-_Bangladesh_%2813185070435%29.jpg/1920px-Adivasi_%28Indigenous%29_Woman_Sewing_-_Chittagong_Hill_Tracts_-_Bangladesh_%2813185070435%29.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:Adivasi_(Indigenous)_Woman_Sewing_-_Chittagong_Hill_Tracts_-_Bangladesh_(13185070435).jpg',
                'license' => 'CC BY-SA 2.0',
                'attribution' => 'Adam Jones / Wikimedia Commons',
                'alt' => 'A woman sewing by hand in the Chittagong Hill Tracts',
            ],
            'craft-display' => [
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/A_colourful_display_of_handmade_textiles_and_crafts_in_a_shop_window%2C_featuring_hanging_fabric_fish_and_traditional_dolls._%2855242927741%29.jpg/1920px-A_colourful_display_of_handmade_textiles_and_crafts_in_a_shop_window%2C_featuring_hanging_fabric_fish_and_traditional_dolls._%2855242927741%29.jpg',
                'source' => 'https://commons.wikimedia.org/wiki/File:A_colourful_display_of_handmade_textiles_and_crafts_in_a_shop_window,_featuring_hanging_fabric_fish_and_traditional_dolls._(55242927741).jpg',
                'license' => 'CC BY 4.0',
                'attribution' => 'Michael Gaylard / Wikimedia Commons',
                'alt' => 'Colorful display of handmade textile crafts and fabric decorations',
            ],
        ];
    }

    public function import(bool $downloadImages = true): void
    {
        Cache::lock('cms.demo-content-import', 120)->block(10, function () use ($downloadImages): void {
            if ($downloadImages) {
                $this->downloadImages();
            }

            $this->importHeroSlides();
            $this->enrichPages();
            $this->importProducts();
            $this->importEditorialContent();
            $this->importProjectsAndResearch();
            $this->importReferenceProfiles();
        });

        Cache::forget('cms.homepage');
        Cache::forget('cms.sitemap');
        Cache::forget('cms.dashboard.content-overview');
    }

    private function downloadImages(): void
    {
        foreach (self::imageManifest() as $key => $image) {
            $path = $this->imagePath($key);

            if (Storage::disk('public')->exists($path)) {
                continue;
            }

            $response = $this->http
                ->withUserAgent('Mozilla/5.0 (compatible; GraceGlowCMS/1.0; public demo importer)')
                ->connectTimeout(10)
                ->timeout(30)
                ->retry([750, 1500, 3000])
                ->get($image['url'])
                ->throw();

            $contents = $response->body();
            $mimeType = mb_strtolower((string) $response->header('Content-Type'));

            if (! str_starts_with($mimeType, 'image/') || mb_strlen($contents, '8bit') > 10_000_000) {
                throw new RuntimeException("Invalid public image response for {$key}.");
            }

            if (getimagesizefromstring($contents) === false) {
                throw new RuntimeException("Downloaded data for {$key} is not a valid image.");
            }

            Storage::disk('public')->put($path, $contents);
        }
    }

    private function importHeroSlides(): void
    {
        $slides = [
            [
                'internal_name' => 'Circular textile story',
                'eyebrow' => 'Waste becomes possibility',
                'heading' => 'Every Scrap',
                'subheading' => 'Deserves a Second Life',
                'body' => 'Discover how careful sorting, thoughtful design, and handcraft can turn overlooked fabric into useful objects with lasting character.',
                'image_key' => 'fabric-scraps',
                'primary_cta_label' => 'Explore the Process',
                'primary_cta_url' => '/what-we-do',
                'secondary_cta_label' => 'Browse Products',
                'secondary_cta_url' => '/products',
                'duration_seconds' => 3,
            ],
            [
                'internal_name' => 'Kantha craft heritage',
                'eyebrow' => 'Crafted by hand',
                'heading' => 'Stories in',
                'subheading' => 'Every Stitch',
                'body' => 'Kantha traditions show how layers of cloth, patient stitching, and personal motifs can carry memory into a new generation.',
                'image_key' => 'kantha-artisan',
                'primary_cta_label' => 'Read the Craft Story',
                'primary_cta_url' => '/news/kantha-stitching-stories-into-cloth',
                'secondary_cta_label' => 'Our Collections',
                'secondary_cta_url' => '/collections/ronger-golpo',
                'duration_seconds' => 3,
            ],
            [
                'internal_name' => 'Compassion in action',
                'eyebrow' => 'A kinder everyday',
                'heading' => 'Made with',
                'subheading' => 'Purpose and Care',
                'body' => 'Grace & Glow connects responsible textile reuse with a wider commitment to kindness, local craft, and care for vulnerable animals.',
                'image_key' => 'stray-dog',
                'primary_cta_label' => 'See Our Mission',
                'primary_cta_url' => '/mission',
                'secondary_cta_label' => 'Explore Impact',
                'secondary_cta_url' => '/impact',
                'duration_seconds' => 3,
            ],
            [
                'internal_name' => 'Color and home',
                'eyebrow' => 'One of a kind',
                'heading' => 'Bring Home',
                'subheading' => 'Color with Meaning',
                'body' => 'Representative catalogue pieces demonstrate how reclaimed textiles can become quilts, table accents, cushions, art, and practical accessories.',
                'image_key' => 'craft-display',
                'primary_cta_label' => 'View the Catalogue',
                'primary_cta_url' => '/products',
                'secondary_cta_label' => 'Meet the Values',
                'secondary_cta_url' => '/about',
                'duration_seconds' => 3,
            ],
        ];

        foreach ($slides as $order => $slide) {
            $image = self::imageManifest()[$slide['image_key']];

            HeroSlide::query()->updateOrCreate(['internal_name' => $slide['internal_name']], [
                ...Arr::except($slide, 'image_key'),
                'image' => $this->imagePath($slide['image_key']),
                'mobile_image' => $this->imagePath($slide['image_key']),
                'image_alt' => $image['alt'],
                'source_url' => $image['source'],
                'license' => $image['license'],
                'attribution' => $image['attribution'],
                'sort_order' => ($order + 1) * 10,
                'is_enabled' => true,
            ]);
        }
    }

    private function enrichPages(): void
    {
        $pageDetails = [
            'home' => ['A complete demonstration of circular textiles, handmade craft, and compassionate purpose.', 'fabric-scraps'],
            'about' => ['Learn how Grace & Glow combines rescued textiles, careful design, handcraft, and a commitment to a more considerate future.', 'craft-display'],
            'mission' => ['Our mission joins textile reuse, meaningful handmade work, and care for vulnerable animals in one practical creative journey.', 'stray-dog'],
            'what-we-do' => ['From collecting and sorting remnants to washing, pairing, designing, cutting, stitching, finishing, and quality checks.', 'woman-sewing'],
            'products' => ['Explore a representative testing catalogue of quilts, sarees, table linens, cushions, textile art, and practical accessories.', 'kantha-bed'],
            'impact' => ['Explore verified public context about textile circularity alongside clearly labeled Grace & Glow demonstration content.', 'textile-recycling'],
            'projects' => ['Read about the ongoing Grace & Glow initiative and public reference projects advancing circular textile systems.', 'fabric-scraps'],
            'research' => ['A curated testing library of public UN, UNEP, and UNICEF resources about textiles, waste, and circularity.', 'drying-fabric'],
            'news' => ['Stories about kantha, textile reuse, circular design, care, and practical steps toward a more sustainable wardrobe and home.', 'kantha-closeup'],
            'contact' => ['Ask about products, collaborations, sourcing, craft processes, or the Grace & Glow sustainability journey.', 'craft-display'],
            'faq' => ['Clear answers about the representative catalogue, made-to-order enquiries, materials, care, imagery, and public-source demo content.', 'patchwork-quilt'],
            'privacy-policy' => ['This demonstration site stores contact-form and newsletter information only for responding to enquiries, managing subscriptions, securing the service, and improving the website. Information is not sold. You may request access, correction, or deletion through the contact form. Uploaded and public-source media retain their stated attribution. Production operators should replace this demonstration policy with locally reviewed terms before launch.', 'table-cloth'],
            'terms-and-conditions' => ['This website currently contains representative testing content. Catalogue entries marked as demonstrations are not confirmed inventory or binding offers. Prices, delivery dates, materials, and availability require written confirmation. Public reference material remains attributable to its source. Production operators should replace these demonstration terms with legally reviewed terms before accepting orders.', 'kantha-museum'],
        ];

        foreach ($pageDetails as $slug => [$body, $imageKey]) {
            $image = self::imageManifest()[$imageKey];

            Page::query()->where('slug', $slug)->update([
                'excerpt' => $body,
                'body' => $body,
                'hero_title' => str($slug)->replace('-', ' ')->title(),
                'hero_subtitle' => 'Grace & Glow — sustainable craft, documented with care.',
                'hero_description' => $body,
                'hero_image' => $this->imagePath($imageKey),
                'hero_image_alt' => $image['alt'],
                'primary_cta_label' => 'Explore Products',
                'primary_cta_url' => '/products',
                'secondary_cta_label' => 'Contact Grace & Glow',
                'secondary_cta_url' => '/contact',
                'open_graph_title' => str($slug)->replace('-', ' ')->title().' | Grace & Glow',
                'open_graph_description' => Str::limit($body, 300),
                'open_graph_image' => $this->imagePath($imageKey),
                'meta_description' => Str::limit($body, 300),
                'meta_keywords' => 'Grace & Glow, circular textiles, Bangladesh, handmade, textile reuse, sustainable craft',
                'schema_type' => $slug === 'faq' ? 'FAQPage' : 'WebPage',
            ]);
        }

        $home = Page::query()->where('slug', 'home')->firstOrFail();
        foreach ([
            SectionType::FeaturedProducts->value => ['Featured demonstration products', 'Representative catalogue pieces with complete material, craft, care, and sourcing notes.', 65],
            SectionType::FeaturedCollections->value => ['Explore the collections', 'Color-led textile stories bringing traditional inspiration into contemporary homes.', 68],
        ] as $type => [$heading, $body, $order]) {
            PageSection::query()->updateOrCreate(
                ['page_id' => $home->id, 'section_type' => $type],
                [
                    'internal_name' => $heading,
                    'heading' => $heading,
                    'body' => $body,
                    'sort_order' => $order,
                    'is_enabled' => true,
                ],
            );
        }
    }

    private function importProducts(): void
    {
        $products = [
            ['Demo Nakshi Kantha Story Quilt', 'Quilts', 'kantha-museum', 'Layered cotton textile inspired by Bengali kantha storytelling.', 'Reused cotton layers and cotton thread', 'Hand-guided running stitch and motif work', 'Preserves usable cloth through layering and repair-minded design', 'Gentle hand wash separately in cool water; dry flat in shade', 'Approx. 220 × 150 cm', 'Natural cotton with red, indigo, and ochre details'],
            ['Demo Ronger Golpo Baby Kantha', 'Quilts', 'kantha-baby', 'A bright lightweight kantha concept for a nursery or reading corner.', 'Soft cotton layers and cotton thread', 'Layered cloth secured with closely spaced hand stitching', 'Demonstrates extending the useful life of cotton remnants', 'Gentle hand wash; do not bleach; dry fully before storing', 'Approx. 100 × 80 cm', 'Multicolor folk-inspired motifs'],
            ['Demo Heritage Bed Kantha', 'Quilts', 'kantha-bed', 'A full-size textile concept centered on patient stitch and everyday utility.', 'Layered cotton cloth and cotton thread', 'Traditional-style quilting with all-over surface stitching', 'Encourages long use, repair, and textile appreciation', 'Air regularly; spot clean; hand wash only when necessary', 'Approx. 230 × 180 cm', 'Warm red, cream, green, and blue'],
            ['Demo Patchwork Reading Quilt', 'Quilts', 'patchwork-quilt', 'A graphic patchwork concept for beds, sofas, and quiet reading spaces.', 'Assorted reclaimed cotton pieces with a cotton backing', 'Machine-pieced blocks with hand-finished binding', 'Pairs smaller usable pieces to reduce cutting waste', 'Cold gentle wash; line dry; warm iron if required', 'Approx. 180 × 140 cm', 'Pink, black, brown, and cream'],
            ['Demo Chitrokatha Painted Saree', 'Sarees', 'painted-saree', 'A testing catalogue example of wearable textile art on cotton.', 'Cotton saree and fabric-safe pigments', 'Painted surface details finished by hand', 'Made-to-order presentation avoids speculative overproduction', 'Dry clean or follow final maker instructions supplied with the piece', 'Approx. 5.5 m', 'Deep blue with expressive painted color'],
            ['Demo Sun-Dried Color Table Runner', 'Table Linens', 'drying-fabric', 'A colorful table runner concept inspired by textiles drying in sunlight.', 'Recovered cotton strips and a cotton base', 'Pieced construction with reinforced topstitching', 'Uses narrow strips that may be unsuitable for larger pieces', 'Cold hand wash; reshape and dry flat', 'Approx. 180 × 35 cm', 'Bright pink, yellow, blue, and green'],
            ['Demo Heritage Table Cloth', 'Table Linens', 'table-cloth', 'A decorative table textile concept for thoughtful everyday gatherings.', 'Cotton cloth and decorative thread', 'Patterned borders with carefully finished edges', 'Designed for repeated use as an alternative to disposable table décor', 'Machine wash cold on gentle cycle; line dry', 'Approx. 140 × 140 cm', 'Cream with patterned border accents'],
            ['Demo Butterfly Accent Cushion', 'Home Décor', 'cushion', 'A decorative cushion concept that makes small areas of textile detail visible.', 'Cotton cover, recovered textile appliqué, reusable insert', 'Appliqué motifs and reinforced envelope closure', 'Removable cover supports cleaning and a longer useful life', 'Remove insert; cold gentle wash; dry flat', 'Approx. 45 × 45 cm', 'Neutral base with butterfly motifs'],
            ['Demo Patchwork Market Tote', 'Tote Bags', 'fabric-scraps', 'A sturdy everyday tote concept showing how small fabric pieces can work together.', 'Recovered cotton and canvas remnants', 'Patchwork exterior with reinforced handles and boxed corners', 'Turns varied offcuts into a reusable alternative to single-use bags', 'Spot clean or hand wash; air dry', 'Approx. 38 × 42 × 10 cm', 'Mixed colors; every arrangement is different'],
            ['Demo Color Story Zip Pouch', 'Fabric Accessories', 'kantha-closeup', 'A small organizer concept highlighting hand stitch and practical reuse.', 'Quilted cotton remnants, cotton lining, metal zipper', 'Hand-stitched outer panel with a machine-finished lining', 'Uses compact remnants efficiently and supports everyday reuse', 'Spot clean with mild soap; air dry fully', 'Approx. 22 × 14 cm', 'Red, yellow, blue, and green stitch details'],
            ['Demo Ronger Golpo Floor Mat', 'Floor Mats', 'craft-display', 'A soft floor-cloth concept designed for play corners and relaxed living.', 'Layered recovered cotton with a durable backing', 'Pieced surface, painted accents, and reinforced perimeter stitching', 'Offers a washable textile alternative to some synthetic play surfaces', 'Cold gentle wash; dry flat and completely', 'Approx. 150 × 100 cm', 'Joyful multicolor story pattern'],
            ['Demo Chitrokatha Sofa Throw', 'Sofa Throws', 'kantha-closeup', 'A light sofa throw concept combining reclaimed cloth and visible hand stitching.', 'Layered reclaimed cotton and cotton thread', 'Patchwork arrangement with rhythmic running stitch', 'Celebrates repair, layering, and long-term household use', 'Hand wash separately; dry in shade', 'Approx. 180 × 120 cm', 'Vibrant jewel tones'],
            ['Demo Recovered Textile Wall Panel', 'Textile Art', 'textile-recycling', 'A wall textile concept that makes material recovery part of the visual story.', 'Sorted textile remnants on a reusable fabric support', 'Layering, appliqué, stitch, and secured loose-edge composition', 'Keeps visual material value visible instead of hiding the recovery process', 'Dust gently; keep dry; avoid prolonged direct sunlight', 'Approx. 70 × 50 cm', 'Material-led mixed palette'],
        ];

        $collections = ProductCollection::query()->get()->keyBy('slug');

        foreach ($products as $order => [$name, $categoryName, $imageKey, $short, $materials, $craft, $sustainability, $care, $dimensions, $color]) {
            $category = ProductCategory::query()->where('name', $categoryName)->firstOrFail();
            $image = self::imageManifest()[$imageKey];
            $slug = Str::slug($name);
            $product = Product::query()->updateOrCreate(['slug' => $slug], [
                'product_category_id' => $category->id,
                'name' => $name,
                'sku' => 'DEMO-'.mb_str_pad((string) ($order + 1), 3, '0', STR_PAD_LEFT),
                'short_description' => $short,
                'description' => $short.' This record is representative testing content based on publicly documented textile techniques; confirm the final specification before any order.',
                'story' => 'Created as a complete CMS demonstration, this concept connects material awareness, useful design, and the visual language of handmade textiles.',
                'materials' => $materials,
                'craftsmanship_details' => $craft,
                'sustainability_details' => $sustainability,
                'animal_support_details' => 'Grace & Glow describes compassion for stray animals as part of its public mission. Any contribution attached to a future sale must be confirmed before purchase.',
                'care_instructions' => $care,
                'dimensions' => $dimensions,
                'weight' => null,
                'color_description' => $color,
                'price' => null,
                'compare_price' => null,
                'currency' => 'BDT',
                'availability_status' => ProductAvailabilityStatus::InquiryOnly,
                'stock_quantity' => null,
                'made_to_order' => true,
                'lead_time' => 'Confirm current lead time by enquiry',
                'inquiry_enabled' => true,
                'inquiry_button_label' => 'Enquire about this demonstration piece',
                'inquiry_url' => '/contact',
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'status' => ContentStatus::Published,
                'published_at' => now(),
                'is_featured' => $order < 6,
                'is_new' => true,
                'sort_order' => ($order + 1) * 10,
                'meta_title' => $name.' | Grace & Glow',
                'meta_description' => $short,
                'meta_keywords' => 'demo catalogue, handmade textile, reclaimed cotton, Bangladesh craft',
                'open_graph_title' => $name,
                'open_graph_description' => $short,
                'open_graph_image' => $this->imagePath($imageKey),
                'is_indexable' => true,
            ]);

            ProductImage::query()->updateOrCreate(
                ['product_id' => $product->id, 'image' => $this->imagePath($imageKey)],
                [
                    'alt_text' => $image['alt'],
                    'caption' => "{$image['attribution']} — {$image['license']} — {$image['source']}",
                    'sort_order' => 10,
                    'is_primary' => true,
                ],
            );

            $collection = $order % 2 === 0 ? $collections->get('ronger-golpo') : $collections->get('chitrokatha');
            $product->collections()->syncWithoutDetaching([$collection->id]);
        }

        foreach (ProductCategory::query()->orderBy('id')->get() as $index => $category) {
            $imageKey = array_keys(self::imageManifest())[$index % count(self::imageManifest())];
            $image = self::imageManifest()[$imageKey];
            $category->update([
                'description' => $category->short_description.' Browse complete representative entries with materials, process, care, dimensions, and enquiry guidance.',
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'banner_image' => $this->imagePath($imageKey),
                'banner_image_alt' => $image['alt'],
                'icon' => 'sparkles',
                'is_featured' => true,
                'show_when_empty' => true,
                'meta_keywords' => 'handmade textiles, reclaimed fabric, circular design',
                'open_graph_image' => $this->imagePath($imageKey),
            ]);
        }

        foreach ($collections->values() as $index => $collection) {
            $imageKey = $index % 2 === 0 ? 'craft-display' : 'kantha-closeup';
            $image = self::imageManifest()[$imageKey];
            $collection->update([
                'subtitle' => 'Representative collection for CMS testing',
                'cover_image' => $this->imagePath($imageKey),
                'cover_image_alt' => $image['alt'],
                'banner_image' => $this->imagePath($imageKey),
                'banner_image_alt' => $image['alt'],
                'sort_order' => ($index + 1) * 10,
                'is_featured' => true,
                'meta_keywords' => 'textile collection, handmade, circular craft',
                'open_graph_image' => $this->imagePath($imageKey),
            ]);
        }
    }

    private function importEditorialContent(): void
    {
        $categories = collect([
            'Craft & Heritage' => 'Stories about textile knowledge, kantha, stitch, and making.',
            'Circular Textiles' => 'Public-source context about reuse, recovery, waste prevention, and circular systems.',
            'Care & Community' => 'Practical notes connecting thoughtful consumption, community, and compassion.',
        ])->mapWithKeys(function (string $description, string $name): array {
            $category = PostCategory::query()->updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'description' => $description,
                'is_active' => true,
            ]);

            return [$name => $category];
        });

        $posts = [
            ['Kantha: Stitching Stories into Cloth', 'Craft & Heritage', 'kantha-artisan', 'Kantha shows how layers of reused cloth can become both useful and expressive.', 'Across Bengal, kantha is associated with layering old cloth and securing it with running stitch. The surface can carry geometric forms, plants, animals, and scenes from daily life. This testing article introduces the practice without claiming that the pictured maker works for Grace & Glow. Source context: Wikimedia Commons and the public Nakshi Kantha collection.', 'https://commons.wikimedia.org/wiki/Category:Nakshi_Kantha'],
            ['Why Circular Textile Systems Matter', 'Circular Textiles', 'textile-recycling', 'Circularity seeks to prevent waste and keep textile value in use for longer.', 'UNEP describes textiles as culturally and economically important while also linked to climate, biodiversity, pollution, and waste pressures. A circular approach considers design, material choice, longer use, reuse, repair, recovery, safer chemistry, and responsible end-of-life systems. Small craft businesses participate by valuing remnants and designing for usefulness.', 'https://www.unep.org/topics/chemicals-and-pollution-action/circularity-sectors/sustainable-and-circular-textiles'],
            ['A Public Look at Textile Waste in Bangladesh', 'Circular Textiles', 'drying-fabric', 'Bangladesh is part of international work to improve circularity in textile value chains.', 'United Nations material describes efforts in Bangladesh to support circular textile value chains through policy, collaboration, reuse, recycling, and responsible production. This article is a concise learning summary, not a report of Grace & Glow project results.', 'https://bangladesh.un.org/en/254808-circular-textile-value-chains-through-comprehensive-policy-approach-under-unido-led-project'],
            ['From Fabric Scraps to Useful Design', 'Circular Textiles', 'fabric-scraps', 'Sorting remnants by material, scale, strength, and color makes better reuse decisions possible.', 'A practical small-workshop flow begins with clean collection, careful sorting, washing where appropriate, drying, inspection, and grouping. Larger pieces may become panels; long narrow pieces can become borders or handles; smaller stable pieces can support appliqué and patchwork. Design should follow the material rather than force every scrap into the same outcome.', 'https://www.unep.org/interactives/zero-waste-101/'],
            ['Caring for Handmade Cotton Textiles', 'Craft & Heritage', 'kantha-closeup', 'Gentle care helps handmade textiles remain useful and beautiful for longer.', 'Check the maker instructions first. In general, avoid unnecessary washing, treat marks promptly, use mild detergent, avoid bleach, support wet weight, dry thoroughly in shade, and store clean textiles in a dry breathable place. Repair loose stitching early so a small issue does not become a larger tear.', 'https://www.si.edu/mci/english/learn_more/taking_care/care_textiles.html'],
            ['Compassion as Part of a Brand Mission', 'Care & Community', 'stray-dog', 'Grace & Glow publicly connects textile reuse with concern for stray animals.', 'The public Grace & Glow LinkedIn page describes a mission that brings sustainability and compassion together. This testing article reflects that stated direction while avoiding unverified claims about donations, meals, or treatment totals. Any commercial contribution should be stated precisely and documented before launch.', 'https://www.linkedin.com/company/grace-glow-sustainable'],
        ];

        foreach ($posts as $order => [$title, $category, $imageKey, $excerpt, $body, $source]) {
            $image = self::imageManifest()[$imageKey];
            Post::query()->updateOrCreate(['slug' => Str::slug($title)], [
                'post_category_id' => $categories[$category]->id,
                'title' => $title,
                'excerpt' => $excerpt,
                'body' => $body."\n\nPublic source: ".$source,
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'tags' => [Str::slug($category), 'public-source', 'demo-content'],
                'status' => ContentStatus::Published,
                'published_at' => now()->subDays(18 - ($order * 3)),
                'is_featured' => $order < 3,
                'meta_title' => $title.' | Grace & Glow',
                'meta_description' => $excerpt,
                'meta_keywords' => 'circular textiles, handmade craft, textile reuse, Bangladesh',
                'open_graph_title' => $title,
                'open_graph_description' => $excerpt,
                'open_graph_image' => $this->imagePath($imageKey),
                'is_indexable' => true,
            ]);
        }

        $faqs = [
            ['Catalogue', 'Are the products currently available?', 'The populated catalogue is representative testing content. Every item uses enquiry-only availability so Grace & Glow can confirm the final material, dimensions, lead time, price, and delivery before accepting an order.'],
            ['Catalogue', 'Why are there no fixed prices?', 'The public sources do not provide verified prices. The site therefore avoids inventing commercial information and directs visitors to enquire for a current quotation.'],
            ['Materials', 'What does reclaimed or rescued textile mean here?', 'It refers to usable cloth or remnants kept in circulation instead of being immediately discarded. The exact source and fibre content should be confirmed for each production item.'],
            ['Craft', 'What is kantha?', 'Kantha is a Bengali textile tradition associated with layering cloth and joining or decorating it with running stitch. Styles, uses, motifs, and regional practices vary.'],
            ['Care', 'How should handmade cotton textiles be cleaned?', 'Follow the item-specific instructions first. Gentle washing, mild detergent, shade drying, and prompt repair are generally safer than harsh treatment.'],
            ['Orders', 'Can a demonstration design be made to order?', 'Use the contact form to discuss it. A demonstration entry is inspiration and a CMS test record, not a promise that an identical item or fabric is available.'],
            ['Images', 'Where do the testing images come from?', 'The expanded catalogue uses openly licensed or public-domain images from Wikimedia Commons. Hero slides show creator, license, and source attribution.'],
            ['Impact', 'Are the displayed Grace & Glow impact numbers independently verified?', 'The original design supplied project metrics, but visitors should treat them as CMS content until the organization verifies and dates each figure. Public global statistics are kept separate in sourced articles and research records.'],
            ['Sustainability', 'Does using remnants make every product fully sustainable?', 'No single material choice proves complete sustainability. Durability, safe processing, labor, transport, packaging, use, repair, and end-of-life all matter.'],
            ['Contact', 'What information should an enquiry include?', 'Mention the item, intended use, approximate size, color preferences, location, timing, and any accessibility or care requirements. Do not send sensitive payment information through the contact form.'],
        ];

        foreach ($faqs as $order => [$category, $question, $answer]) {
            Faq::query()->updateOrCreate(['question' => $question], [
                'category' => $category,
                'answer' => $answer,
                'sort_order' => ($order + 1) * 10,
                'is_active' => true,
                'show_on_homepage' => $order < 4,
            ]);
        }
    }

    private function importProjectsAndResearch(): void
    {
        $projects = [
            ['textile-waste-optimization', 'Grace & Glow Textile-Waste Optimization Initiative', 'fabric-scraps', 'Ongoing demonstration of collection, sorting, preparation, design, and reuse workflows.', ProjectStatus::Ongoing, 'https://www.linkedin.com/company/grace-glow-sustainable'],
            ['reference-circular-textile-value-chains-bangladesh', 'Public Reference: Circular Textile Value Chains in Bangladesh', 'drying-fabric', 'A UNIDO-led public initiative supporting circularity in Bangladesh textile and garment value chains.', ProjectStatus::Ongoing, 'https://bangladesh.un.org/en/254808-circular-textile-value-chains-through-comprehensive-policy-approach-under-unido-led-project'],
            ['reference-unep-textile-initiative', 'Public Reference: UNEP Textile Initiative', 'textile-recycling', 'A public UNEP initiative supporting a just transition toward more sustainable and circular textile value chains.', ProjectStatus::Ongoing, 'https://www.unep.org/topics/chemicals-and-pollution-action/circularity-sectors/sustainable-and-circular-textiles'],
        ];

        foreach ($projects as $order => [$slug, $title, $imageKey, $description, $status, $url]) {
            $image = self::imageManifest()[$imageKey];
            Project::query()->updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'short_description' => $description,
                'description' => $description.' The record is included to make the demonstration CMS useful and traceable.',
                'objective' => 'Improve understanding and practical use of circular textile approaches without overstating unverified outcomes.',
                'methodology' => 'Review public documentation, identify material flows, document processes, and distinguish verified facts from representative demonstration content.',
                'results' => 'Ongoing. No final Grace & Glow performance result is claimed by this demonstration record.',
                'start_date' => now()->subMonths(3)->toDateString(),
                'end_date' => now()->addYear()->toDateString(),
                'status' => $status,
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'gallery' => [[
                    'image' => $this->imagePath($imageKey),
                    'alt' => $image['alt'],
                    'caption' => "{$image['attribution']} — {$image['license']}",
                ]],
                'partners' => $order === 0 ? 'No partner claimed in this demonstration record.' : 'Public reference source; inclusion does not imply partnership with Grace & Glow.',
                'external_url' => $url,
                'is_featured' => true,
                'published_at' => now(),
                'publication_status' => ContentStatus::Published,
                'meta_title' => $title.' | Grace & Glow',
                'meta_description' => $description,
                'meta_keywords' => 'circular textiles, Bangladesh, public reference, textile waste',
                'open_graph_image' => $this->imagePath($imageKey),
            ]);
        }

        $research = [
            ['sustainable-and-circular-textiles-unep', 'Sustainable and Circular Textiles', 'UN Environment Programme', 'UNEP Textile Initiative', 'textile-recycling', 'UNEP outlines sector-wide work on circular business models, standards, safer chemistry, life-cycle thinking, and evidence-based policy.', 'https://www.unep.org/topics/chemicals-and-pollution-action/circularity-sectors/sustainable-and-circular-textiles'],
            ['circular-textile-value-chains-bangladesh', 'Circular Textile Value Chains in Bangladesh', 'United Nations in Bangladesh and UNIDO', 'United Nations in Bangladesh', 'drying-fabric', 'A public overview of work supporting circularity through policy, collaboration, recycling, reuse, and responsible production.', 'https://bangladesh.un.org/en/254808-circular-textile-value-chains-through-comprehensive-policy-approach-under-unido-led-project'],
            ['child-rights-textile-waste-recycling-bangladesh', 'Child Rights and Textile Waste Recycling in Bangladesh', 'UNICEF Child Rights and Business', 'UNICEF', 'fabric-scraps', 'A public resource examining child-rights considerations in informal textile-waste recycling and the need for a just circular transition.', 'https://www.unicef.org/childrightsandbusiness/reports/child-rights-and-textile-waste-recycling-bangladesh'],
            ['zero-waste-101-textiles', 'Zero Waste 101: Textiles', 'UN Environment Programme', 'UNEP', 'patchwork-quilt', 'An accessible public overview connecting prevention, reduction, recycling, reuse, and life-cycle thinking to the textile waste challenge.', 'https://www.unep.org/interactives/zero-waste-101/'],
        ];

        foreach ($research as [$slug, $title, $authors, $publication, $imageKey, $abstract, $url]) {
            $image = self::imageManifest()[$imageKey];
            ResearchPublication::query()->updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'abstract' => $abstract,
                'authors' => $authors,
                'publication_name' => $publication,
                'publication_date' => now()->subYear()->toDateString(),
                'research_status' => ResearchStatus::Published,
                'external_url' => $url,
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'keywords' => 'textile waste, circular economy, Bangladesh, sustainability, public research',
                'publication_status' => ContentStatus::Published,
                'published_at' => now(),
                'meta_title' => $title.' | Research Library',
                'meta_description' => $abstract,
                'canonical_url' => $url,
                'open_graph_image' => $this->imagePath($imageKey),
            ]);
        }

        $primaryProject = Project::query()->where('slug', 'textile-waste-optimization')->firstOrFail();
        foreach ([
            ['learning-note-sorting-fabric-remnants', 'Learning Note: Sorting Fabric Remnants', 'fabric-scraps', 'Process learning', 'A practical demonstration of grouping recovered cloth by fibre, strength, scale, color, and possible use.'],
            ['learning-note-visible-mending-and-kantha', 'Learning Note: Visible Stitch and Kantha', 'kantha-closeup', 'Craft education', 'A sourced learning note about how visible running stitch can join layers, reinforce cloth, and carry decorative meaning.'],
            ['learning-note-compassionate-brand-purpose', 'Learning Note: Compassionate Brand Purpose', 'stray-dog', 'Community awareness', 'A carefully qualified note reflecting Grace & Glow’s public connection between textile reuse and concern for stray animals.'],
        ] as $order => [$slug, $title, $imageKey, $type, $body]) {
            $image = self::imageManifest()[$imageKey];
            ImpactStory::query()->updateOrCreate(['slug' => $slug], [
                'related_project_id' => $primaryProject->id,
                'title' => $title,
                'excerpt' => $body,
                'body' => $body.' This is representative educational content and does not claim a measured beneficiary outcome.',
                'beneficiary_type' => $type,
                'impact_date' => now()->subDays(($order + 1) * 14)->toDateString(),
                'featured_image' => $this->imagePath($imageKey),
                'featured_image_alt' => $image['alt'],
                'gallery' => [[
                    'image' => $this->imagePath($imageKey),
                    'alt' => $image['alt'],
                    'caption' => "{$image['attribution']} — {$image['license']}",
                ]],
                'is_featured' => true,
                'status' => ContentStatus::Published,
                'published_at' => now(),
                'meta_title' => $title.' | Grace & Glow',
                'meta_description' => $body,
                'meta_keywords' => 'learning note, circular textiles, public-source demo',
                'open_graph_image' => $this->imagePath($imageKey),
            ]);
        }
    }

    private function importReferenceProfiles(): void
    {
        foreach ([
            ['UNEP Textile Initiative', 'Public knowledge source — not a claimed partner', 'UN Environment Programme material used for sourced circular-textile context.', 'https://www.unep.org/topics/chemicals-and-pollution-action/circularity-sectors/sustainable-and-circular-textiles', 'Global'],
            ['United Nations in Bangladesh', 'Public knowledge source — not a claimed partner', 'Public material used to contextualize circular textile value-chain work in Bangladesh.', 'https://bangladesh.un.org/en/254808-circular-textile-value-chains-through-comprehensive-policy-approach-under-unido-led-project', 'Bangladesh'],
            ['UNICEF Child Rights and Business', 'Public knowledge source — not a claimed partner', 'Public research source for child-rights considerations in textile-waste recycling.', 'https://www.unicef.org/childrightsandbusiness/reports/child-rights-and-textile-waste-recycling-bangladesh', 'Global'],
        ] as $order => [$name, $type, $description, $website, $location]) {
            Partner::query()->updateOrCreate(['name' => $name], [
                'partner_type' => $type,
                'logo' => $this->imagePath('textile-recycling'),
                'logo_alt' => 'Decorative textile recycling reference image',
                'description' => $description.' Inclusion is attribution and does not imply endorsement or partnership.',
                'website' => $website,
                'location' => $location,
                'partnership_start_date' => now()->toDateString(),
                'is_featured' => false,
                'sort_order' => ($order + 1) * 10,
                'is_active' => true,
            ]);
        }

        Artisan::query()->updateOrCreate(['display_name' => 'Demonstration Artisan Profile'], [
            'role' => 'Kantha and textile craft profile placeholder',
            'biography' => 'This fully populated record demonstrates the artisan-profile CMS fields. It is not a Grace & Glow staff claim and must remain unpublished until a real artisan provides informed consent and approved biography text.',
            'photograph' => $this->imagePath('kantha-artisan'),
            'photograph_alt' => self::imageManifest()['kantha-artisan']['alt'],
            'quote' => 'Replace this demonstration record with an approved first-person quotation after consent.',
            'sort_order' => 10,
            'is_featured' => false,
            'is_active' => false,
            'consent_confirmed' => false,
        ]);

        Testimonial::query()->updateOrCreate(['name' => 'Demonstration Customer Record'], [
            'role' => 'Testing-only testimonial placeholder',
            'organization' => 'Not a real endorsement',
            'quote' => 'This populated record tests testimonial administration and must not be published as a customer statement.',
            'image' => $this->imagePath('craft-display'),
            'image_alt' => self::imageManifest()['craft-display']['alt'],
            'rating' => 5,
            'sort_order' => 10,
            'is_featured' => false,
            'is_active' => false,
            'consent_confirmed' => false,
        ]);
    }

    private function imagePath(string $key): string
    {
        return "grace-glow/public/{$key}.jpg";
    }
}
