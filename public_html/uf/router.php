<?php
// router.php
if (php_sapi_name() !== 'cli-server') {
    die('This script can only be used with PHP built-in server');
}

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve the requested resource as-is if it exists
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Handle extensionless URLs
if (preg_match('/^\/[^.]+$/', $uri)) {
    $php_file = __DIR__ . $uri . '.php';
    if (file_exists($php_file)) {
        require $php_file;
        return true;
    }
}

// Default to index.php
if ($uri === '/' || $uri === '') {
    require_once __DIR__ . '/index.php';
    return true;
}

// If nothing matches, return false to show the requested filename
return false;
?>