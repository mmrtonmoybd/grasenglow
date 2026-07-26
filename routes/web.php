<?php

declare(strict_types=1);

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product-categories/{productCategory:slug}', [ProductController::class, 'category'])->name('product-categories.show');
Route::get('/collections/{collection:slug}', [ProductController::class, 'collection'])->name('collections.show');

Route::get('/impact', [ContentController::class, 'impact'])->name('impact.index');
Route::get('/impact/{impactStory:slug}', [ContentController::class, 'impactStory'])->name('impact.show');
Route::get('/projects', [ContentController::class, 'projects'])->name('projects.index');
Route::get('/projects/{project:slug}', [ContentController::class, 'project'])->name('projects.show');
Route::get('/research', [ContentController::class, 'research'])->name('research.index');
Route::get('/research/{researchPublication:slug}', [ContentController::class, 'publication'])->name('research.show');
Route::get('/news', [ContentController::class, 'news'])->name('news.index');
Route::get('/news/{post:slug}', [ContentController::class, 'post'])->name('news.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');
Route::post('/newsletter', NewsletterController::class)->middleware('throttle:newsletter')->name('newsletter.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/{page:slug}', [PageController::class, 'show'])->name('page.show');
