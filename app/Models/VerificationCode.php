<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $filliable = ['user_id', 'code', '(expires_at'];

    // Vérification : es ce que le code est encor valide ?
    public function isExpired(): bool {
        return now()->gt($this->expires_at);
    }
}
