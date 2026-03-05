<?php

namespace App\Services;

use App\Models\VerificationCode;
use App\Repositories\AuthRepository;
use Illuminate\Validation\ValidationException;

class AuthService {
    
    protected $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    // Connexion d'un utilisateur
    public function login(array $credentials) {

        $user = $this->authRepository->findByEmail($credentials['email']);

        if (!$user || !$this->authRepository->verifyPassword($user, $credentials['password'])) {
            return null;
        }

        // Etape 2FA : Génération du code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        //Simuler l'envoi (On le renvoie dans la réponse pour les tests)
        return [
            'status' => '2FA_REQUIRED',
            'message' => 'Veuillez entrer le code envoyé par email',
            'temp_user_id' => $user->id,
            'dev_debug_code' => $code 
        ];
        // Suppression des anciens tokens pour n'en avoir qu'un actif
       //  $user->tokens()->delete();

        // Génération du token Sanctum
        // return [
        //     'user' => $user,
        //     'token' => $user->createToken('api-token')->plainTextToken
        // ];
    }

    //
    public function verify2FACode(string $userId, string $code) {
        // 1. Chercher le dernier code valide pour cet UUID
        $verification = \App\Models\verificationCode::where('user_id',$userId)->latest()->first();

        // 2. Vérifier s'il existe 
        if(!$verification){
            return [
                'success' => false,
                'message' => 'Aucun code trouvé pour cet utilisateur.',
                'code' => 404
            ];
        }

        // 3. Vérifier s'il correspond
        if ($verification->code !== $code) {
            return [
                'success' => false,
                'message' => 'Code de vérification incorrect.',
                'code' => 401
            ];
        }

        // 4. Vérifier l'expiration
        if($verification->expires_at < now()) {
            return [
                'success' => false,
                'message' => 'Le code a expiré.',
                'code' => 410
            ];
        } 

        // 5. Tout est OK : On récupère l'user, on génère le token et on nettoie
        $user = \App\Models\User::find($userId);
        $token = $user->createToken('auth_token')->plainTextToken;

        // Supprimer le code pour qu'il ne soit plus réutilisable
        $verification->delete();

        return [
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];         
    }

    // Déconnexion de l'utilisateur
    public function logout($user) {
        return $user->currentAccessToken()->delete();
    }
}