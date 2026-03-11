<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    
    // crée un nouvel enregistrement dans la table users
    public function create(array $data) 
    {
        return User::create($data);
    }

    // On initialise une requête sur le modèle User
    public function All(array $filters = []) 
    {
        $query = User::query();
        
        // if un filtre name est fourni, on ajoute une condition 
        // sur la colonne name.
        if(isset($filters['name'])) {
            $query->where('name', 'ilike', '%' . $filters['name'] . '%'); 
        }

        if(isset($filters['email'])) {
            $query->where('email', $filters['email']);
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
    public function find(string $id) 
    {
        return User::findOrFail($id);
    }

    // Trouver un utilisateur actif par son email
    public function findByEmail(string $email)
    {
        // ne trouvera que les utilisateurs où deleted_at est NULL
        return User::where('email', $email)->first();
    }

    // Trouver un utilisateur uniquement parmi les supprimés.
    public function findTrashedByEmail(string $email)
    {
        return User::onlyTrashed()->where('email', $email)->first();
    }

    // Modifier un user à partir de son id
    public function update(string $id, array $data) 
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    // Supprimer un utilisateur à partir de son id
    public function delete(string $id) 
    {
        $user = $this->find($id);
        return $user->delete();
    }
} // end of the class UserRepository
