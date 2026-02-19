<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    
    protected $userRepository;

    // Constructeur pour iniatialiser les l'accès au repository
    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
    }

    // Logique de création d'un user
    public function createUser(array $data) {

        return $this->userRepository->create($data);
    }
    // Logique d'affichage des users
    public function listUsers(array $filters) {
        return $this->userRepository->getAll($filters);
    }
}