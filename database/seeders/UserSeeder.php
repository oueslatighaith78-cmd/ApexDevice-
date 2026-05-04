<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer l'ADMIN (pour Rayen)
        User::updateOrCreate(
            ['email' => 'admin@apex.tn'],
            [
                'name' => 'Rayen Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Créer un VENDEUR/USER (pour Ghaith)
        User::updateOrCreate(
            ['email' => 'ghaith@apex.tn'],
            [
                'name' => 'Ghaith Oueslati',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Créer un autre USER (pour tester les messages)
        User::updateOrCreate(
            ['email' => 'test@apex.tn'],
            [
                'name' => 'Ahmed Client',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}