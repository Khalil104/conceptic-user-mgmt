<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'code', 
        'expires_at'
    ];

    // -@- Vérification : es ce que le code est encor valide ?
    public function isExpired(): bool 
    {
        return now()->gt($this->expires_at);
    }

    // Si on veux que Laravel gère automatiquement les dates
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
