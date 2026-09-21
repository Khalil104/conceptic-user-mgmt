<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Afficher l'historique des activités
     */
    public function index(Request $request)
    {
        // Récupération du logs et des activités de l'utilisateur (Eager Loading)
        $logs = ActivityLog::with('user')->latest()->paginate(15);

        // Si la requete demande du JSON (Postman)
        if($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $logs
            ], 200);

            // Sinon, on renvoie la vue Blade pourle navigateur
            return view('admin.logs.index', compact('logs'));
        }
    }
}
