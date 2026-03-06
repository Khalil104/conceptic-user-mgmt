<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\JsonReponse;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller {
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    // Format attendues lors de la connexion
    public function login (Request $request) : JsonResponse {
        $credentials = $request ->validate ([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->authService->login($credentials);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $result
        ]);
    }

    // Vérification 2FA 
    public function verify2FA(Request $request): JsonResponse {
        $request ->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'code' => 'required|string|size:6',
        ]);

        $result = $this->authService->verify2FACode($request->user_id, $request->code);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], $result['code']);
        }
        
        return response()->json($result);
    }

    // Fonction pour récupérer l'utilisateur connecté.
    public function me(Request $request): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => $request->user() // Sanctum injecte l'user ici
        ]);
    }

    // Fonction pour déconnecter l'utilisateur
    public function logout(Request $request): JsonResponse {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}