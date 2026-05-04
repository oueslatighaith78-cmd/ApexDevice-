@extends('layouts.app')

@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
@endsection

@section('content')

<style>
  /* ── Auth page variables (cohérentes avec ApexDevice) ── */
  :root {
    --auth-blue-dark: #1a3a6b;
    --auth-blue-mid:  #1e55a0;
    --auth-accent:    #2563eb;
    --auth-accent-dk: #1d4ed8;
    --auth-gray-50:   #f8f8f6;
    --auth-gray-100:  #f0efeb;
    --auth-gray-200:  #e0dfd8;
    --auth-gray-400:  #9b9a93;
    --font-display:   'Syne', sans-serif;
    --font-body:      'DM Sans', sans-serif;
  }

  .auth-wrapper {
    min-height: calc(100vh - 130px);
    background: linear-gradient(145deg, #f0f2f7 0%, #e8ecf4 100%);
    display: flex;
    align-items: center;
    padding: 48px 16px;
  }

  .auth-card {
    background: #ffffff;
    border: 1px solid var(--auth-gray-200);
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(26,58,107,.10), 0 2px 8px rgba(0,0,0,.04);
    overflow: hidden;
  }

  .auth-card-top-bar {
    height: 5px;
    background: linear-gradient(90deg, var(--auth-blue-dark), var(--auth-accent));
  }

  .auth-card-body {
    padding: 40px 40px 36px;
  }

  .auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 28px;
  }
  .auth-logo-name {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
    line-height: 1;
  }
  .auth-logo-name .apex   { color: var(--auth-blue-mid); }
  .auth-logo-name .device { color: #333; }
  .auth-logo-sub {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    color: var(--auth-gray-400);
    text-transform: uppercase;
    margin-top: 4px;
  }

  .auth-card-title {
    font-family: var(--font-display);
    font-size: 19px;
    font-weight: 700;
    color: #111;
    text-align: center;
    margin-bottom: 6px;
  }
  .auth-card-subtitle {
    font-size: 13.5px;
    color: var(--auth-gray-400);
    text-align: center;
    margin-bottom: 28px;
    font-family: var(--font-body);
  }

  .form-label {
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
  }
  .form-control {
    font-family: var(--font-body);
    font-size: 14px;
    border: 1.5px solid var(--auth-gray-200);
    border-radius: 10px;
    padding: 11px 14px;
    background: var(--auth-gray-50);
    color: #111;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus {
    border-color: var(--auth-accent);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    outline: none;
  }
  .form-control.is-invalid {
    border-color: #dc2626;
    background: #fff5f5;
  }
  .invalid-feedback {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
  }

  .input-icon-wrap {
    position: relative;
  }
  .input-icon-wrap .form-control {
    padding-left: 42px;
  }
  .input-icon-wrap .field-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--auth-gray-400);
    font-size: 15px;
    pointer-events: none;
  }

  /* Indicateur de force du mot de passe */
  .pwd-strength {
    height: 4px;
    border-radius: 4px;
    background: var(--auth-gray-200);
    margin-top: 8px;
    overflow: hidden;
  }
  .pwd-strength-bar {
    height: 100%;
    width: 0%;
    border-radius: 4px;
    transition: width .3s, background .3s;
  }
  .pwd-hint {
    font-size: 11.5px;
    color: var(--auth-gray-400);
    margin-top: 4px;
    font-family: var(--font-body);
  }

  .btn-auth {
    width: 100%;
    background: var(--auth-accent);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -0.2px;
    cursor: pointer;
    transition: background .15s, transform .1s;
  }
  .btn-auth:hover   { background: var(--auth-accent-dk); }
  .btn-auth:active  { transform: scale(.98); }

  /* Mention légale */
  .auth-terms {
    font-size: 11.5px;
    color: var(--auth-gray-400);
    text-align: center;
    margin-top: 12px;
    font-family: var(--font-body);
    line-height: 1.5;
  }
  .auth-terms a {
    color: var(--auth-accent);
    text-decoration: underline;
  }

  .auth-footer-text {
    text-align: center;
    font-size: 13.5px;
    color: #666;
    font-family: var(--font-body);
    margin-top: 20px;
  }
  .auth-footer-text a {
    color: var(--auth-accent);
    font-weight: 600;
    text-decoration: none;
  }
  .auth-footer-text a:hover { text-decoration: underline; }

  .auth-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
    color: #dc2626;
    margin-bottom: 20px;
    font-family: var(--font-body);
  }

  /* Avantages rapides au-dessus du form */
  .auth-perks {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 28px;
  }
  .auth-perk {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #555;
    font-family: var(--font-body);
  }
  .auth-perk i {
    color: var(--auth-accent);
    font-size: 13px;
  }
