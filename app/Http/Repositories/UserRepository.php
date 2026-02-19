<?php

// Gère l'accès aux données

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    //
    public function create(array $data) {
        return User::create($data);
    }

    //
    public function getAll(array $filters = []) {
        $query = User::query();

        if(isset($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%'); 
        }

        return $query->paginate(10);
    }

    //
    public function getAllPaginated(array $filters) {
        $query = User::query();

        // Filtre par nom (recherche partielle)
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        // Filtres exacts (status et role)
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        return $query->paginate(10); // Liste paginée 
    }

    /**
     * Trouver un utilisateur par son UUID
     */
    public function findById(string $id) {
        return User::findOrFail($id);
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(string $id, array $data) {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    /**
     * Supprimer un utilisateur
     */
    public function delete(string $id) {
        $user = $this->findById($id);
        return $user->delete();
    }
}