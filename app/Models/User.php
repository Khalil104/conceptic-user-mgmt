<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use SoftDeletes, HasUuids, HasFactory, Notifiable, HasApiTokens;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    // variables protégés
    protected $fillable = [
        'name',
        'email',
        'password',
        'activate_token',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
