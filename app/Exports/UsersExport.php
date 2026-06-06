<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return User::query()->withTrashed();
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Nom', 
            'Email', 
            'Rôle', 
            'Statut', 
            'Date Création', 
            'Date Suppression', 
            'Taux Rétention (jours)'
        ];
    }

    public function map($user): array
    {
        $created = $user->created_at;
        $deleted = $user->deleted_at;
        $retentionDays = $deleted 
            ? $created->diffInDays($deleted) 
            : $created->diffInDays(now());

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role ?? 'user',
            $user->status,
            $created->format('d/m/Y H:i'),
            $deleted?->format('d/m/Y H:i'),
            $retentionDays . ' jours',
        ];
    }

    /**
     * Stylisons l'en-tête
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
    }
}