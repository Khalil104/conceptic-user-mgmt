<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// API Routes

// --- Routes Utilisateurs ---

// GET /api/users -> Liste (index)
Route::get('users', [UserController::class, 'index']);

// POST /api/users -> Création (store)
Route::post('users', [UserController::class, 'store']);

// --- Route Authentifiée ---
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');