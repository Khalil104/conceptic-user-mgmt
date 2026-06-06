<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use  Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;
use App\Notifications\UserRoleChangedNotification;
use InvalidArgumentException;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;

class UserService
{

    protected UserRepository $userRepository;

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
    // logique d'affichage des utilisateurs
    public function listUsers(array $filters)
    {
        return $this->userRepository->All($filters);
    }

    // Logique d'affichage d'un utilisateur via id
    public function getUserById(string $id)
    {
        return $this->userRepository->find($id);
    }

    
    public function updateField(string $id, string $field, mixed $value): User
    {
        // -@- Récupérons l'user avant update pour comparer
       $user = $this->userRepository->find($id);

       // -@- Validons la logique métier
       if($field === 'email') {
            // Vérifions si cet emil est déjà pris par un autre utilisateur
            $emailExists = User::where('email', $value)->where('id', '!=', $id)->exists();
            if($emailExists) {
                throw new InvalidArgumentException("L'email est déjà utilisé par un autre utilisateur.");   
            }
       }

       if($field === 'status') {
            $validateStatuses = ['active', 'inactive', 'suspended', 'deleted'];
            if(!in_array($value, $validateStatuses)) {
                throw new InvalidArgumentException("Le statut doit être exactement : active | inactive | suspended | deleted");
            }
        }
        // -@- Sauvegardons via le repository
        $updatedUser = $this->userRepository->update($id, [$field => $value]);

        // -@- Déclenchons la notification si le rôle ou le statut a changé
        if($field === 'role' && $user->role != $value) {
            $updatedUser->notify(new UserRoleChangedNotification($value));
        }

        // ajoutons plupart une notification spécifique si le statut change.
        if($field === 'status' && $user->status !== $value) {
            // Ex: $updatedUser->notify(new UserStatusChangedNotification($value));
        }
       
        return $updatedUser;
    }

   public function deleteUser(string $id)
   {
    return $this->userRepository->delete($id);
   }

   /**
    * Exportons des utilisateurs
    */
   public function exportUsers()
   {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "utilisateurs_{$timestamp}.xlsx";

        return Excel::download (
            new UsersExport, 
            $filename,
            ExcelWriter::XLSX,
            [
                'Content-type' =>'text/xlsx',
            ]
        );
    }
}
