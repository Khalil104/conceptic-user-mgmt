<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Routes Utilitaires & Debug ---

// Route racine pour vérifier que l'API répond

// Route::get('/', function () {
//     return "L'API est en ligne ! Essayez /migrate-db pour configurer la base de données.";
// });

// Route de diagnostic pour lister toutes les routes actives sur Vercel

// Route::get('/debug-routes', function () {
//     return collect(Route::getRoutes())->map(function ($route) {
//         return $route->methods()[0] . " | " . $route->uri();
//     });
// });

// Route de migration (À supprimer ou protéger après usage)

// Route::get('/migrate-db', function () {
//     try {
//         Artisan::call('migrate', ['--force' => true]);
//         $output = Artisan::output();
//         return "✅ Migration réussie ! \n\nDétails :\n" . $output;
//     } catch (\Exception $e) {
//         return "❌ Erreur : " . $e->getMessage();
//     }
// });


// --- Routes d'Authentification (Publiques) ---

// Route::post('/register', [UserController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/verify-2fa', [AuthController::class, 'verify2FA']);
// Route::post('/restore-account', [AuthController::class, 'requestRestoration']);
// Route::post('/confirm-restore', [AuthController::class, 'confirmRestoration']);


// // --- Routes protégées (Middleware Sanctum) ---

// Route::middleware('auth:sanctum')->group(function () {

//     // Récupérer les infos de l'utilisateur connecté
//     Route::get('/me', function (Request $request) {
//         return $request->user();
//     });

//     // Gestion des utilisateurs (CRUD)
//     Route::get('/users', [UserController::class, 'all']);
//     Route::get('/users/{user}', [UserController::class, 'find']);
//     Route::put('/users/{user}', [UserController::class, 'update']);
//     Route::delete('/users/{user}', [UserController::class, 'delete']); 

//     // Accès au dashboard
//     Route::get('/dashboard', [DashboardController::class, 'index']);
    
//     // Déconnexion
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

/*
|--------------------------------------------------------------------------
| Éléments mis en commentaire pour plus tard
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard/trashed-users', [DashboardController::class, 'trashedUsers']);