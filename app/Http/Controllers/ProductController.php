<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ── Catalogue public
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user'])->withCount('reviews');

        if ($request->filled('cat')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->cat));
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        match($request->tri) {
            'prix-asc'  => $query->orderBy('price', 'asc'),
            'prix-desc' => $query->orderBy('price', 'desc'),
            'populaire' => $query->orderBy('reviews_count', 'desc'),
            default     => $query->latest(),
        };

        $products   = $query->paginate(12);
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    // ── Fiche produit
    public function show(Product $product)
    {
        $product->load(['user', 'category', 'reviews.user']);

        if (!$product->user) {
            abort(404, 'Vendeur introuvable');
        }

        // Stocker la catégorie en session pour les recommandations
        session(['last_category_id' => $product->category_id]);
        session(['last_category'    => $product->category->name ?? 'Populaires']);

        $related = Product::with('category')
                          ->where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->latest()->take(4)->get();

        return view('products.show', compact('product', 'related'));
    }

    // ── Ma Boutique
    public function boutique()
    {
        $products       = Product::with('category')
                            ->where('user_id', Auth::id())
                            ->latest()->get();
        $categories     = Category::orderBy('name')->get();
        $latestProducts = Product::with(['category', 'user'])
                            ->withCount('reviews')
                            ->orderBy('created_at', 'desc')
                            ->limit(8)->get();
        $recommended    = collect();

        return view('boutique.index', compact('products', 'categories', 'latestProducts', 'recommended'));
    }

    // ── Formulaire création
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('boutique.create', compact('categories'));
    }

    // ── Enregistrer produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id'     => Auth::id(),
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'image'       => $imagePath,
        ]);

        return redirect()->route('boutique.index')
                         ->with('success', 'Produit publié avec succès !');
    }

    // ── Formulaire modification
    public function edit(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $categories = Category::orderBy('name')->get();
        return view('boutique.edit', compact('product', 'categories'));
    }

    // ── Mettre à jour
    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('boutique.index')
                         ->with('success', 'Produit mis à jour !');
    }

    // ── Supprimer
    public function destroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('boutique.index')
                         ->with('success', 'Produit supprimé.');
    }
}
