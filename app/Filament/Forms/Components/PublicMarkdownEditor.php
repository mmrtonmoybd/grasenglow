<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Support\Facades\Storage;

final class PublicMarkdownEditor extends MarkdownEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->fileAttachmentsDisk('public')
            ->fileAttachmentsDirectory('cms/markdown')
            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
            ->fileAttachmentsMaxSize(5120)
            ->toolbarButtons([
                ['bold', 'italic', 'strike', 'link'],
                ['heading'],
                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                ['table', 'attachFiles'],
                ['undo', 'redo'],
            ])
            ->minHeight('18rem')
            ->helperText('Markdown supported: **bold**, _italic_, # headings, - lists, [links](https://example.com). Use the image button to upload a picture (JPEG, PNG, WebP, or AVIF, maximum 5 MB), then type the alternative text between the square brackets it inserts.');
    }

    /**
     * Store root-relative attachment URLs for locally hosted files.
     *
     * The public disk builds its URLs from APP_URL, so an absolute URL written into
     * markdown breaks as soon as the scheme or domain changes. Remote disks keep
     * their absolute URLs because those are not served from this application.
     */
    public function getDefaultFileAttachmentUrl(mixed $file): ?string
    {
        if (! is_string($file) || $file === '') {
            return null;
        }

        $diskName = $this->getFileAttachmentsDiskName();

        if (config("filesystems.disks.{$diskName}.driver") !== 'local') {
            return null;
        }

        $url = rescue(fn (): ?string => Storage::disk($diskName)->url($file), null, report: false);

        if (! is_string($url) || $url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && $path !== '' ? $path : $url;
    }
}
