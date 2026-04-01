<?php

/**
 * Application Configuration
 * P3M UNIM - PHP Native Backend
 */

// ============ LOAD ENVIRONMENT VARIABLES ============
$envFile = __DIR__ . '/../secret.env';
$env = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $env[trim($name)] = trim($value);
    }
}

// ============ DATABASE ============
define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
define('DB_PORT', $env['DB_PORT'] ?? '3306');
define('DB_NAME', $env['DB_NAME'] ?? 'p3munimphp');
define('DB_USER', $env['DB_USER'] ?? 'root');
define('DB_PASSWORD', $env['DB_PASS'] ?? '');
define('DB_CHARSET', $env['DB_CHARSET'] ?? 'utf8mb4');

// ============ CORS ============
define('ALLOWED_ORIGINS', [
    // 'http://sdnmojosari.site',
    // 'https://sdnmojosari.site',
    // 'http://www.sdnmojosari.site',
    // 'https://www.sdnmojosari.site',
    // 'http://localhost:5173',
]);

// ============ SESSION ============
define('SESSION_LIFETIME', 36000); // 10 hours in seconds

// ============ UPLOAD ============
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
define('ALLOWED_DOC_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// ============ ENVIRONMENT ============
define('APP_ENV', 'development'); // 'development' or 'production'
