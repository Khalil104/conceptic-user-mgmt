<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest {
    
    // Toute les requêtes sont autorisées (pas de logique d'autorisation spécifique)
     public function authorize(): bool {
        return true; 
    } // end of the function authorize

    public function rules(): array  {
        // On récupère l'ID de l'utilisateur depuis l'URL de la route : /api/users/{id}
        // Cela permet de savoir quel utilisateur est en cours de update.
        $userId = $this->route('user'); 

        return [
            // lors de la recherche les champs name sont optionnels mais dès qu'il 
            // est entrer il doit rester la règle qui suit : 
            
            //être au maximum une chaîne de 255 caractères. 
            'name'  => 'sometimes|string|max:255',
            // email valide et unique dans la table users
            'email' => [
                'sometimes',
                'email',
                // ignore() empêche qu'un email déjà utilisé par un autre user soit 
                //attribué à celui qu'on veut mettre à jour. 
                Rule::unique('users', 'email')->ignore($userId),
            ],
            // le mot de passe doit avoir au minimum 8 caractère
            'password' => 'sometimes|string|min:8',
            // le nouveau statut qu'il entre soit figuré dans le in:
            'status'   => 'sometimes|in:active,inactive,suspended,deleted',
            // le rôle qu'il choisit doit figuré dans le in:
            'role'     => 'sometimes|in:admin,user',
        ];
    } // end of the function rules
}