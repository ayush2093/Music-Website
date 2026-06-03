<?php
// PHP front controller router for Vercel serverless deployment
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$uri = $_SERVER['REQUEST_URI'];
// Strip query string
$path = parse_url($uri, PHP_URL_PATH);

// Default root path to index.php
if ($path === '/' || $path === '') {
    $path = '/index.php';
}

// Clean and normalize the path to prevent directory traversal
$normalized_path = ltrim($path, '/');
if (strpos($normalized_path, '..') !== false) {
    http_response_code(403);
    echo "403 Forbidden";
    exit;
}

// Target file is located in the root directory relative to this api/ folder
$root_dir = dirname(__DIR__);
$target_file = $root_dir . '/' . $normalized_path;

// Handle index default inside subdirectories
if (is_dir($target_file)) {
    if (file_exists($target_file . '/index.php')) {
        $target_file .= '/index.php';
    } elseif (file_exists($target_file . '/index.html')) {
        $target_file .= '/index.html';
    }
}

if (file_exists($target_file)) {
    $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if ($ext === 'php') {
        // Change directory to the file's folder to ensure relative includes/requires resolve correctly
        chdir(dirname($target_file));
        require $target_file;
    } else {
        // Serve static file with appropriate MIME headers
        $mime_types = [
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'mp3' => 'audio/mpeg',
            'm4a' => 'audio/mp4',
            'wav' => 'audio/wav',
            'ico' => 'image/x-icon',
        ];
        
        if (isset($mime_types[$ext])) {
            header("Content-Type: " . $mime_types[$ext]);
        }
        
        // Disable output buffering and read file
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
        readfile($target_file);
    }
} else {
    // If the path doesn't exist, try resolving PHP file without extension (optional SEO/clean URL support)
    $php_resolved_file = $target_file . '.php';
    if (file_exists($php_resolved_file)) {
        chdir(dirname($php_resolved_file));
        require $php_resolved_file;
    } else {
        http_response_code(404);
        echo "404 Not Found";
    }
}
