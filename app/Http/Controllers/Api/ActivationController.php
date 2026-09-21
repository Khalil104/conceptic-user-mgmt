<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class ActivationController extends Controller
{
    //
    public function activate(string $token)
    {
        $user = User::where('activate_token', $token)->first();

        if(!$user) {
            return redirect()->route('login.show')->withErrors('Lien d\'activation invalide ou expiré');
        }

        // Activation du compte
        $user->activate_token = null;
        $user->status = 'active';
        $user->save();

        return redirect()->route('me')->with('success', 'Votre compte a été activé avec succès !');
    }
}
