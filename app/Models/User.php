<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    
    use HasApiTokens, HasUuids, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false; 
    
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

    protected function casts(): array {
        // Au lieu de hacher le mot de passe ici, cela aurait pu se 
        // faire dans le userService ou le userController via la fonction Hash::make
        return [
            // Hashage automatique du password
            'password' => 'hashed', 
        ]; // end of the function casts
    }
} // end of the class User--extends
