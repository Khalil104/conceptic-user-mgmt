<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

// Création des dossiers dans /tmp
$paths = ['/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions'];
foreach ($paths as $path) {
    if (!is_dir($path)) mkdir($path, 0755, true);
}

$app = require_once __DIR__.'/../bootstrap/app.php';

// Force le storage
$app->useStoragePath('/tmp/storage');

$app->handleRequest(Request::capture());