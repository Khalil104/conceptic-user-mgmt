<?php

// Gère l'accès aux données

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    public function getAll(array $filters)
{
    return \App\Models\User::query()
        // Filtre Nom : cherche si le nom contient la chaîne (insensible à la casse sur PGSQL)
        ->when(!empty($filters['name']), function ($query) use ($filters) {
            $query->where('name', 'ILIKE', '%' . $filters['name'] . '%');
        })
        // Filtre Statut : correspondance exacte
        ->when(!empty($filters['status']), function ($query) use ($filters) {
            $query->where('status', $filters['status']);
        })
        // Filtre Rôle : correspondance exacte
        ->when(!empty($filters['role']), function ($query) use ($filters) {
            $query->where('role', $filters['role']);
        })
        ->paginate(10);
    }

    public function findById(string $id) {
        return User::findOrFail($id);
    }

    public function update(string $id, array $data) {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete(string $id) {
        $user = $this->findById($id);
        return $user->delete();
    }
}

    