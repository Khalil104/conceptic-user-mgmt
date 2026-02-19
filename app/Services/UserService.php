<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    
    protected $userRepository;

        // Constructeur pour iniatialiser les l'accès au repository
    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
    }

    // Logique de création d'un utulisateur
    public function createUser(array $data) {

        return $this->userRepository->create($data);
    }
    // logique d'affichage des utilisateurs
    public function listUsers(array $filters) {
        return $this->userRepository->getAll($filters);
    }

    // Logique d'affichage d'un utilisateur via id
    public function getUserById(string $id) {
        return $this->userRepository->findById($id);
    }
}