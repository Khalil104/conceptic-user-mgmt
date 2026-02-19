<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest; // Assure-toi que l'import est là
use App\Services\UserService;
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Response;

class UserController extends Controller {
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

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
    }

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
    } // Fin de store

    public function show(string $id): JsonResponse {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json(["success" => true, "data" => $user], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => "User not found"], 404);
        }
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return response()->json(["success" => true, "message" => "User updated", "data" => $user], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => "Update failed"], 500);
        }
    }

    public function destroy(string $id): JsonResponse {
        try {
            $this->userService->deleteUser($id);
            return response()->json(["success" => true, "message" => "User deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => "Delete failed"], 500);
        }
    }

    // Ajoute ta méthode index() ici si tu l'avais déjà faite !

} // Fin de la classe UserController