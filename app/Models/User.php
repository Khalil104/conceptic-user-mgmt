<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids, Notifiable;

    // variables protégés
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
    ];

    
    protected $hidden = [
        'password', // le mot de passe est caché dans le JSON
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            // Hashage automatique du password
            'password' => 'hashed', 
        ];
    }
}
