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

        // Auto-create storage symlink or copy if missing on deployment environments
        $pubStorage = public_path('storage');
        if (!file_exists($pubStorage) && !is_link($pubStorage)) {
            $linked = false;
            try {
                $linked = @symlink(storage_path('app/public'), $pubStorage);
            } catch (\Throwable $e) {
                $linked = false;
            }

            if (!$linked && !file_exists($pubStorage)) {
                try {
                    self::copyStorageTree(storage_path('app/public'), $pubStorage);
                } catch (\Throwable $e) {
                    // Fallback route in web.php will handle files
                }
            }
        }

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

    /**
     * Recursively copy files from source to destination directory
     */
    private static function copyStorageTree(string $src, string $dst): void
    {
        if (!is_dir($src)) {
            return;
        }
        if (!is_dir($dst)) {
            @mkdir($dst, 0755, true);
        }
        $items = scandir($src);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $srcItem = $src . '/' . $item;
            $dstItem = $dst . '/' . $item;
            if (is_dir($srcItem)) {
                self::copyStorageTree($srcItem, $dstItem);
            } elseif (!file_exists($dstItem)) {
                @copy($srcItem, $dstItem);
            }
        }
    }
}