</style>

<div class="auth-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-sm-8 col-12">

        <div class="auth-card">
          <div class="auth-card-top-bar"></div>
          <div class="auth-card-body">

            {{-- Logo --}}
            <div class="auth-logo">
              <div class="auth-logo-name">
                <span class="apex">Apex</span><span class="device">Device</span>
              </div>
              <span class="auth-logo-sub">Electronics E-Commerce</span>
            </div>

            <h2 class="auth-card-title">Créer un compte</h2>
            <p class="auth-card-subtitle">Rejoignez des milliers d'acheteurs en Tunisie</p>

            {{-- Avantages --}}
            <div class="auth-perks">
              <div class="auth-perk">
                <i class="bi bi-shield-check"></i> Achat sécurisé
              </div>
              <div class="auth-perk">
                <i class="bi bi-truck"></i> Livraison rapide
              </div>
              <div class="auth-perk">
                <i class="bi bi-arrow-return-left"></i> Retour 30j
              </div>
            </div>

            {{-- Erreurs globales --}}
            @if ($errors->any())
              <div class="auth-alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                Veuillez corriger les erreurs ci-dessous.
              </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="/register">
              @csrf

              {{-- Nom --}}
              <div class="mb-3">
                <label for="name" class="form-label">Nom complet</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-person field-icon"></i>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Prénom Nom"
                    required
                    autofocus
                  >
                </div>
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Email --}}
              <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-envelope field-icon"></i>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="votre@email.com"
                    required
                  >
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Mot de passe --}}
              <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-lock field-icon"></i>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimum 8 caractères"
                    required
                    oninput="checkStrength(this.value)"
                  >
                </div>
                {{-- Indicateur force --}}
                <div class="pwd-strength mt-2">
                  <div class="pwd-strength-bar" id="pwd-bar"></div>
                </div>
                <p class="pwd-hint" id="pwd-hint">Entrez un mot de passe</p>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Confirmation --}}
              <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-lock-fill field-icon"></i>
                  <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Répétez votre mot de passe"
                    required
                  >
                </div>
              </div>

              {{-- Bouton --}}
              <button type="submit" class="btn-auth">
                Créer mon compte
              </button>

              {{-- Mention --}}
              <p class="auth-terms mt-3">
                En créant un compte, vous acceptez nos
                <a href="#">Conditions d'utilisation</a> et notre
                <a href="#">Politique de confidentialité</a>.
              </p>

            </form>

            {{-- Lien connexion --}}
            <p class="auth-footer-text">
              Déjà un compte ?
              <a href="/login">Se connecter</a>
            </p>

          </div>{{-- /card-body --}}
        </div>{{-- /auth-card --}}

      </div>
    </div>
  </div>
</div>

<script>
function checkStrength(val) {
  const bar  = document.getElementById('pwd-bar');
  const hint = document.getElementById('pwd-hint');
  let score  = 0;
  if (val.length >= 8)                  score++;
  if (/[A-Z]/.test(val))               score++;
  if (/[0-9]/.test(val))               score++;
  if (/[^A-Za-z0-9]/.test(val))        score++;

  const levels = [
    { pct: '0%',   color: '#e0dfd8', label: 'Entrez un mot de passe' },
    { pct: '25%',  color: '#dc2626', label: 'Très faible' },
    { pct: '50%',  color: '#d97706', label: 'Faible' },
    { pct: '75%',  color: '#2563eb', label: 'Bien' },
    { pct: '100%', color: '#16a34a', label: 'Fort 💪' },
  ];

  const lvl = val.length === 0 ? levels[0] : levels[score];
  bar.style.width      = lvl.pct;
  bar.style.background = lvl.color;
  hint.textContent     = lvl.label;
  hint.style.color     = lvl.color;
}
</script>

@endsection