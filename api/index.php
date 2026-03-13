<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Création forcée des dossiers dans /tmp
$storagePaths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/logs',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 2. Chargement de l'autoloader
require __DIR__.'/../vendor/autoload.php';

// 3. Initialisation de l'application
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. CONFIGURATION CRUCIALE POUR VERCEL
// On force Laravel à utiliser le dossier /tmp pour le cache et les vues
$app->useStoragePath('/tmp/storage');

// 5. Gestion de la requête
$app->handleRequest(Request::capture());