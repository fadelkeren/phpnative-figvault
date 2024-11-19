<?php
session_start();

// Define root path
define('ROOT_PATH', dirname(__DIR__));

// Load configuration files
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/includes/functions.php';

// Get URL path
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/javascript/php/public'; // Sesuaikan dengan path project Anda
$path = str_replace($base_path, '', $request_uri);

// Basic routing
switch ($path) {
    case '/':
        require_once ROOT_PATH . '/includes/header.php';
        require_once ROOT_PATH . '/views/home.php';
        require_once ROOT_PATH . '/includes/footer.php';
        break;
        
    case '/dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        require_once ROOT_PATH . '/includes/header.php';
        require_once ROOT_PATH . '/views/dashboard.php';
        require_once ROOT_PATH . '/includes/footer.php';
        break;
        
    case '/upload':
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        require_once ROOT_PATH . '/includes/header.php';
        require_once ROOT_PATH . '/views/upload.php';
        require_once ROOT_PATH . '/includes/footer.php';
        break;
        
    case '/login':
        require_once ROOT_PATH . '/auth/google-login.php';
        break;
        
    case '/callback':
        require_once ROOT_PATH . '/auth/callback.php';
        break;
        
    default:
        http_response_code(404);
        require_once ROOT_PATH . '/views/404.php';
        break;
}