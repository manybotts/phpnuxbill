<?php
declare(strict_types=1);

/**
 * Protected web cron wrapper for PHPNuxBill on Koyeb.
 *
 * External scheduler URL:
 *   /cron-run.php?key=YOUR_CRON_SECRET
 *
 * VPS curl header alternative:
 *   curl -H "X-Cron-Secret: YOUR_CRON_SECRET" https://your-domain/cron-run.php
 */

$secret = getenv('CRON_SECRET') ?: ($_ENV['CRON_SECRET'] ?? '');
$provided = $_GET['key'] ?? ($_SERVER['HTTP_X_CRON_SECRET'] ?? '');

header('Content-Type: text/plain; charset=UTF-8');

if ($secret === '') {
    http_response_code(500);
    echo "CRON_SECRET is not configured on the server.\n";
    exit;
}

if ($provided === '' || !hash_equals($secret, $provided)) {
    http_response_code(403);
    echo "Forbidden\n";
    exit;
}

set_time_limit(0);
ignore_user_abort(true);

$systemDir = __DIR__ . '/system';
$cronFile = $systemDir . '/cron.php';

if (!is_dir($systemDir)) {
    http_response_code(500);
    echo "System directory not found: {$systemDir}\n";
    exit;
}

if (!is_file($cronFile)) {
    http_response_code(500);
    echo "Cron file not found: {$cronFile}\n";
    exit;
}

chdir($systemDir);
require $cronFile;
