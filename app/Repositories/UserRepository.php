<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    // crée un nouvel enregistrement dans la table associé aux modèles
    public function create(array $data) {
        return User::create($data);
    }

    //Récupère à travers un tableau tous les users en utilisant $query 
    // pour terminer spécifier les contraintes
    public function getAll(array $filters = []) {
        $query = User::query();
        
        // filtre exact sur le nom peu importe la casee
        if(isset($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%'); 
        }

        // Filtres exacts (status et role)
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // limite l'affichage à résultats
        return $query->paginate(10);
    }

    // Trouver un utilisateur par son UUID
    public function findById(string $id) {
        return User::findOrFail($id);
    }
}