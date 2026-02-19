<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Response;

class UserController extends Controller {

    protected $userService;

    // Constructeur qui initialise le userService
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    } // fin du constructeur

    // Fonction pour créer un utilisateur. Il envoit la réponse sous le format JSON
    // On utilise les blocks try ... catch pour capturer les éventuels erreurs et les afficher 
    //de façon bien structurer.

    public function store(StoreUserRequest $request): JsonResponse {
        try {
            $user = $this->userService->createUser($request->validated());
            return response()->json([
                "success" => true,
                "message" => "Operation successful",
                "data" => $user
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Internal server error",
                "error" => $e->getMessage()
            ], 500);
        }
    } // fin de la fonction store
    
    // Fonction pour afficher la liste des utilisateurs créer dans un format JSON
    // Capturer également les éventuels erreurs et les afficher correctement
    public function index(\Illuminate\Http\Request $request): JsonResponse {
        try {
            $filters = $request->only(['name', 'status', 'role']);
            $users = $this->userService->listUsers($filters);

            return response()->json([
                "success" => true,
                "message" => "Operation successful",
                "data" => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Internal server error",
                "error" => $e->getMessage()
            ], 500);
        }
    } // fin de la fonction index()

    // Fonction pour afficher les informations de l'utilisateur avec pour id::id
    public function show(string $id): JsonResponse {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json(["success" => true, "data" => $user], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => "User not found"], 404);
        }
    }
} // Fin de la classe UserController