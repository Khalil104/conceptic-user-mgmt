<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id, // A la création, c'est l'ID du nouvel utilisateur
            'action' => 'user_created',
            'description' => "L'utilisateur {$user->email} a créé son compte.",
            'changes' => json_encode(['after' => $user->toArray()]),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent')
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id ?? session('user_id') ?? $user->id,
            'action' => 'user_updated',
            'description' => "L'utilisateur {$user->email} a été mis à jour.",
            'changes' => json_encode([
                'before' => array_intersect_key($user->getOriginal(), $user->getDirty()),
                'after' => $user->getChanges()
            ]),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent')
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id ?? session('user_id') ?? $user->id,
            'action' => 'user_deleted',
            'description' => "Le compte de l'utilisateur {$user->email} a été désactivé (Soft deleted)",
            'change' => null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent')
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id, // C'est l'utilisateur lui même qui valide son code.
            'action' => 'user_restored',
            'description' => "Le compte de l'utilisateur {$user->email} a été restauré avec succès",
            'changes' => null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User_Agent')
        ]);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
