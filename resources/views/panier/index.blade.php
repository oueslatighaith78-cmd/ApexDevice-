@extends('layouts.app')

@section('title', 'Mon Panier — ApexDevice')

@section('styles')
<style>
 .search-form, .cat-bar { display: none !important; } /* On a enlevé .topbar d'ici */
  
  .main-nav { border-bottom: 1px solid #e0dfd8; background: #fff; padding: 8px 0; }

  /* --- STYLE DU PANIER HARMONISÉ --- */
  :root { 
      --bm-green: #1a3a6b; /* Bleu Apex pour plus de logique avec l'accueil */
      --bm-green-light: #f0f4ff; 
  }
  
  .panier-page { background:#f9fafb; min-height:100vh; padding-bottom:80px; font-family: 'DM Sans', sans-serif; }

  /* Hero Section */
  .panier-hero { background:#fff; border-bottom:1px solid #e5e7eb; padding:25px 0; }
  .panier-hero h1 { font-size:24px; font-weight:700; color:#1a1a1a; letter-spacing:-0.5px; margin:0; }
  .panier-hero p { font-size:13px; color:#6b7280; margin-top:4px; }

  /* Tableau design */
  .panier-card-wrap { background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
  .panier-table { width:100%; border-collapse:collapse; }
  .panier-table th {
    font-size:11px; font-weight:700; color:#9ca3af;
    text-transform:uppercase; letter-spacing:0.05em;
    padding:12px 15px; border-bottom:1px solid #f3f4f6;
    background:#fafafa;
  }
  .panier-table td { padding:16px 15px; border-bottom:1px solid #f3f4f6; vertical-align:middle; }

  /* Produit */
  .product-row { display:flex; align-items:center; gap:15px; }
  .product-thumb {
    width:56px; height:56px; border-radius:10px;
    background:#f9fafb; border:1px solid #e5e7eb;
    display:flex; align-items:center; justify-content:center; overflow:hidden;
  }
  .product-thumb img { width:100%; height:100%; object-fit:contain; padding:5px; }
  .product-name { font-size:14px; font-weight:600; color:#111827; }

  /* Contrôles Quantité */
  .qty-wrap { display:flex; align-items:center; gap:5px; }
  .qty-btn {
    width:28px; height:28px; border:1px solid #d1d5db;
    border-radius:6px; background:#fff; cursor:pointer;
    display:flex; align-items:center; justify-content:center; font-size:14px;
  }
  .qty-input {
    width:40px; height:28px; border:1px solid #d1d5db;
    border-radius:6px; text-align:center; font-size:13px; font-weight:700;
  }

  /* Récapitulatif */
  .panier-summary { background:#fff; border:1px solid #e5e7eb; border-radius:20px; padding:24px; position: sticky; top: 100px; }
  .summary-total-value { font-size:24px; font-weight:800; color:#1a3a6b; }
  
  .btn-acheter {
    width:100%; background:#1a3a6b; color:#fff;
    border:none; border-radius:12px; padding:14px;
    font-size:15px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:8px;
    text-decoration:none; transition: 0.2s;
  }
  .btn-acheter:hover { background:#1e55a0; color:#fff; transform: translateY(-1px); }

  .btn-continue { font-size:13px; color:#6b7280; text-decoration:none; font-weight:500; }
  .btn-continue:hover { color:#1a3a6b; }
</style>
@endsection

@section('content')
<div class="panier-page">

  <div class="panier-hero">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h1>Mon Panier</h1>
          <p>{{ $cart->items->count() }} produit(s) sélectionné(s)</p>
        </div>
        <a href="{{ route('home') }}" class="btn-continue">
          <i class="bi bi-arrow-left"></i> Continuer mes achats
        </a>
      </div>
    </div>
  </div>

  <div class="container mt-4">

    @if(session('success'))
      <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:12px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
      </div>
    @endif

    @if($cart->items->isEmpty())
      <div class="text-center py-5">
        <div style="font-size:60px; margin-bottom:20px;">🛒</div>
        <h3 class="fw-bold">Votre panier est vide</h3>
        <p class="text-muted">Il semble que vous n'ayez pas encore fait votre choix.</p>
        <a href="{{ route('home') }}" class="btn btn-dark px-4 py-2 mt-3" style="border-radius:10px;">Explorer la boutique</a>
      </div>
    @else

      <div class="row g-4">
        {{-- Liste des articles --}}
        <div class="col-lg-8">
          <div class="panier-card-wrap">
            <table class="panier-table">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Prix</th>
                  <th>Quantité</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($cart->items as $item)
                <tr>
                  <td>
                    <div class="product-row">
                      <div class="product-thumb">
                        @if($item->product->image)
                          <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                        @else
                          <span style="font-size:20px;">📦</span>
                        @endif
                      </div>
                      <div class="product-name">{{ Str::limit($item->product->title, 40) }}</div>
                    </div>
                  </td>
                  <td class="fw-bold" style="font-size:14px;">{{ number_format($item->product->price, 0, ',', ' ') }} DT</td>
                  <td>
                    <form method="POST" action="{{ route('panier.update') }}" id="form-qty-{{ $item->id }}">
                      @csrf
                      <input type="hidden" name="item_id" value="{{ $item->id }}">
                      <div class="qty-wrap">
                        <button type="button" class="qty-btn" onclick="changeQty({{ $item->id }}, -1)">-</button>
                        <input type="number" name="quantity" id="qty-{{ $item->id }}" class="qty-input" value="{{ $item->quantity }}" readonly>
                        <button type="button" class="qty-btn" onclick="changeQty({{ $item->id }}, 1)">+</button>
                      </div>
                    </form>
                  </td>
                  <td class="fw-bold" style="color:#1a3a6b;">{{ number_format($item->quantity * $item->product->price, 0, ',', ' ') }} DT</td>
                  <td>
                    <form method="POST" action="{{ route('panier.remove') }}">
                      @csrf
                      <input type="hidden" name="item_id" value="{{ $item->id }}">
                      <button type="submit" class="border-0 bg-transparent text-danger px-2" onclick="return confirm('Supprimer cet article ?')">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        {{-- Résumé --}}
        <div class="col-lg-4">
          <div class="panier-summary shadow-sm">
            <h5 class="fw-bold mb-4" style="font-size:16px;">Résumé de la commande</h5>
            
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Sous-total</span>
              <span class="fw-bold small">{{ number_format($total, 0, ',', ' ') }} DT</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted small">Livraison</span>
              <span class="text-success fw-bold small">Gratuite</span>
            </div>

            <hr style="border-top: 1px dashed #ddd;">

            <div class="d-flex justify-content-between align-items-center mb-4">
              <span class="fw-bold">Total TTC</span>
              <span class="summary-total-value">{{ number_format($total, 0, ',', ' ') }} DT</span>
            </div>

            <a href="{{ route('panier.paiement') }}" class="btn-acheter">
              Commander maintenant
            </a>
            
            <div class="text-center mt-3">
              <span style="font-size:11px; color:#9ca3af;"><i class="bi bi-shield-lock-fill"></i> Paiement sécurisé SSL</span>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

<script>
  function changeQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    document.getElementById('form-qty-' + id).submit();
  }
</script>
@endsection