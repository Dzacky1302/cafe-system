<?php

if (! function_exists('rupiah')) {
    function rupiah(int|float $amount): string
    {
        return 'Rp'.number_format((int) $amount, 0, ',', '.');
    }
}

if (! function_exists('admin_storage_url')) {
    function admin_storage_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return rtrim((string) config('cafe.admin_storage_url'), '/').'/'.ltrim($path, '/');
    }
}
