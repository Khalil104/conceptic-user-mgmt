<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActivationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route de la page d'accueil
Route::get('/', [UserController::class, 'index'])->name('index');

// --- Routes d'Authentification (Publiques) ---

// --- show ---

Route::get('/register',[AuthController::class, 'showRegister'])->name('register.show');

Route::get('/login', [AuthController::class , 'showLogin'])->name('login.show');

Route::get('/verify-2fa', [AuthController::class, 'showVerify'])->name('verify-2fa.show');

Route::get('/account-disabled', [AuthController::class, 'showRestore'])->name('account-disabled.show');

Route::get('/activate/{token}', [ActivationController::class, 'activate'])->name('activate');

// --- process ---

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/verify-2fa', [AuthController::class, 'verify2fa'])->name('verify-2fa.process');

Route::post('/account-disabled', [AuthController::class, 'processDisabled'])->name('account-disabled.process');

Route::get('/restore-account', [AuthController::class, 'showRestore'])->name('restore-account.show');

Route::post('/restore-account', [AuthController::class, 'requestRestoration'])->name('restore-account.process');

Route::get('/restore-confirm', [AuthController::class, 'showConfirmationRestore'])->name('confirm-restore.show');

Route::post('/restore-confirm', [AuthController::class, 'confirmRestoration'])->name('confirm-restore.process');


// Route web.php

Route::middleware('web')->group(function () {

    Route::get('/me', [AuthController::class, 'me'])->name('me');

    Route::get('/me/update/{user}/{field}', [UserController::class, 'updateShow'])->name('update.show');

    Route::put('/me/update/{user}/{field}', [UserController::class, 'update'])->name('update.process');

    Route::get('/me/about', [AuthController::class, 'about'])->name('about');

    Route::post('/me/logout', [AuthController::class, 'logout'])->name('logout');

    Route::delete('/me/delete/{id}', [UserController::class, 'delete'])->name('delete.process');

    //

    Route::get('/users', [UserController::class, 'all']);

    Route::get('/users/{user}', [UserController::class, 'find']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

});

// --- Routes protégées (Middleware Sanctum) ---

Route::middleware('auth:sanctum')->group(function () {

});
