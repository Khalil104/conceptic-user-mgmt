<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// API Routes

// --- Routes Utilisateurs ---

// php artisan route:clear   # Nettoie les routes
// php artisan config:clear  # Nettoie la configuration (important pour phpunit.xml)
// php artisan cache:clear   # Nettoie le cache de l'application

// GET /api/users -> Liste (index)
Route::get('users', [UserController::class, 'index']);

// POST /api/users -> Création (store)
Route::post('users', [UserController::class, 'store']);

// GET /api/users{user} -> Détail (show)
Route::get('users/{user}', [UserController::class, 'show']);

// PUT /api/users/{user} -> Mise à jour (update)
Route::put('users/{user}', [UserController::class, 'update']);

// DELETE /api/user/{user} -> Suppression (destroy)
Route::delete('users/{user}', [UserController::class, 'delete']);

// --- Route Authentifiée ---
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');