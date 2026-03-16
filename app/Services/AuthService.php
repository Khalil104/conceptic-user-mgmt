<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Validation\ValidationException;

class AuthService 
{
    
    protected $authRepository;

    public function __construct(AuthRepository $authRepository) 
    {
        $this->authRepository = $authRepository;
    }

    // -@- Connexion d'un utilisateur
    public function login(array $credentials) 
    {
        // -@- Etape 1 : On cherche l'utilisateur actif ou supprimé.

        $user = User::withTrashed()->where('email', $credentials['email'])->first();

        if (!$user) {
            return [
                'success' => false, 
                'message' => 'Identifiants incorrects.', 
                'status' => 401
            ];
        }

        if (!$this->authRepository->verifyPassword($user, $credentials['password'])) {
           return [
                'success' => false, 
                'message' => 'Identifiants incorrects.', 
                'status' => 401
            ];
        
        }

        if ($user->trashed()) {
            return [
                'success' => false,
                'message' => 'Votre compte est désactivé ou supprimé. Souhaitez-vous le restaurer ?',
                'can_restore' =>true,
                'status' => 403
            ];
        }

        // -@- Etape 2FA : Génération du code.
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        // -@- Envoi de l'email
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        // -@- Reception du code par mail via mailtrap. 
        // -@- Simuler l'envoi (Envoi dans la réponse pour les tests)
        return [
            'success' => true,
            'status' => '2FA_REQUIRED',
            'message' => 'Un code de vérification a été envoyé à votre adresse mail.',
            'user_id' => $user->id
            // 'message' => 'Veuillez entrer le code envoyé par email',
            // 'temp_user_id' => $user->id,
            // 'dev_debug_code' => $code 
        ];

        // Simulation de l'envoi du SMS
        // if(config('services.sms.provider') === 'log') {
        //     \Illuminate\Support\Facades\Log::info("SMS envoyé à {$user->phone} : Votre code est $code ");
        // }

        // Suppression des anciens tokens pour n'en avoir qu'un actif
       //  $user->tokens()->delete();

        // Génération du token Sanctum
        // return [
        //     'user' => $user,
        //     'token' => $user->createToken('api-token')->plainTextToken
        // ];
    }

    // -@- Vérification 2FA
    public function verify2FACode(string $userId, string $code) 
    {
        // -@- 1. Chercher le dernier code valide pour cet UUID
        $verification = \App\Models\verificationCode::where('user_id',$userId)
        ->latest()
        ->first();

        // -@- 2. Vérifier s'il existe 
        if(!$verification){
            return [
                'success' => false,
                'message' => 'Aucun code trouvé pour cet utilisateur.',
                'code' => 404
            ];
        }

        // -@- 3. Vérifier s'il correspond
        if ($verification->code !== $code) {
            return [
                'success' => false,
                'message' => 'Code de vérification incorrect.',
                'code' => 401
            ];
        }

        // -@- 4. Vérifier l'expiration
        if($verification->expires_at < now()) {
            return [
                'success' => false,
                'message' => 'Le code a expiré.',
                'code' => 410
            ];
        } 

        // -@- 5.   Vérifier si l'utilisateur existe.
        $user =\App\Models\User::withTrashed()->find($userId);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Utilisateur introuvable',
                'code' => 404
            ];
        }

        // -@- 6. On empêche la génération de token si le compte est toujours supprimer.
        if($user->trashed()) {
            return [
                'success' => false,
                'message' => 'Action impossible : ce compte est désactivé.',
                'code' => 403
            ] ;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // -@- 7. Supprimer le code pour qu'il ne soit plus réutilisable
        $verification->delete();

        // -@- On retourne les informations de l'utilisateur et le token.
        return [
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];         
    }

    // 8. -@- Déconnexion de l'utilisateur
    public function logout($user) 
    {
        return $user->currentAccessToken()->delete();
    }
}
