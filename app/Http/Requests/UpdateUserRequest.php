<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest 
{
    
 
     public function authorize(): bool 
    {
        return true; 
    }

    public function rules(): array  {
        // On récupère l'ID de l'utilisateur depuis l'URL de la route : /api/users/{id}
        // Cela permet de savoir quel utilisateur est en cours de update.
        $userId = $this->route('user'); 

        return [
          
            'name'  => 'sometimes|string|max:255',
          
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            
            'password' => 'sometimes|string|min:8',
          
            'status'   => 'sometimes|in:active,inactive,suspended,deleted',
            
            'role'     => 'sometimes|in:admin,user',
        ];
    }
}
