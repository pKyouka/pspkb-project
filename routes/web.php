<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Posts (must be before catch-all {slug})
Route::prefix('berita')->group(function () {
    Route::get('/', [FrontendPostController::class, 'index'])->name('posts.index');
    Route::get('/kategori/{slug}', [FrontendPostController::class, 'category'])->name('posts.category');
    Route::get('/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard.redirect');

    // Pages
    Route::resource('pages', PageController::class);
    Route::post('pages/{page}/publish', [PageController::class, 'publish'])->name('pages.publish');
    Route::post('pages/{page}/unpublish', [PageController::class, 'unpublish'])->name('pages.unpublish');

    // Posts
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    Route::post('posts/{post}/unpublish', [PostController::class, 'unpublish'])->name('posts.unpublish');

    // Categories
    Route::resource('categories', CategoryController::class)->except('show');

    // Tags
    Route::resource('tags', TagController::class)->except('show');

    // Media
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::get('media/library', [MediaController::class, 'library'])->name('media.library');
    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Banners
    Route::resource('banners', BannerController::class)->except('show');

    // Menus
    Route::resource('menus', MenuController::class)->except('edit');
    Route::get('menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::post('menus/{menuId}/items', [MenuController::class, 'addItem'])->name('menus.items.add');
    Route::put('menus/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
    Route::delete('menus/items/{item}', [MenuController::class, 'deleteItem'])->name('menus.items.delete');
    Route::post('menus/{menuId}/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Users
    Route::resource('users', UserController::class)->except('show');

    // Contact Messages
    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

// Redirect dashboard to admin dashboard for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';

// Pages catch-all must stay last so it does not swallow /admin and other fixed routes.
Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');
