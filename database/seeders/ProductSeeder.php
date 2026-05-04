<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // On récupère le premier utilisateur (Vendeur)
        $user = User::where('role', 'user')->first();
        
        // On récupère quelques catégories par leur slug
        $catPhones = Category::where('slug', 'smartphones')->first();
        $catLaptops = Category::where('slug', 'ordinateurs-portables')->first();
        $catConsoles = Category::where('slug', 'consoles')->first();

        $products = [
            [
                'title' => 'iPhone 15 Pro Max - 256Go',
                'description' => 'État comme neuf, batterie 100%. Vendu avec boîte et accessoires originaux.',
                'price' => 4200,
                'category_id' => $catPhones->id ?? 1,
                'user_id' => $user->id,
                // 'image' => 'products/iphone15.jpg', // Optionnel si tu as des images
            ],
            [
                'title' => 'MacBook Pro M2 - 16Go RAM',
                'description' => 'Puissant et rapide pour le montage vidéo et le développement.',
                'price' => 5800,
                'category_id' => $catLaptops->id ?? 2,
                'user_id' => $user->id,
            ],
            [
                'title' => 'PlayStation 5 Édition Standard',
                'description' => 'Console avec une manette DualSense. Très peu utilisée.',
                'price' => 1850,
                'category_id' => $catConsoles->id ?? 3,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Excellent appareil photo, stylet inclus. Écran parfait.',
                'price' => 3100,
                'category_id' => $catPhones->id ?? 1,
                'user_id' => $user->id,
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}