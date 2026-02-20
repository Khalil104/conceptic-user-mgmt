<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    // crée un nouvel enregistrement dans la table users
    public function create(array $data) {
        return User::create($data);
    }

    // On initialise une requête sur le modèle User
    public function getAll(array $filters = []) {
        $query = User::query();
        
        // if un filtre name est fourni, on ajoute une condition 
        // sur la colonne name.
        if(isset($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%'); 
        }

        // Filtre exact (status)
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filtres exact (role)
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

    // Modifier un user à partir de son id
    public function update(string $id, array $data) {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    // Supprimer un utilisateur à partir de son id
    public function delete(string $id) {
        $user = $this->findById($id);
        return $user->delete();
    }
}