<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BoutiqueController extends Controller
{
    public function index()
    {
        $products   = Product::with('category')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        $categories     = Category::orderBy('name')->get();
        $latestProducts = Product::with(['category', 'user'])
                            ->withCount('reviews')
                            ->orderBy('created_at', 'desc')
                            ->limit(8)
                            ->get();
        $recommended    = collect();

        return view('boutique.index', compact('products', 'categories', 'latestProducts', 'recommended'));
    }
}