<?php
// cron-run.php
// Protected web cron wrapper for PHPNuxBill on Koyeb.

$secret = getenv('CRON_SECRET') ?: ($_ENV['CRON_SECRET'] ?? '');
$provided = $_GET['key'] ?? ($_SERVER['HTTP_X_CRON_SECRET'] ?? '');

if (!$secret || !hash_equals($secret, $provided)) {
    http_response_code(403);
    echo "Forbidden\n";
    exit;
}

header('Content-Type: text/plain; charset=utf-8');

chdir(__DIR__ . '/system');
require __DIR__ . '/system/cron.php';
