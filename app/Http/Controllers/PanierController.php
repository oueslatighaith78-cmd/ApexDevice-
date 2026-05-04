<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    /**
     * Afficher le panier
     */
  public function index()
{
    $cart = Cart::with('items.product')
                ->firstOrCreate(['user_id' => Auth::id()]);

    $total = $cart->items->sum(fn($item) => $item->quantity * ($item->product->price ?? 0));

    return view('panier.index', compact('cart', 'total'));
}

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->user_id == Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas acheter votre propre produit.');
        }

        $cart     = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $quantity = $request->input('quantity', 1);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }

        return redirect()->route('panier.index')->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité
     */
    public function update(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($request->item_id);

        if ($item->cart->user_id == Auth::id()) {
            $item->update(['quantity' => $request->quantity]);
            return redirect()->back()->with('success', 'Quantité mise à jour.');
        }

        return redirect()->back()->with('error', 'Action non autorisée.');
    }

    /**
     * Supprimer un article
     */
    public function remove(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);

        if ($item->cart->user_id == Auth::id()) {
            $item->delete();
            return redirect()->back()->with('success', 'Article retiré du panier.');
        }

        return redirect()->back()->with('error', 'Action non autorisée.');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
        }
        return redirect()->back()->with('success', 'Panier vidé.');
    }

    /**
     * Page de paiement
     */
    public function paiement()
{
    $cart = Cart::with('items.product')
                ->where('user_id', Auth::id())
                ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
    }

    $total = $cart->items->sum(fn($item) => $item->quantity * $item->product->price);

    return view('panier.paiement', compact('cart', 'total'));
}
    /**
     * Page de confirmation
     */
    public function confirmation($orderId)
    {
        $order = Order::with('items.product')
                      ->where('user_id', Auth::id())
                      ->findOrFail($orderId);

        return view('panier.confirmation', compact('order'));
    }

    /**
     * Valider la commande — redirige vers confirmation avec $order
     */
    public function valider(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        try {
            $order = null;

            DB::transaction(function () use ($cart, &$order) {
                $total = $cart->items->sum(fn($item) => $item->quantity * $item->product->price);

                // 1. Créer la commande
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total'   => $total,
                    'status'  => 'en_attente',
                ]);

                // 2. Créer les lignes de commande
                foreach ($cart->items as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price,
                    ]);
                }

                // 3. Vider le panier
                $cart->items()->delete();
            });

            // Charger les items avec produits pour la page confirmation
            $order->load('items.product');

            return redirect()->route('panier.confirmation', $order->id);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
}