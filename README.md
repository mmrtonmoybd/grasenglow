# Grace & Glow

**Transforming Textile Waste into Hope** — the website and content management system for Grace & Glow, a Dhaka-based social enterprise that turns rescued textiles into handmade lifestyle products supporting people, animals, and the planet.

Built with Laravel 13, Filament 5, Livewire 4, and Tailwind CSS 4.

## Features

### Public website

- **Homepage** built from reorderable page sections and a hero carousel
- **Product catalog** with categories, collections, and image galleries
- **Impact** stories and metrics, **projects**, **research publications**, and **news** posts
- **CMS pages** at `/{slug}` with Markdown content and attachments
- **Contact form** and **newsletter signup**, both rate limited
- Announcement bar, configurable navigation menus, social links, FAQs, testimonials, partners, and artisan profiles
- SEO: meta tags, Open Graph, organization schema, `sitemap.xml`, `robots.txt`, and managed redirects
- Branded error pages

### Admin panel (`/admin`)

- Filament resources for all content types, plus users
- **Site Settings** page for branding (name, taglines, colors, fonts), contact details, announcement bar, and SEO defaults
- Dashboard widgets: content overview, recent contact messages, and access logs
- Role and permission management via Filament Shield
- Profile management via Filament Breezy
- Activity logging, global search modal, and a shadcn-styled theme

## Tech stack

| Layer    | Packages                                                 |
| -------- | -------------------------------------------------------- |
| Backend  | PHP 8.4, Laravel 13                                      |
| Admin    | Filament 5, Livewire 4, Filament Shield, Filament Breezy |
| Frontend | Blade, Tailwind CSS 4, Vite 7                            |
| Testing  | Pest 4                                                   |
| Tooling  | Laravel Pint, Prettier, Laravel Boost, Debugbar          |

## Getting started

### Requirements

- PHP 8.4+
- Composer
- Node.js and npm
- SQLite (default) or another database supported by Laravel

### Installation

```bash
git clone https://github.com/mmrtonmoybd/grasenglow.git
cd grasenglow

composer setup          # install deps, create .env, generate key, build assets
php artisan storage:link
php artisan project:init
```

`project:init` runs `migrate:fresh`, generates Shield permissions and policies, seeds the database, and makes user #1 a super admin.

> **Warning:** `project:init` drops all tables. Do not run it against a database with data you want to keep.

The default seeded admin account is `admin@admin.com`. Its password is `password` — change it right away.

### Import initial content (optional)

```bash
php artisan cms:import-grace-glow --source=/path/to/grace-glow
```

Imports settings, pages, navigation, homepage sections, and demo content from the supplied frontend design. It can be run more than once safely. Pass `--skip-public-downloads` to keep existing images instead of downloading them again.

### Run locally

```bash
composer dev
```

Starts the web server, queue listener, and Vite dev server together. Visit the site at `http://localhost:8000` and the admin panel at `http://localhost:8000/admin`.

## Artisan commands

| Command                                     | Purpose                                                              |
| ------------------------------------------- | -------------------------------------------------------------------- |
| `php artisan project:init`                  | Fresh migrate, generate permissions, seed, and assign super admin    |
| `php artisan project:update`                | Run new migrations and regenerate permissions after adding resources |
| `php artisan project:cache`                 | Clear and rebuild application caches                                 |
| `php artisan cms:import-grace-glow`         | Import initial Grace & Glow content and assets                       |
| `php artisan cms:refresh-publication-cache` | Refresh caches that can hold scheduled public content                |

## Testing and code style

```bash
composer test     # run the Pest test suite
composer lint     # check with Pint and Prettier
composer fix      # fix with Pint and Prettier
```

## Deployment

1. Set database credentials and `APP_URL` in `.env` (and `ASSET_PREFIX` if served from a sub-folder).
2. `composer install --no-dev --optimize-autoloader`
3. `php artisan migrate --force` (or `project:update`)
4. `php artisan storage:link`
5. `npm ci && npm run build`
6. `php artisan project:cache`

Run the scheduler (`php artisan schedule:run` every minute) so scheduled content goes live on time.

## Credits

Built on the [FilaStarter Kit](https://github.com/raugadh/fila-starter) by Ankit Kumar Singh.

## License

Released under the [MIT License](LICENSE.md).
