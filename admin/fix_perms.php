<?php

$dir = __DIR__ . '/lsapp/vendor';

if (!is_dir($dir)) {
    die("Vendor directory not found!");
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    if ($item->isDir()) {
        chmod($item->getRealPath(), 0755);
    } else {
        chmod($item->getRealPath(), 0644);
    }
}

// Also fix the storage and bootstrap/cache permissions just in case
chmod(__DIR__ . '/lsapp/storage', 0775);
chmod(__DIR__ . '/lsapp/bootstrap/cache', 0775);

echo "Permissions have been successfully fixed!";
