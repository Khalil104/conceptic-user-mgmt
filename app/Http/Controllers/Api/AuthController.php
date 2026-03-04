<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller {
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login (Request $request) : JsonResponse {
        $credentials = $request ->validate ([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->authService->login($credentials);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'INvalid credentials'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $result
        ]);
    }

        public function logout(Request $request): JsonResponse {
            $this->authService->logout($request->user());

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        }
}