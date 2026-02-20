<?php

namespace App\Services;

use App\Repositories\UserRepository;

// Appelle à chaque fois le repository et fais l'enregistrement
class UserService {
    
    protected $userRepository;

    // Constructeur pour initialiser l'accès au repository
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    // Logique de création d'un utilisateur
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

    // logique de modification d'un utilisateur via son id
    public function updateUser(string $id, array $data) {
        return $this->userRepository->update($id, $data);
    }

    //logique de suppression d'un utilisateur
     public function deleteUser(String $id) {
        return $this->userRepository->delete($id);
    }
}