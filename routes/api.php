<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

// --- Routes publiques ---
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/verify-2fa',[AuthController::class, 'verify2FA']);

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