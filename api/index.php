<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Nettoyage et création des dossiers dans /tmp
$baseTmp = '/tmp/bootstrap/cache';
if (!is_dir($baseTmp)) {
    mkdir($baseTmp, 0755, true);
}

// 2. Création des dossiers de storage
$storagePaths = ['/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions'];
foreach ($storagePaths as $path) {
    if (!is_dir($path)) mkdir($path, 0755, true);
}

// 3. Chargement de l'autoloader
require __DIR__.'/../vendor/autoload.php';

// 4. Initialisation de l'application
$app = require_once __DIR__.'/../bootstrap/app.php';

// 5. On force les chemins une dernière fois
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

$app->handleRequest(Request::capture());