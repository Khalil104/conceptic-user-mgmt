<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository {

    public function findByEmail(string $email) : ?User 
    {
        return User::where('email',  $email)->first();
    }

    public function verifyPassword( User $user, string $password): bool 
    {
        return Hash::check($password, $user->password);
    }

}
