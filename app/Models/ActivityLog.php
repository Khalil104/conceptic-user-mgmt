<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    // On définit les champs insérables en masse 

    protected $fillable =[
        'user_id',
        'action',
        'description',
        'changes',
        'ip_address',
        'user_agent'
    ];

    // Stocker les changements sous forme de tableau propre.
    protected $casts = [
        'changes' => 'array'
    ];

    /**
     * Un log d'activité appartient à un utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
