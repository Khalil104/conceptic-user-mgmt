<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Création des dossiers indispensables
$tmp = '/tmp/storage/framework';
if (!is_dir("$tmp/views")) {
    mkdir("$tmp/views", 0755, true);
    mkdir("$tmp/sessions", 0755, true);
    mkdir("$tmp/cache", 0755, true);
}

// 2. Chargement de l'application
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// 3. Forçage du storage vers /tmp
$app->useStoragePath('/tmp/storage');

// 4. On oublie les vues pour ne plus avoir l'erreur [view]
$app->bind('view', function () {
    return new class { public function exists() { return false; } };
});

$app->handleRequest(Request::capture());