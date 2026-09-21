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

    public function isExpired(): bool 
    {
        return now()->gt($this->expires_at);
    }

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
