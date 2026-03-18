<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

Route::get('/migrate-db', function(){
    try {
        // 1. On vérifie la connexion brute
        DB::connection()->getPdo();

        // 2. On lance les migrations 
        Artisan::call('migrate', ['--force' => true]);

        // 3. On récupère le résultat pour afficher à l'écran
        $outpout = Artisan::output();

        return response("✅ Migration réussie ! \nDétails : \n . $output")->header('content-Type', 'text/plain');
    } catch (\Exception $e) {
        return response("❌ Erreur lors de la migration :\n\n" . $e->getMessage())->header('Content-Type', 'text/plain');
    } 
});

// --- Routes publiques ---
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify-2fa',[AuthController::class, 'verify2FA']);
Route::post('/restore-account', [AuthController::class, 'requestRestoration']);
Route::post('/confirm-restore', [AuthController::class, 'confirmRestoration']);

// --- Routes protégées (Middleware Group) ---
Route::middleware('auth:sanctum')->group(function () {

    // Récupérer les infos de l'utilisateur connecté
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Gestion des utilisateurs (CRUD)
    Route::get('/users', [UserController::class, 'all']);
    Route::get('/users/{user}', [UserController::class, 'find']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'delete']); 

    //  Accès au dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Route::get('/dashboard/trashed-users', [DashboardController::class, 'trashedUsers']);
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);
});