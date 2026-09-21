<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $stats = $this->dashboardService->getGlobalStats();

        $users = User::all();

        if($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Statistiques récupérées avec succès',
                'data' => [
                    'stats' => $stats,
                    'users' => $users
                ]
            ]);
        }

        $userId= session('user_id');

        $user = User::find($userId);

        if(!$user) {
            return redirect()->route('login.show')->withErrors('Veuillez vous connecter.');
        }

        if($user->role !== 'admin') {
            return redirect()->route('me')->withError('Accès refusé');
        }

        return view('auth.dashboard', compact('stats', 'users', 'user'));
    }
}

