<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Vérifier si connecté
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour laisser un avis.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        // Empêcher de noter son propre produit
        $product = \App\Models\Product::findOrFail($request->product_id);
        if ($product->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas évaluer votre propre produit.');
        }

        // Empêcher de noter deux fois
        $alreadyReviewed = Review::where('product_id', $request->product_id)
                                  ->where('user_id', auth()->id())
                                  ->exists();
        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Vous avez déjà laissé un avis pour ce produit.');
        }

        Review::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()->route('products.show', $request->product_id)
                         ->with('success', 'Votre avis a été ajouté avec succès !');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('products.show', $productId)
                         ->with('success', 'Avis supprimé.');
    }
}
