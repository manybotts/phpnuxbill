<?php
// PHPNuxBill Cloud Config (Final Audit Version)

// 1. SSL & Proxy Fix for Koyeb (Crucial for CSS/Login)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// 2. APP_URL Definition
// We check the Environment variable first (Best Practice), otherwise auto-detect.
if (getenv('APP_URL')) {
    define('APP_URL', getenv('APP_URL'));
} else {
    define('APP_URL', $protocol . $host . $baseDir);
}

// 3. Security Stage (Matches config.sample.php)
$_app_stage = 'Live';

// 4. MAIN DATABASE (Reads from Koyeb Env)
$db_host = getenv('DB_HOST');
$db_port = "3306"; // Added for safety (from config.sample.php)
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME');

// 5. RADIUS DATABASE (The Critical Missing Piece from install/step4.php)
// We point these to the SAME credentials as the main DB
$radius_host = getenv('DB_HOST');
$radius_port = "3306";
$radius_user = getenv('DB_USER');
$radius_pass = getenv('DB_PASS');
$radius_name = getenv('DB_NAME');

// 6. Error Handling (Production Mode)
if($_app_stage != 'Live'){
    error_reporting(E_ERROR);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(E_ERROR);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}
?>
