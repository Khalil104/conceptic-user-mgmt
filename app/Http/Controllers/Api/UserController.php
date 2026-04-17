<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
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

    public function index() {
        return view("index");
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

     public function updateShow($id,  $field)
    {
        $user = User::findOrFail($id);
        return view('auth.update', compact('user', 'field'));
    }

    public function edit(Request $request, string $id, string $field)
    {
        $user = $this->userService->getUserById($id);
         if ($request->expectsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Edition du champ $field",
                "data" => $user
            ], 200);
         }

         return view('auth.update', compact('user', 'field'));
    }
    public function update(Request $request, $id, $field)
    {
        $user = User::findOrFail($id);
        $user->$field = $request->input($field);

        if($request->email === $user->email) {

            if($request->expectsJson()) {
                return response()->json([
                    "success" =>false,
                    "message" => "L'email est déjà utilisé par un autre utilisateur.",
                ], 401);
            }

            return back()->withErrors('L\'email est déjà utilisé par un autre utilisateur.');
        }

        if($request->status !== $user->status) {

            if($request->expectsJson()) {
                response()->json([
                    "success" =>false,
                    "message" => "Le statut doit être exactement : active | inactive | suspended | deleted"
                ], 401);
            }
            return back()->withErrors('Le statut doit être exactement : active | inactive | suspended | deleted');
        }

        $user->save();

        if($request->expectsJson()) {
            return response()->json([
                "success" => true,
                'message' => "Champ $field mis à jour avec succès",
                "data" =>$user
            ], 200);
        }

        return redirect()->route('me')->with('succès', "Votre $field a été mis à jour !");
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
   public function delete(Request $request, string $id)
   {
    try {
        $this->userService->deleteUser($id);

        if($request->expectsJson()) {
            return response()->json([
                "success" =>true,
                "message" =>"Utilisateur supprimé avec succès"
            ], 200);
        }

        return back()->with('success', 'Utilisateur supprimé');

    } catch( \Exception $e) {
        if($request->expectsJson()) {
            return response()->json([
                "success" => false,
                "message" =>"Echec de la suppression",
                "error" =>$e->getMessage()
            ], 500);
        }

        return back()->withErrors('Erreur lors de la suppression' .$e->getMessage());
    }
   }
}
