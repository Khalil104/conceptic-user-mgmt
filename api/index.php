<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Création des dossiers indispensables dans /tmp avant que laravel ne démarre.

$paths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/sessions',
    '/tmp/storage/bootstrap/cache'
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 2. On charge l'autoloader
require __DIR__ . '/../vendor/autoload.php';

// 3. On initialise l'application 
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. On force les chemins (crucial pour vercel)
$app->useStoragePath('/tmp/storage');
$app->bind('path.bootstrap', function () {
    return 'tmp/bootstrap';
}) ;

// 5. On traite la requête 
$app->handleRequest(Request::capture());