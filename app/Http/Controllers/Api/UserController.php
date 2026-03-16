<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "User Management API",
    version: "1.0.0",
    description: "Documentation de l'API de gestion des utilisateurs",
    contact: new OA\Contact(email: "rachidbissare@gmail.com")
)]
#[OA\Server(url: "/api", description: "Serveur Local")]
#[OA\Schema(
    schema: "User",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "role", type: "string"),
        new OA\Property(property: "status", type: "string")
    ]
)]
class UserController extends Controller 
{
    protected $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

     #[OA\Get(
        path: "/users",
        summary: "Liste des utilisateurs",
        tags: ["Users"],
        parameters: [
            new OA\Parameter(name: "name", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "role", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "status", in: "query", schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste récupérée",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/User"))
                    ]
                )
            )
        ]
    )]
    public function all(Request $request): JsonResponse 
    {
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
    public function register(CreateUserRequest $request): JsonResponse 
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return response()->json([
                "success" => true,
                "message" => "Inscription réussie !",
                "data" => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Internal server error",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[OA\Get(
        path: "/users/{id}",
        summary: "Détail d'un utilisateur",
        tags: ["Users"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Succès",
                content: new OA\JsonContent(properties: [new OA\Property(property: "data", ref: "#/components/schemas/User")])
            ),
            new OA\Response(response: 404, description: "Non trouvé")
        ]
    )]
    public function find(string $id): JsonResponse 
    {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json([
                "success" => true,
                "data" => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User not found",
                "error" => $e->getMessage()
            ], 404);
        }
    }

    #[OA\Put(
        path: "/users/{id}",
        summary: "Modifier un utilisateur",
        tags: ["Users"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "string"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/User")
        ),
        responses: [
            new OA\Response(response: 200, description: "Mis à jour"),
            new OA\Response(response: 500, description: "Erreur")
        ]
    )]
    public function update(UpdateUserRequest $request, string $id): JsonResponse 
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return response()->json([
                "success" => true,
                "message" => "User updated",
                "data" => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "update failed",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    #[OA\Delete(
        path: "/users/{id}",
        summary: "Supprimer un utilisateur",
        tags: ["Users"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Supprimé"),
            new OA\Response(response: 500, description: "Erreur")
        ]
    )]
    public function delete(string $id): JsonResponse 
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json([
                "success" => true,
                "message" => "User deleted"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Delete failed",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
