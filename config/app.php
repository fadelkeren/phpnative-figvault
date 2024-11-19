<?php
// Base URL configuration
define('BASE_URL', 'http://localhost/figma-sharing/public');

// Application settings
define('APP_NAME', 'Figma Design Sharing');
define('UPLOAD_PATH', __DIR__ . '/../public/uploads');
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB