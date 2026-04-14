<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
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

     public function showRegister() {
        return view('public.register');
    }

    #[OA\Post(
        path: "/users",
        summary: "Créer un utilisateur",
        tags: ["Users"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/User")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Utilisateur créé avec succès",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Operation successful"),
                        new OA\Property(property: "data", ref: "#/components/schemas/User")
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Erreur de validation"),
            new OA\Response(response: 500, description: "Erreur interne")
        ]
    )]
    public function  register(CreateUserRequest $request)
    {
        $result = $this->authService->createUser($request->validated());

        if($request->expectsJson()) {
            return response()->json($result, $result['status']);
        }

        return view('auth.register_success')->with('Compte créé avec succès ! Vérifiez votre boîte mail pour activer votre compte.');

    }

    //
    public function showLogin()
    {
        return view('public.login');
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
   public function login(Request $request)
   {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login($credentials);

        // 1. Echec explicite.
        if(!$result['success']) {
            if($request->expectsJson()) {
                return response()->json($result, $result['status']);
            }
            if(!empty($result['can_restore'])) {
                session(['user_id' => $credentials['email']]);
                return redirect()->route('account-disabled.show')->withErrors($result['message']);
            }
            return back()->withErrors($result['message']);
        }

        if ($request->expectsJson()) {
            return response()->json($result, 200);
        }

        session([
            'user_id' => $result['user_id']
        ]);

        return redirect()->route('verify-2fa.show')->with('success', $result['message']);
   }

    public function showVerify()
    {
        return view('public.verify-2fa');
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
    public function verify2fa(Request $request)
    {

        $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'code' => 'required|string|size:6',
        ]);

        $result = $this->authService->verify2fa($request->user_id, $request->code);

        // Gestion des erreurs
        if (!$result['success']) {
            $errorCode = $result['code'] ?? $result['status'] ?? 422;

            if($request->expectsJson()) {
                return response()->json($result, $errorCode);
            }

            return back()->withErrors($result['message']);
        }

        // Succès
        if($request->expectsJson()) {
            return response()->json($result, 200);
        }

        $user = User::find($request->user_id);

        session(['user_id' => $user->id]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue Admin !');
        }

        return redirect()->route('me')->with('success', 'Compte vérifié avec succès !');
    }

    public function about() {
        return view('auth.about');
    }

    public function settings() {
        return view('auth.settings');
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
    public function me(Request $request)
    {

        $result = $this->authService->getAuthenticatedUser($request);

        if ($request->expectsJson()) {
            return response()->json($result, $result['status']);
        }

        if (!$result['success']) {
            return redirect()->route('login.show')->withErrors($result['message']);
        }

        return view('auth.me', ['user' => $result['data']]);
    }

    //
    public function processDisabled(Request $request)
    {
        if ($request->choice === 'yes') {
            $result = $this->authService->requestRestoration($request->email);

            if ($request->expectsJson()) {
                return response()->json($result, $result['status']);
            }

            if (!$result['success']) {
                return back()->withErrors($result['message']);
            }

            return redirect()->route('login.show')->with('info', 'Restauration annulé');
        }
    }

    //
    public function showRestore()
    {
        return view('auth.restore');
    }

    //
    public function requestRestoration(Request $request) {

        $result = $this->authService->requestRestoration($request->email);

        if($request->expectsJson()) {
            return response()->json($request, $result['status']);
        }

        if(!$result['success']) {
            return back()->withErrors($result['message']);
        }


        return redirect()->route('restore-account.show')->with('success', $result['message']);
    }

    //
    public function confirmRestoration(Request $request)
    {
        $result = $this->authService->confirmRestoration($request->email, $request->code);

        if($request->expectsJson()) {
            return response()->json($result, $result['status']);
        }

        if(!$result['success']) {
            return back()->withErrors($result['message']);
        }

        //
        session(['user_id' => $result['data']->id]);

        return redirect()->route('me')->with('success', $result['message']);
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
    public function logout(Request $request)
    {
        $user = $request->expectsJson() ? $request->user() : User::find(session('user_id'));

        if($request->expectsJson()) {
            if($user) {
                $this->authService->logout($user, true);
            }

            return response()->json([
                'success' =>true,
                'message' =>'Déconnexion réussie',
            ], 200);
        }

        $this->authService->logout($user, false);

        session()->forget('user_id');

        return redirect()->route('login.show')->with('success', 'Vous avez été déconnecté');
    }
}
