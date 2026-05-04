<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Créer un Admin
        User::create([
            'name' => 'Admin Apex',
            'email' => 'admin@apex.tn',
            'password' => Hash::make('password'),
            'role' => 'admin', // Assure-toi d'avoir cette colonne dans ta table users
        ]);

        // 2. Créer un Vendeur/Acheteur de test (Ghaith)
        User::create([
            'name' => 'Ghaith Oueslati',
            'email' => 'ghaith@apex.tn',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 3. Lancer le seeder des catégories
        $this->call(CategorySeeder::class);
        
        // 4. Tu peux ajouter un ProductSeeder ici plus tard
    }
}