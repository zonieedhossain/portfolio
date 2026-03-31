<?php
/**
 * PHP Router for Local Development / WSL Preview
 * Mimics Hostinger's .htaccess behavior
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// 1. Serve static files if they exist
$filePath = __DIR__ . $uri;
if (file_exists($filePath) && !is_dir($filePath)) {
    // If it's a static file, let the built-in server handle it
    return false; 
}

// 2. API routing to api.php
if (strpos($uri, '/api/') === 0) {
    // Ensureapi.php exists
    if (file_exists(__DIR__ . '/api.php')) {
        include __DIR__ . '/api.php';
        exit;
    }
}

// 3. Fallback to index.php for all other routes (Home page)
if (file_exists(__DIR__ . '/index.php')) {
    include __DIR__ . '/index.php';
    exit;
}

// 4. Final fallback
http_response_code(404);
echo "404 Not Found";
