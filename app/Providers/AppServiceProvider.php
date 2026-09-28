<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;
use App\Models\Menu;
use App\Models\ContactEnquiry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('site_settings')) {
                    $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
                    $view->with('settings', $settings);
                } else {
                    $view->with('settings', []);
                }

                if (Schema::hasTable('menus') && Schema::hasTable('menu_items')) {
                    $headerMenu = Menu::where('location', 'header')->first();
                    $headerItems = $headerMenu ? $headerMenu->activeItems : collect();

                    $footerQuickMenu = Menu::where('location', 'footer_quick_links')->first();
                    $footerQuickItems = $footerQuickMenu ? $footerQuickMenu->activeItems : collect();

                    $footerLegalMenu = Menu::where('location', 'footer_legal')->first();
                    $footerLegalItems = $footerLegalMenu ? $footerLegalMenu->activeItems : collect();

                    $view->with([
                        'headerNavItems' => $headerItems,
                        'footerQuickLinks' => $footerQuickItems,
                        'footerLegalLinks' => $footerLegalItems,
                    ]);
                }

                if (Schema::hasTable('contact_enquiries')) {
                    $unreadCount = ContactEnquiry::where('status', 'unread')->count();
                    $view->with('unreadEnquiriesCount', $unreadCount);
                }
            } catch (\Exception $e) {
                // Graceful fallback during migration
                $view->with([
                    'settings' => [],
                    'headerNavItems' => collect(),
                    'footerQuickLinks' => collect(),
                    'footerLegalLinks' => collect(),
                    'unreadEnquiriesCount' => 0,
                ]);
            }
        });
    }
}
