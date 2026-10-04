<?php
/**
 * Local Development Router
 * 
 * Serves both admin and online Laravel apps from a single PHP server.
 * Replicates the production Apache setup where:
 *   - /admin  -> admin/lsapp (Laravel)
 *   - /online -> online/laravel (Laravel)
 *
 * Usage: php -S 127.0.0.1:8000 router.php
 */

// PHP 8.1+ compatibility: strip 'full_path' from $_FILES which breaks Symfony 4/5 FileBag
if (!empty($_FILES)) {
    $stripFullPath = function(&$files) use (&$stripFullPath) {
        foreach ($files as &$file) {
            if (is_array($file)) {
                unset($file['full_path']);
                $stripFullPath($file);
            }
        }
    };
    $stripFullPath($_FILES);
}

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly if they exist on disk
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    $ext = pathinfo($uri, PATHINFO_EXTENSION);
    // If it's a real file (not a directory), let PHP's built-in server handle it
    if (is_file(__DIR__ . $uri)) {
        // Set correct content types for common file types
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'json'  => 'application/json',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'eot'   => 'application/vnd.ms-fontobject',
            'map'   => 'application/json',
            'pdf'   => 'application/pdf',
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
            readfile(__DIR__ . $uri);
            return true;
        }
        return false; // Let PHP built-in server handle other file types
    }
}

// Route /admin requests to admin Laravel app
if (preg_match('#^/admin(/.*)?$#', $uri, $matches)) {
    if ($uri === '/admin') {
        header('Location: /admin/');
        exit;
    }
    // Set SCRIPT_NAME so Laravel calculates the correct base path
    $_SERVER['SCRIPT_NAME'] = '/admin/index.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/admin/index.php';
    $_SERVER['PHP_SELF'] = '/admin/index.php';
    
    chdir(__DIR__ . '/admin');
    require __DIR__ . '/admin/index.php';
    return true;
}

// Route /online requests to online Laravel app
if (preg_match('#^/online(/.*)?$#', $uri, $matches)) {
    if ($uri === '/online') {
        header('Location: /online/');
        exit;
    }
    // Set SCRIPT_NAME so Laravel calculates the correct base path
    $_SERVER['SCRIPT_NAME'] = '/online/index.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/online/index.php';
    $_SERVER['PHP_SELF'] = '/online/index.php';
    
    chdir(__DIR__ . '/online');
    require __DIR__ . '/online/index.php';
    return true;
}

// Default: show a simple landing page
http_response_code(200);
header('Content-Type: text/html');
echo '<!DOCTYPE html>
<html>
<head><title>Bank - Local Development</title></head>
<body style="font-family: Arial, sans-serif; text-align: center; margin-top: 100px;">
    <h1>Bank - Local Development Server</h1>
    <p><a href="/admin">Admin Panel</a></p>
    <p><a href="/online">Online Banking (Client)</a></p>
</body>
</html>';
