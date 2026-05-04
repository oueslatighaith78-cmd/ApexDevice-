@extends('layouts.app')

@section('title', 'Commande confirmée — ApexDevice')

@section('content')
<style>
    /* Masquer les éléments de recherche du header pour la messagerie */
.search-form, .cat-bar { display: none !important; }
.main-nav { border-bottom: 1px solid #e5e7eb; background: #fff; padding: 6px 0; }
  :root { --bm-green:#1a7a00; }
  .confirm-page { background:#f7f7f5; min-height:100vh; padding:80px 0; }
  .confirm-card { background:#fff; border:1px solid #e8e8e8; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.06); max-width:520px; margin:0 auto; }
  .confirm-card-top { height:5px; background:linear-gradient(90deg,#1a7a00,#5dcaa5); }
  .confirm-card-body { padding:40px; text-align:center; }
  .confirm-icon { width:72px; height:72px; background:#eaf3de; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:32px; }
  .confirm-title { font-size:22px; font-weight:800; color:#1a1a1a; margin-bottom:8px; letter-spacing:-0.5px; }
  .confirm-sub { font-size:14px; color:#888; margin-bottom:28px; }
  .confirm-order-id { display:inline-block; background:#f7f7f5; border:1px solid #e0e0e0; border-radius:8px; padding:8px 16px; font-size:13px; font-weight:700; color:#555; margin-bottom:28px; }
  .confirm-items { background:#f7f7f5; border-radius:12px; padding:16px 20px; margin-bottom:28px; text-align:left; }
  .confirm-item { display:flex; justify-content:space-between; font-size:13px; padding:6px 0; border-bottom:1px solid #e8e8e8; }
  .confirm-item:last-child { border-bottom:none; }
  .confirm-total { display:flex; justify-content:space-between; font-size:16px; font-weight:800; padding-top:12px; }
  .confirm-total-val { color:var(--bm-green); }
  .btn-home { display:inline-flex; align-items:center; gap:8px; background:#1a1a1a; color:#fff !important; border-radius:10px; padding:12px 28px; font-size:14px; font-weight:700; text-decoration:none; transition:background .15s; }
  .btn-home:hover { background:#333; }
</style>

<div class="confirm-page">
  <div class="container">
    <div class="confirm-card">
      <div class="confirm-card-top"></div>
      <div class="confirm-card-body">

        <div class="confirm-icon">✅</div>
        <h2 class="confirm-title">Commande confirmée !</h2>
        <p class="confirm-sub">Merci pour votre achat. Votre commande a été enregistrée avec succès.</p>
        <div class="confirm-order-id">Commande #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>

        <div class="confirm-items">
          @foreach($order->items as $item)
            <div class="confirm-item">
              <span style="color:#555">{{ $item->product->title }} ×{{ $item->quantity }}</span>
              <span style="font-weight:600;color:#1a1a1a">{{ number_format($item->quantity * $item->price, 2, ',', ' ') }} TND</span>
            </div>
          @endforeach
          <div class="confirm-total">
            <span>Total payé</span>
            <span class="confirm-total-val">{{ number_format($order->total, 2, ',', ' ') }} TND</span>
          </div>
        </div>

        <a href="{{ route('home') }}" class="btn-home">
          <i class="bi bi-house"></i> Retour à l'accueil
        </a>

      </div>
    </div>
  </div>
</div>
@endsection