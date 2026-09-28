<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "Current Dir (__DIR__): " . __DIR__ . "<br>";
echo "Files in current dir: " . implode(', ', array_slice(scandir(__DIR__), 0, 15)) . "<br>";

$baseDir = file_exists(__DIR__ . '/artisan') ? __DIR__ : (file_exists(dirname(__DIR__) . '/artisan') ? dirname(__DIR__) : __DIR__);
echo "Detected BaseDir: " . $baseDir . "<br>";
$storage = $baseDir . '/storage';
$cache = $baseDir . '/bootstrap/cache';



echo "Storage exists: " . (is_dir($storage) ? "YES" : "NO") . "<br>";
echo "Storage writable: " . (is_writable($storage) ? "YES" : "NO (Fix: chmod -R 775 storage)") . "<br>";
echo "Storage logs writable: " . (is_writable($storage . '/logs') ? "YES" : "NO") . "<br>";
echo "Storage framework views writable: " . (is_writable($storage . '/framework/views') ? "YES" : "NO") . "<br>";
echo "Bootstrap cache writable: " . (is_writable($cache) ? "YES" : "NO (Fix: chmod -R 775 bootstrap/cache)") . "<br>";

echo "<hr><h3>Checking Laravel Bootstrap & Database</h3>";

if (!file_exists($baseDir . '/vendor/autoload.php')) {
    echo "<b style='color:red;'>vendor/autoload.php is missing. Run composer install.</b><br>";
    exit;
}

try {
    require $baseDir . '/vendor/autoload.php';
    $app = require_once $baseDir . '/bootstrap/app.php';
    
    // Bootstrap console/app
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "Laravel Version: " . app()->version() . "<br>";
    echo "APP_KEY set: " . (config('app.key') ? "YES" : "NO") . "<br>";
    echo "DB Connection: " . config('database.default') . "<br>";
    echo "DB Host: " . config('database.connections.mysql.host') . "<br>";
    echo "DB Database: " . config('database.connections.mysql.database') . "<br>";
    echo "DB Username: " . config('database.connections.mysql.username') . "<br>";
    echo "DB Password set: " . (!empty(config('database.connections.mysql.password')) ? "YES (Length: " . strlen(config('database.connections.mysql.password')) . ")" : "NO / EMPTY") . "<br>";

    Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<p style='color:green; font-weight:bold;'>✓ Database connection SUCCESSFUL!</p>";

    $tables = Illuminate\Support\Facades\DB::select('SHOW TABLES');
    echo "Total tables found: " . count($tables) . "<br>";
    if (count($tables) === 0) {
        echo "<b style='color:orange;'>Warning: Database has 0 tables. Please import database/arkle_homes.sql in phpMyAdmin.</b><br>";
    } else {
        echo "<span style='color:green;'>✓ Tables exist: Ready to serve!</span><br>";
    }
} catch (Throwable $e) {
    echo "<p style='color:red; font-weight:bold;'>Error Caught: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='background:#f1f5f9; padding:12px; border-radius:6px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
