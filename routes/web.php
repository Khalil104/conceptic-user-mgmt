<?php

use Illuminate\Support\Facades\Artisan;

// On force la route à ignorer les middlewares de session/auth pour éviter la 404/500
Route::get('/migrate-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "✅ Migration réussie ! \n\n" . Artisan::output();
    } catch (\Exception $e) {
        return "❌ Erreur : " . $e->getMessage();
    }
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

