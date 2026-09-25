<?php

declare(strict_types=1);

use App\Filament\Forms\Components\PublicMarkdownEditor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

it('stores markdown attachments publicly in the cms directory', function () {
    $editor = PublicMarkdownEditor::make('body');

    expect($editor->getFileAttachmentsDiskName())->toBe('public')
        ->and($editor->getFileAttachmentsDirectory())->toBe('cms/markdown')
        ->and($editor->getFileAttachmentsVisibility())->toBe('public')
        ->and($editor->getFileAttachmentsMaxSize())->toBe(5120)
        ->and($editor->getFileAttachmentsAcceptedFileTypes())
        ->toBe(['image/jpeg', 'image/png', 'image/webp', 'image/avif']);
});

it('offers the attachment button in the toolbar', function () {
    expect(Arr::flatten(PublicMarkdownEditor::make('body')->getToolbarButtons()))
        ->toContain('attachFiles');
});

it('writes root relative attachment urls so content survives a domain change', function () {
    Storage::fake('public');
    config()->set('app.url', 'https://gracenglow.org');

    Storage::disk('public')->put('cms/markdown/quilt.png', 'fake-image');

    expect(PublicMarkdownEditor::make('body')->getFileAttachmentUrl('cms/markdown/quilt.png'))
        ->toBe('/storage/cms/markdown/quilt.png');
});

it('leaves remote disk attachment urls absolute', function () {
    config()->set('filesystems.disks.cdn', [
        'driver' => 's3',
        'url' => 'https://cdn.example.com',
    ]);

    $editor = PublicMarkdownEditor::make('body')->fileAttachmentsDisk('cdn');

    expect($editor->getDefaultFileAttachmentUrl('cms/markdown/quilt.png'))->toBeNull();
});
