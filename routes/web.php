<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HotelNewsController;
use App\Http\Controllers\EventActivityController;
use App\Http\Controllers\WhatsNewController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;


Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "✅ All cache (config, route, view, app) has been cleared.";
});

Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});
Route::prefix('accommodation')->name('room.')->controller(RoomController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'detail')->name('detail');
});
Route::prefix('facility')->name('facility.')->controller(FacilityController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'detail')->name('detail');
});
Route::get('/hotel-news', [HotelNewsController::class, 'index'])->name('hotel-news.index');
Route::prefix('event-activity')->name('event-activity.')->controller(EventActivityController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'detail')->name('detail');
});
Route::prefix('whats-new')->name('whats-new.')->controller(WhatsNewController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{slug}', 'detail')->name('detail');
});
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us.index');
Route::post('/contact-us', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact-us.send');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/{slug}', [LandingController::class, 'page'])
    ->name('page')
    ->where('slug', '[A-Za-z0-9\-]+');