<?php
// PHPNuxBill Cloud Config (SSL Fix)

// 1. Fix SSL detection for Koyeb Load Balancer
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// 2. Prioritize the Environment Variable if set
if (getenv('APP_URL')) {
    define('APP_URL', getenv('APP_URL'));
} else {
    // Fallback: Auto-detect
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('APP_URL', $protocol . $host . $baseDir);
}

$_app_stage = 'Live';

// 3. Database Credentials
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME');

error_reporting(E_ERROR);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
?>
