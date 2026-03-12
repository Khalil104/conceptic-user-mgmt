<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    public function getGlobalStats()
    {
        return [
            'users' => [
                'active' =>User::count(),
                'deleted' => User::onlyTrashed()->count(),
                'total_historical' => User::withTrashed()->count(),
            ],
            'activity' => [
                'created_today' => User::whereDate('created_at', Carbon::today())->count(),
                'updated_at' => User::whereDate('updated_at', Carbon::today())
                                                ->whereColumn('updated_at', '>', 'created_at')
                                                ->count(),
            ],
            'ratios' => [
                'retention_rate' => $this->calculateRetention(),
            ]
        ];
    }

    //
    public function getTrashedUsers()
    {
        // Retourne la liste des utilisateurs supprimés ainsi que leur date de suppression 
        return User::onlyTrashed()
            ->select('id', 'name', 'email', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }

    private function calculateRetention()
    {
        $total = User::withTrashed()->count();
        if ($total === 0) return 0;

        $active = User::count();
        return round(($active / $total) * 100, 2) .  '%';
    }
}