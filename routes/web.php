<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Route de secours pour vérifier que le fichier est bien lu
Route::get('/', function () {
    return "L'API est en ligne ! Essayez /migrate-db pour configurer la base de données.";
});

// Route de migration
Route::get('/migrate-db', function () {
    try {
        // Force la création des tables
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
        return "✅ Migration réussie ! \n\nDétails :\n" . $output;
    } catch (\Exception $e) {
        return "❌ Erreur : " . $e->getMessage();
    }
});

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });