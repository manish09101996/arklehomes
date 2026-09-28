<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SeoController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectManagerController;
use App\Http\Controllers\Admin\CategoryManagerController;
use App\Http\Controllers\Admin\PageManagerController;
use App\Http\Controllers\Admin\TestimonialManagerController;
use App\Http\Controllers\Admin\ServiceManagerController;
use App\Http\Controllers\Admin\StatisticManagerController;
use App\Http\Controllers\Admin\FaqManagerController;
use App\Http\Controllers\Admin\EnquiryManagerController;
use App\Http\Controllers\Admin\MenuManagerController;
use App\Http\Controllers\Admin\HeaderFooterManagerController;
use App\Http\Controllers\Admin\MediaManagerController;
use App\Http\Controllers\Admin\SeoManagerController;
use App\Http\Controllers\Admin\SettingManagerController;
use App\Http\Controllers\Admin\UserManagerController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/design', [PageController::class, 'design'])->name('design');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit')->middleware('throttle:10,1');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/privacy', [PageController::class, 'privacy']);
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/terms', [PageController::class, 'terms']);

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Projects Management
    Route::get('/projects', [ProjectManagerController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectManagerController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectManagerController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectManagerController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectManagerController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectManagerController::class, 'destroy'])->name('projects.destroy');
    Route::post('/projects/{project}/duplicate', [ProjectManagerController::class, 'duplicate'])->name('projects.duplicate');
    Route::post('/projects/{project}/toggle-featured', [ProjectManagerController::class, 'toggleFeatured'])->name('projects.toggle-featured');
    Route::post('/projects/{project}/toggle-published', [ProjectManagerController::class, 'togglePublished'])->name('projects.toggle-published');
    Route::delete('/projects/images/{image}', [ProjectManagerController::class, 'deleteImage'])->name('projects.images.delete');

    // Categories
    Route::get('/categories', [CategoryManagerController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryManagerController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryManagerController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryManagerController::class, 'destroy'])->name('categories.destroy');

    // Pages & Section Builder
    Route::get('/pages', [PageManagerController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [PageManagerController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageManagerController::class, 'update'])->name('pages.update');
    Route::post('/pages/{page}/sections', [PageManagerController::class, 'addSection'])->name('pages.sections.add');
    Route::put('/pages/sections/{section}', [PageManagerController::class, 'updateSection'])->name('pages.sections.update');
    Route::delete('/pages/sections/{section}', [PageManagerController::class, 'deleteSection'])->name('pages.sections.delete');
    Route::post('/pages/sections/{section}/toggle', [PageManagerController::class, 'toggleSection'])->name('pages.sections.toggle');

    // Testimonials
    Route::get('/testimonials', [TestimonialManagerController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialManagerController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [TestimonialManagerController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialManagerController::class, 'destroy'])->name('testimonials.destroy');

    // Services / Feature Cards
    Route::get('/services', [ServiceManagerController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceManagerController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceManagerController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceManagerController::class, 'destroy'])->name('services.destroy');

    // Statistics / Counters
    Route::get('/statistics', [StatisticManagerController::class, 'index'])->name('statistics.index');
    Route::post('/statistics', [StatisticManagerController::class, 'store'])->name('statistics.store');
    Route::put('/statistics/{statistic}', [StatisticManagerController::class, 'update'])->name('statistics.update');
    Route::delete('/statistics/{statistic}', [StatisticManagerController::class, 'destroy'])->name('statistics.destroy');

    // FAQs
    Route::get('/faqs', [FaqManagerController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [FaqManagerController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [FaqManagerController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqManagerController::class, 'destroy'])->name('faqs.destroy');

    // Contact Enquiries
    Route::get('/enquiries', [EnquiryManagerController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/export', [EnquiryManagerController::class, 'exportCsv'])->name('enquiries.export');
    Route::get('/enquiries/{enquiry}', [EnquiryManagerController::class, 'show'])->name('enquiries.show');
    Route::put('/enquiries/{enquiry}', [EnquiryManagerController::class, 'updateStatus'])->name('enquiries.update');
    Route::delete('/enquiries/{enquiry}', [EnquiryManagerController::class, 'destroy'])->name('enquiries.destroy');

    // Menus
    Route::get('/menus', [MenuManagerController::class, 'index'])->name('menus.index');
    Route::post('/menus/{menu}/items', [MenuManagerController::class, 'storeItem'])->name('menus.items.store');
    Route::put('/menus/items/{item}', [MenuManagerController::class, 'updateItem'])->name('menus.items.update');
    Route::delete('/menus/items/{item}', [MenuManagerController::class, 'deleteItem'])->name('menus.items.delete');

    // Header & Footer
    Route::get('/header-footer', [HeaderFooterManagerController::class, 'index'])->name('header-footer.index');
    Route::post('/header-footer', [HeaderFooterManagerController::class, 'update'])->name('header-footer.update');

    // Media Library
    Route::get('/media', [MediaManagerController::class, 'index'])->name('media.index');
    Route::post('/media/upload', [MediaManagerController::class, 'upload'])->name('media.upload');
    Route::delete('/media/{media}', [MediaManagerController::class, 'destroy'])->name('media.destroy');

    // SEO
    Route::get('/seo', [SeoManagerController::class, 'index'])->name('seo.index');
    Route::put('/seo/{seo}', [SeoManagerController::class, 'update'])->name('seo.update');

    // Site Settings
    Route::get('/settings', [SettingManagerController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingManagerController::class, 'update'])->name('settings.update');

    // User Management
    Route::get('/users', [UserManagerController::class, 'index'])->name('users.index');
    Route::post('/users', [UserManagerController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserManagerController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagerController::class, 'destroy'])->name('users.destroy');

    // Admin Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
