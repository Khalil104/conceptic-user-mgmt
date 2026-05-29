<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActivationController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Models\ActivityLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route de la page d'accueil
Route::get('/', [UserController::class, 'index'])->name('index');

// Nous le remettrons plus tard dans le middleware
Route::get('/admin/logs', [ActivityLogController::class, 'index'])->name('admin.logs.index');
Route::patch('users/{id}/update/{field}', [UserController::class, 'update'])->name('users.update.field');

Route::get('/test-notification', function () {
    $user = \App\Models\User::first();
    $user->notify(new \App\Notifications\UserRoleChangedNotification('user'));
    return 'Notification envoyée ! Vérifions la base de données.';
});

// --- Routes d'Authentification (Publiques) ---

// --- show ---

Route::get('/register',[AuthController::class, 'showRegister'])->name('register.show');

Route::get('/login', [AuthController::class , 'showLogin'])->name('login.show');

Route::get('/verify-2fa', [AuthController::class, 'showVerify'])->name('verify-2fa.show');

Route::get('/account-disabled', [AuthController::class, 'showRestore'])->name('account-disabled.show');

Route::get('/restore-confirm', [AuthController::class, 'showConfirmationRestore'])->name('confirm-restore.show');

Route::get('/restore-account', [AuthController::class, 'showRestore'])->name('restore-account.show');

Route::get('/activate/{token}', [ActivationController::class, 'activate'])->name('activate');

// --- process ---

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/verify-2fa', [AuthController::class, 'verify2fa'])->name('verify-2fa.process');

Route::post('/account-disabled', [AuthController::class, 'processDisabled'])->name('account-disabled.process');

Route::post('/restore-account', [AuthController::class, 'requestRestoration'])->name('restore-account.process');

Route::post('/restore-confirm', [AuthController::class, 'confirmRestoration'])->name('confirm-restore.process');

// Route web.php

Route::middleware('web')->group(function () {

    Route::get('/me', [AuthController::class, 'me'])->name('me');

    Route::get('/me/update/{user}/{field}', [UserController::class, 'updateShow'])->name('update.show');

    Route::put('/me/update/{user}/{field}', [UserController::class, 'update'])->name('update.process');

    Route::patch('users/{id}/update/{field}', [UserController::class, 'update'])->name('users.update.field');

    Route::get('/me/about', [AuthController::class, 'about'])->name('about');

    Route::post('/me/logout', [AuthController::class, 'logout'])->name('logout');

    Route::delete('/me/delete/{id}', [UserController::class, 'delete'])->name('delete.process');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    

});

// --- Routes protégées (Middleware Sanctum) ---

Route::middleware('auth:sanctum')->group(function () {

});
