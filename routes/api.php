<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// --- Routes publiques ---
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify-2fa',[AuthController::class, 'verify2FA']);
Route::post('/restore/request', [AuthController::class, 'requestRestoration']);
Route::post('/restore/confirm', [AuthController::class, 'confirmRestoration']);

Route::get('/migrate-db', function () {
    // 1. Désactiver le rendu de vue pour cette requête
    config(['app.debug' => true]);

    try {
        // 2. Tester la connexion brute à la DB avant tout
        DB::connection()->getPdo();
        
        // 3. Lancer la migration
        Artisan::call('migrate --force');
        
        // 4. Retourner du texte pur (pas de vue !)
        return response("Succès ! \n\n" . Artisan::output())
                ->header('Content-Type', 'text/plain');

    } catch (\Exception $e) {
        // 5. En cas d'erreur, on affiche le message brut
        return response("Erreur de connexion ou de migration : \n\n" . $e->getMessage())
                ->header('Content-Type', 'text/plain');
    }
});


// --- Routes protégées (Middleware Group) ---
Route::middleware('auth:sanctum')->group(function () {

    // Récupérer les infos de l'utilisateur connecté
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Gestion des utilisateurs (CRUD)
    Route::get('/users', [UserController::class, 'all']);
    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/{user}', [UserController::class, 'find']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'delete']); 

    //  Accès au dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Route::get('/dashboard/trashed-users', [DashboardController::class, 'trashedUsers']);
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);
});