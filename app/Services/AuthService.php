<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Validation\ValidationException;

class AuthService {
    
    protected $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    public function login(array $credentials) {

        $user = $this->authRepository->findByEmail($credentials['email']);

        if (!$user || !$this->authRepository->verifyPassword($user, $credentials['password'])) {
            return null;
        }

        // Suppression des anciens tokens pour n'en avoir qu'un actif
        $user->tokens()->delete();

        // Génération du token Sanctum
        return [
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken
        ];
    }

    public function logout($user) {
        return $user->currentAccessToken()->delete();
    }

}