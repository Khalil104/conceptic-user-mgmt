<?php

// Import nécessaire au fonctionnement de l'api
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// Routes pour créer un utilisateurs 
// Route::post("/users", [UserController::class, 'store']);

Route::apiResource('users', UserController::class);

// Route pour récupérer les informations de l'utilisateur avec Sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

