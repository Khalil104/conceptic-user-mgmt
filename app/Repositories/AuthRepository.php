<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository {

    // -@- Trouver les utilisateurs où deleted_at est NULL
    public function findByEmail(string $email) : ?User 
    {
        return User::where('email',  $email)->first();
    }

    // -@- Trouver un utilisateur uniquement parmi les supprimés
    public function findTrashedByEmail(string $email) : ?User
    {
        return User::onlyTrashed()->where('email', $email)->first();
    }
    
    // -@- Vérifier le mot de passe !
    public function verifyPassword( User $user, string $password): bool 
    {
        return Hash::check($password, $user->password);
    }

}
