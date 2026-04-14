<?php

namespace App\Services;

use App\Repositories\UserRepository;
use  Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;

class UserService
{

    protected $userRepository;

    // Constructeur pour initialiser l'accès au repository
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //
    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }
    // logique d'affichage des utili sateurs
    public function listUsers(array $filters)
    {
        return $this->userRepository->All($filters);
    }

    // Logique d'affichage d'un utilisateur via id
    public function getUserById(string $id)
    {
        return $this->userRepository->find($id);
    }

    // logique de modification d'un utilisateur via son id
    public function updateUser(string $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function changeUserStatus(string $id, string $status)
    {
        return $this->userRepository->changeStatus($id, $status);
    }

   public function deleteUser(string $id)
   {
    return $this->userRepository->delete($id);
   }
}
