<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Utilisateur::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sgpe.tg')],
            [
                'nom' => 'Admin',
                'prenom' => 'SGPE',
                'mot_de_passe' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe!2026')),
                'role' => 'admin',
                'statut' => 'Actif',
            ]
        );
    }
}
