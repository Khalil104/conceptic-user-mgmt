<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;

trait HasCustomAuth

{
    /**
     * Récupérons l'utilisateur authentifié (compatible avec notre système personnalisé)
     * 
     * @param Request|null $request
     * @return User|null
     */
    public function getAuthenticatedUser(Request $request = null): ?User
    {
        // Si aucun request n'est passé, prenons la request actuelle
        $request = $request ?? request();

        // Sanctum / API Token
        if($request->user()) {
            return $request->user();
        }

        // Session (Blade / Web)
        $userId = session('user_id');
        if($userId) {
            return User::find($userId);
        }

        return null;
    }

    /**
     * Vérifions si un utilisateur est connecté
     */
    public function isAuthenticated(Request $request = null): bool
    {
        return $this->getAuthenticatedUser($request) !== null;
    }
}