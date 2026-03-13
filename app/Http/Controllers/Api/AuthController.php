<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Mail\RestoreAccountCode;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Mail;
use OpenApi\Attributes as OA;


#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[OA\Post(
        path: "/api/login",
        summary: "Étape 1 : Connexion initiale",
        description: "Vérifie les identifiants et envoie un code 2FA par email.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Code 2FA envoyé avec succès"),
            new OA\Response(response: 401, description: "Identifiants incorrects")
        ]
    )]
   public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->authService->login($credentials);

        // 1. On traite les échecs explicites
        if (isset($result['success']) && $result['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], $result['status'] ?? 401);
        }

        // 2. On vérifie qu'on a bien reçu un user_id avant de crier victoire
        if (!isset($result['user_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue est survenue.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful, please verify your email',
            'user_id' => $result['user_id']
        ], 200);
    }
    #[OA\Post(
        path: "/api/verify-2fa",
        summary: "Étape 2 : Validation du code 2FA",
        description: "Vérifie le code à 6 chiffres et génère le token final.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "user_id", type: "string", format: "uuid", example: "550e8400-e29b-41d4-a716-446655440000"),
                    new OA\Property(property: "code", type: "string", example: "123456")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Authentification réussie, token généré"),
            new OA\Response(response: 422, description: "Code invalide ou expiré")
        ]
    )]
    public function verify2FA(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'code' => 'required|string|size:6',
        ]);

        $result = $this->authService->verify2FACode($request->user_id, $request->code);

        if (!$result['success']) {
            // On s'assure d'utiliser 'status' ou 'code' selon ce que ton service renvoie
            $errorCode = $result['code'] ?? $result['status'] ?? 422;
            
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], $errorCode);
        }

        return response()->json($result);
    }

    #[OA\Get(
        path: "/api/dashboard",
        summary: "Récupérer l'utilisateur connecté/Accéder à son dashboard",
        tags: ["Auth"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Données utilisateur"),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    #[OA\Post(
        path: "/api/restore-account",
        summary: "Demander la restauration (OTP)",
        description: "Envoie un code de restauration si l'email correspond à un compte supprimé.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [new OA\Property(property: "email", type: "string", example: "admin@conceptic.io")]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Code envoyé"),
            new OA\Response(response: 404, description: "Utilisateur non trouvé")
        ]
    )]
    public function requestRestoration(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        // Chercher l'utilisateur dans la corbeille uniquement
        $user = User::onlyTrashed()->where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Aucun compte supprimé trouvé'
            ], 404);
        }

        $code = rand(100000, 999999);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        // On envoie le code par mail
        Mail::to($user->email)->send(new RestoreAccountCode($code));

        return response([
            'success' =>true,
            'message' => 'Un code de restauration a été envoyé sur votre boîte mail.'
        ]);
    }

    #[OA\Post(
        path: "/api/confirm-restore",
        summary: "Confirmer la restauration",
        description: "Valide le code OTP et restaure le compte (deleted_at -> null).",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "code", type: "string", example: "123456")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Compte restauré"),
            new OA\Response(response: 401, description: "Code invalide")
        ]
    )]
    public function confirmRestoration(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $user = User::onlyTrashed()->where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }

        // Vérification de l'existence du code dans la table DE CODES
        $verification = VerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'Code invalide ou expiré'
            ], 422);
        }

        // On restaure
        $user->restore();

        $user->notify(new \App\Notifications\AccountRestoreNotification());

        // On supprime le code utilisé
        $verification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Compte restauré avec succès ! Vous pouvez maintenant vous connecter ou restaurer votre mot de passe.',
            'can_login' => true
        ]);
    }

    #[OA\Post(
        path: "/api/logout",
        summary: "Déconnexion",
        tags: ["Auth"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Déconnexion réussie")
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        // On passe l'objet User à la méthode logout du service
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
