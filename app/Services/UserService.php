<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
    }

    /**
     * Logique de création :
     */

    public function createUser(array $data) {

        return $this->userRepository->create($data);
    }

    public function listUsers(array $filters) {
        return $this->userRepository->getAll($filters);
    }

    public function getUserById(string $id) {
        return $this->userRepository->findById($id);
    }

    public function updateUser(string $id, array $data) {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(String $id) {
        return $this->userRepository->delete($id);
    }
}