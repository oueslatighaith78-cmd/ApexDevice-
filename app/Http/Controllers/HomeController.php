<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ─── Catégories pour le grid et la navbar
        $categories = Category::withCount('products')->get();

        // ─── Derniers produits (avec filtrage et tri)
        $query = Product::with(['category', 'user'])
                        ->withCount('reviews');

        // Filtrage par catégorie
        if ($request->filled('cat')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->cat));
        }

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Tri
        match($request->tri) {
            'prix-asc'   => $query->orderBy('price', 'asc'),
            'prix-desc'  => $query->orderBy('price', 'desc'),
            'populaire'  => $query->orderBy('reviews_count', 'desc'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        $latestProducts = $query->limit(8)->get();

        // ─── Recommandations (Bonus Niveau 3)
        // On stocke la catégorie du dernier produit visité en session
        $recommended = collect();

        if (session('last_category_id')) {
            $recommended = Product::with(['category', 'user'])
                ->withCount('reviews')
                ->where('category_id', session('last_category_id'))
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        }

        // Si pas de session → on affiche les plus récents par défaut
        if ($recommended->isEmpty()) {
            $recommended = Product::with(['category', 'user'])
                ->withCount('reviews')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        }

        return view('home', compact('categories', 'latestProducts', 'recommended'));
    }
}