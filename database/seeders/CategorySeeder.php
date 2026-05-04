<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Smartphones', 'slug' => 'smartphones'],
            ['name' => 'Ordinateurs portables', 'slug' => 'ordinateurs-portables'],
            ['name' => 'Consoles', 'slug' => 'consoles'],
            ['name' => 'Audio', 'slug' => 'audio'],
            ['name' => 'Tablettes', 'slug' => 'tablettes'],
            ['name' => 'Montres connectées', 'slug' => 'montres-connectees'],
            ['name' => 'Appareils électroménagers', 'slug' => 'electromenagers'],
            ['name' => 'Autres', 'slug' => 'autres'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}