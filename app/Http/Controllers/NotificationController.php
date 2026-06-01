<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected AuthRepository $authRepository;

    /**
     * Afficher les notifications (hybride JSON / Blade)
     */
    public function notifications(Request $request)
    {
        $user = $this->authRepository->getAuthenticatedUser();
    }
}
