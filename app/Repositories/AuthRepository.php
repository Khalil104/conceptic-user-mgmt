<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\VerificationCode;
use Illuminate\Support\Str;

class AuthRepository {

    // -@- Créer un utilisateur
    public function create(array $data)
    {
        return User::create($data);
    }

    // -@- Retrouver un utilisateur
    public function find(string $id) {
        return User::findOrFail($id);
    }

    // -@- Trouver les utilisateurs où deleted_at est NULL.
    public function findUserByEmail(string $email) : ?User
    {
        return User::withTrashed()->where('email', $email)->first();
    }

    // -@- Trouver un utilisateur uniquement parmi les supprimés.
    public function findUserTrashed(string $email) : ?User
    {
        return User::onlyTrashed()->where('email', $email)->first();
    }

    // -@- Vérifier le mot de passe !
    public function verifyPassword( User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    // -@- Créer le code temporaire de vérification dans la base
    public function createVerificationCode(string $userId, string $code) : VerificationCode
    {
        return VerificationCode::create([
            'user_id' => $userId,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);
    }

    // -@- Vérifier si le code est correct.
    public function findVerificationCode(string $userId): ?VerificationCode
    {
        return VerificationCode::where('user_id', $userId)->latest()->first();
    }

    //
    public function findRestaurationCode(string $userId, string $code){
        return VerificationCode::where('user_id', $userId)
                    ->where('code', $code)
                    ->where('expires_at', '>', now())
                    ->first();
    }

    // -@- Récupérer l'utilisateur à partir du token validé par Sanctum

    public function getAuthenticatedUser($request): ?User
    {
        // Sanctum (API)
        if($request->user()) {
            return $request->user();
        }

        // Fallback session (Blade)
        $userId = session('user_id');
        if ($userId) {
            return User::find($userId);
        }
        return null;
    }

    // Restaurer un user
    public function restore(User $user) {
        return $user->restore();
    }
}
