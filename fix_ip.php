<?php
$dirs = [
    'f:\xampp\htdocs\bank\online\laravel\app\Http\Controllers',
    'f:\xampp\htdocs\bank\admin\lsapp\app\Http\Controllers'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Fix getIp filtering out localhost
            $modified = str_replace(
                ", FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE",
                "",
                $content
            );
            
            if ($content !== $modified) {
                file_put_contents($path, $modified);
            }
        }
    }
}
echo "Done fixing IPs.\n";
