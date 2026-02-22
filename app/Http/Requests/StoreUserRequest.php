<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest {
      // Toute les requêtes sont autorisées (pas de logique d'autorisation spécifique)
    public function authorize(): bool {
        return true;
    } // end of the function authorize

   // Récupérer la règle de validation à appliquer à la requête
    public function rules(): array {
        return [
            // le nom est requis (obligatoire), est un string et doit comporter au minimum 3 lettres.
            'name' => ['required', 'string', 'min:3'],
            // l'email est obligatoire, est unique(aucun autre user ne peut s'inscrire avec. )
            'email' => ['required', 'email', 'unique:users,email'],
            // le mot de pass est requis, est une chaine de caractère et comporte au minimum 8 caractère !
            'password' => ['required', 'string', 'min:8'],
            // le status possible d'un utilisateur est : inactif, actif, suspendu ou bani.
            'status' => ['required', Rule::in(['inactive', 'active', 'suspended', 'deleted'])],
            // Les utilisateurs sont de de deux types : Admin ou user
            'role' => ['required', Rule::in(['admin', 'user'])],
        ];
    } // end of the function rules
}