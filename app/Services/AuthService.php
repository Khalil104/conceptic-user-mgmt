<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationCode;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use App\Mail\RestoreAccountCode;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    
    protected $authRepository;

    public function __construct(AuthRepository $authRepository) 
    {
        $this->authRepository = $authRepository;
    }

    public function createUser(array $data) 
    {
        // Hash obligatoire
        $data['password'] = Hash::make($data['password']);
        
        $user = $this->authRepository->create($data);

        return [
            'success' => true,
            'message' => 'Compte créé avec succès ! Vérifiez votre boîte mail pour activer votre compte',
            'data' => $user,
            'status' => 200
        ];
    }

    // -@- Connexion d'un utilisateur
    public function login(array $credentials) 
    {
        // -@- Etape 1 : On cherche l'utilisateur actif ou supprimé.

        $user = $this->authRepository->findUserByEmail($credentials['email']);

        if (!$user || !$this->authRepository->verifyPassword($user, $credentials['password'])) {
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
        $this->authRepository->createVerificationCode($user->id, $code);

        // -@- Envoi de l'email
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        return [
            'success' => true,
            'status' => '2FA_REQUIRED',
            'message' => 'Un code de vérification a été envoyé à votre adresse mail.',
            'user_id' => $user->id
            // 'dev_debug_code' => $code 
        ];
    }

    // -@- Vérification 2FA
    public function verify2fa(string $userId, string $code) 
    {
        $verification = $this->authRepository->findVerificationCode($userId);
      
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

    public function getAuthenticatedUser($request)
    {
        $user = $this->authRepository->getAuthenticatedUser($request);

        if(!$user) {
            return [
                'success' => false,
                'message' => 'Non authentifié',
                'status' => 401
            ];
        }

        return [
            'success' => true,
            'message' => 'Utilisateur connecté récupéré avec succès',
            'data' => $user,
            'status' => 200
        ];
    }

    // -@- 
    public  function requestRestoration(string $email) 
    {
        $user = $this->authRepository->findUserTrashed($email);

        if(!$user) {
            return [
                'success' => false,
                'message' => 'Aucun compte supprimé trouvé',
                'status' => 404
            ];
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->authRepository->createVerificationCode($user->id, $code);

        Mail::to($user->email)->send(new RestoreAccountCode($code));

        return [
            'success' => true,
            'message' => 'Un code de vérification a été envoyé sur votre boîte mail.',
            'status' => 200
        ];
    }

    public function confirmRestoration(string $email, string $code) 
    {
        $user = $this->authRepository->findUserTrashed($email);

        if(!$user) {
            return [
                'success' => false,
                'message' => 'Utilisateur introuvable',
                'status' => 404
            ];
        }

        $verification = $this->authRepository->findRestaurationCode($user->id, $code);

        if(!$verification) {
            return [
                'success' => false,
                'message' => 'code invalide ou expiré',
                'status' => 422
            ];
        }

        $this->authRepository->restore($user);
        $verification->delete();

        $user->notify(new \App\Notifications\AccountRestoreNotification());

        return [
            'success' => true,
            'message' => 'Compte restauré avec succès',
            'status' => 200,
            'data' => $user
        ];
    }

    // 8. -@- Déconnexion de l'utilisateur
    public function logout($user, bool $api = true) 
    {
        if($api) {
            return $user->currentAccessToken()->delete();
        }

       /** @var \Illuminate\Contracts\Auth\StatefulGuard $guard */
        $guard = auth();
        $guard->logout(); 
        
        session()->invalidate();
        session()->regenerateToken();

        return true;

    }
}