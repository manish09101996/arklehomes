<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * If public/storage is a physical directory instead of a symlink,
     * sync the uploaded file from storage/app/public to public/storage.
     */
    public static function sync(string $relativePath): void
    {
        try {
            $src = storage_path('app/public/' . ltrim($relativePath, '/\\'));
            $pubDir = public_path('storage');

            // If public/storage is a symlink, the system handles it automatically
            if (is_link($pubDir)) {
                return;
            }

            if (file_exists($src)) {
                $dst = $pubDir . '/' . ltrim($relativePath, '/\\');
                $targetDir = dirname($dst);
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                @copy($src, $dst);
            }
        } catch (\Throwable $e) {
            // Silently ignore to avoid breaking user flow
        }
    }
}
