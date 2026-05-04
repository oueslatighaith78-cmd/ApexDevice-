@extends('layouts.app')

@section('title', 'Paiement — ApexDevice')

@section('content')
<style>
 /* Masquer les éléments de recherche du header pour la messagerie */
.search-form, .cat-bar { display: none !important; }
.main-nav { border-bottom: 1px solid #e5e7eb; background: #fff; padding: 6px 0; }
 :root { --bm-green:#1a7a00; --bm-green-light:#eaf3de; }
  .paiement-page { background:#f7f7f5; min-height:100vh; padding:48px 0 80px; }

  /* Card formulaire */
  .paiement-card {
    background:#fff; border:1px solid #e8e8e8;
    border-radius:20px; overflow:hidden;
    box-shadow:0 4px 24px rgba(0,0,0,.06);
  }
  .paiement-card-top { height:5px; background:linear-gradient(90deg,#1a1a1a,#1a7a00); }
  .paiement-card-body { padding:36px 40px 32px; }

  /* En-tête */
  .paiement-logo {
    display:flex; flex-direction:column;
    align-items:center; margin-bottom:28px;
  }
  .paiement-logo-name { font-size:24px; font-weight:800; letter-spacing:-0.5px; }
  .paiement-logo-name .apex   { color:#1e55a0; }
  .paiement-logo-name .device { color:#1a1a1a; }
  .paiement-logo-sub { font-size:10px; font-weight:600; letter-spacing:0.14em; color:#aaa; text-transform:uppercase; margin-top:4px; }

  .paiement-title { font-size:20px; font-weight:800; color:#1a1a1a; text-align:center; margin-bottom:6px; }
  .paiement-subtitle { font-size:13px; color:#888; text-align:center; margin-bottom:28px; }

  /* Champs */
  .field-label { font-size:11px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:5px; display:block; }
  .field-input {
    width:100%; border:1.5px solid #e0e0e0; border-radius:10px;
    padding:11px 14px; font-size:14px; color:#1a1a1a;
    background:#fff; font-family:inherit; outline:none;
    transition:border-color .2s, box-shadow .2s;
  }
  .field-input:focus { border-color:#1a1a1a; box-shadow:0 0 0 3px rgba(26,26,26,.08); }
  .field-input.is-invalid { border-color:#dc2626; background:#fff5f5; }
  .invalid-msg { font-size:12px; color:#dc2626; margin-top:4px; }

  /* Mode de paiement */
  .payment-methods { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
  .payment-option { position:relative; }
  .payment-option input[type=radio] { position:absolute; opacity:0; width:0; height:0; }
  .payment-label {
    display:flex; align-items:center; gap:10px;
    border:1.5px solid #e0e0e0; border-radius:12px;
    padding:14px 16px; cursor:pointer;
    transition:border-color .2s, background .2s;
    font-size:14px; font-weight:600; color:#1a1a1a;
  }
  .payment-option input:checked + .payment-label {
    border-color:#1a1a1a; background:#f7f7f5;
  }
  .payment-label:hover { border-color:#bbb; }
  .payment-icon { font-size:24px; }
  .payment-badge {
    margin-left:auto; font-size:10px; font-weight:700;
    background:#eaf3de; color:#1a5c00;
    padding:2px 8px; border-radius:100px;
  }

  /* Bouton valider */
  .btn-valider {
    width:100%; background:#1a1a1a; color:#fff;
    border:none; border-radius:12px; padding:15px;
    font-size:16px; font-weight:800; cursor:pointer;
    transition:background .15s, transform .1s;
    display:flex; align-items:center; justify-content:center; gap:8px;
    letter-spacing:-0.3px; margin-top:8px;
  }
  .btn-valider:hover { background:#333; transform:translateY(-1px); }
  .btn-valider:active { transform:scale(.98); }

  /* Récap commande */
  .order-recap {
    background:#f7f7f5; border-radius:14px;
    padding:20px 22px; margin-bottom:24px;
  }
  .order-recap-title { font-size:13px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px; }
  .order-line { display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px; }
  .order-line:last-child { margin-bottom:0; }
  .order-line-name { color:#555; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .order-line-price { font-weight:600; color:#1a1a1a; white-space:nowrap; }
  .order-total-line { display:flex; justify-content:space-between; align-items:center; padding-top:12px; border-top:1px solid #e0e0e0; margin-top:8px; }
  .order-total-label { font-size:15px; font-weight:800; color:#1a1a1a; }
  .order-total-value { font-size:20px; font-weight:800; color:var(--bm-green); letter-spacing:-0.3px; }

  /* Sécurité */
  .secure-badges { display:flex; justify-content:center; gap:20px; margin-top:16px; flex-wrap:wrap; }
  .secure-badge { display:flex; align-items:center; gap:5px; font-size:11px; color:#aaa; }

  @media(max-width:576px) {
    .paiement-card-body { padding:24px 20px; }
    .payment-methods { grid-template-columns:1fr; }
  }
</style>

<div class="paiement-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-10 col-12">

        <a href="{{ route('panier.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#666;text-decoration:none;margin-bottom:24px;">
          <i class="bi bi-arrow-left"></i> Retour au panier
        </a>

        <div class="paiement-card">
          <div class="paiement-card-top"></div>
          <div class="paiement-card-body">

            {{-- Logo --}}
            <div class="paiement-logo">
              <div class="paiement-logo-name">
                <span class="apex">Apex</span><span class="device">Device</span>
              </div>
              <span class="paiement-logo-sub">Paiement sécurisé</span>
            </div>

            <h2 class="paiement-title">Finaliser la commande</h2>
            <p class="paiement-subtitle">Total à payer : <strong style="color:var(--bm-green)">{{ number_format($total, 2, ',', ' ') }} TND</strong></p>

            {{-- Récap commande --}}
            <div class="order-recap">
              <div class="order-recap-title">Votre commande</div>
              @foreach($cart->items as $item)
                <div class="order-line">
                  <span class="order-line-name">{{ $item->product->title }} ×{{ $item->quantity }}</span>
                  <span class="order-line-price">{{ number_format($item->quantity * $item->product->price, 2, ',', ' ') }} TND</span>
                </div>
              @endforeach
              <div class="order-total-line">
                <span class="order-total-label">Total</span>
                <span class="order-total-value">{{ number_format($total, 2, ',', ' ') }} TND</span>
              </div>
            </div>

            {{-- Erreurs --}}
            @if($errors->any())
              <div class="alert alert-danger py-2 px-3 mb-4" style="font-size:13px;border-radius:10px">
                <i class="bi bi-exclamation-circle me-1"></i> Veuillez corriger les erreurs ci-dessous.
              </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('panier.valider') }}">
              @csrf

              {{-- Nom + Prénom --}}
              <div class="row g-3 mb-3">
                <div class="col-6">
                  <label class="field-label">Nom *</label>
                  <input type="text" name="nom" class="field-input @error('nom') is-invalid @enderror"
                         placeholder="Dupont" value="{{ old('nom') }}" required>
                  @error('nom')<div class="invalid-msg">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                  <label class="field-label">Prénom *</label>
                  <input type="text" name="prenom" class="field-input @error('prenom') is-invalid @enderror"
                         placeholder="Jean" value="{{ old('prenom') }}" required>
                  @error('prenom')<div class="invalid-msg">{{ $message }}</div>@enderror
                </div>
              </div>

              {{-- Mode de paiement --}}
              <div class="mb-3">
                <label class="field-label">Mode de paiement *</label>
                <div class="payment-methods">
                  <div class="payment-option">
                    <input type="radio" name="mode_paiement" id="carte" value="carte"
                           {{ old('mode_paiement', 'carte') === 'carte' ? 'checked' : '' }}>
                    <label class="payment-label" for="carte">
                      <span class="payment-icon">💳</span>
                      <span>Carte bancaire</span>
                      <span class="payment-badge">Visa / MC</span>
                    </label>
                  </div>
                  <div class="payment-option">
                    <input type="radio" name="mode_paiement" id="paypal" value="paypal"
                           {{ old('mode_paiement') === 'paypal' ? 'checked' : '' }}>
                    <label class="payment-label" for="paypal">
                      <span class="payment-icon">🅿️</span>
                      <span>PayPal</span>
                    </label>
                  </div>
                </div>
                @error('mode_paiement')<div class="invalid-msg mt-1">{{ $message }}</div>@enderror
              </div>

              {{-- Code de sécurité --}}
              <div class="mb-4">
                <label class="field-label">
                  Code de sécurité *
                  <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#bbb;font-size:11px;margin-left:4px">(CVV / 3-4 chiffres)</span>
                </label>
                <div style="position:relative;max-width:160px">
                  <input type="password" name="code_securite"
                         class="field-input @error('code_securite') is-invalid @enderror"
                         placeholder="•••" maxlength="4" required
                         value="{{ old('code_securite') }}"
                         style="padding-right:42px;letter-spacing:4px;font-size:18px">
                  <i class="bi bi-eye-slash" id="toggle-code"
                     style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#aaa;cursor:pointer;font-size:16px"
                     onclick="toggleCode()"></i>
                </div>
                @error('code_securite')<div class="invalid-msg">{{ $message }}</div>@enderror
              </div>

              {{-- Bouton valider --}}
              <button type="submit" class="btn-valider">
                <i class="bi bi-lock-fill"></i>
                Valider l'achat — {{ number_format($total, 2, ',', ' ') }} TND
              </button>

            </form>

            {{-- Badges sécurité --}}
            <div class="secure-badges">
              <span class="secure-badge"><i class="bi bi-shield-check"></i> SSL sécurisé</span>
              <span class="secure-badge"><i class="bi bi-lock"></i> Données chiffrées</span>
              <span class="secure-badge"><i class="bi bi-arrow-return-left"></i> Retour 30j</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleCode() {
  const input  = document.querySelector('input[name=code_securite]');
  const icon   = document.getElementById('toggle-code');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye';
  } else {
    input.type = 'password';
    icon.className = 'bi bi-eye-slash';
  }
}
</script>

@endsection