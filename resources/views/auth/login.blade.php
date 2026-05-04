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

  /* ── Card ── */
  .auth-card {
    background: #ffffff;
    border: 1px solid var(--auth-gray-200);
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(26,58,107,.10), 0 2px 8px rgba(0,0,0,.04);
    overflow: hidden;
  }

  /* Bande décorative bleue en haut */
  .auth-card-top-bar {
    height: 5px;
    background: linear-gradient(90deg, var(--auth-blue-dark), var(--auth-accent));
  }

  .auth-card-body {
    padding: 40px 40px 36px;
  }

  /* ── Logo / titre ── */
  .auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 32px;
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

  /* ── Inputs ── */
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

  /* ── Input icon wrapper ── */
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

  /* ── Remember me ── */
  .form-check-label {
    font-family: var(--font-body);
    font-size: 13px;
    color: #555;
  }
  .form-check-input:checked {
    background-color: var(--auth-accent);
    border-color: var(--auth-accent);
  }

  /* ── Forgot password ── */
  .forgot-link {
    font-size: 13px;
    color: var(--auth-accent);
    text-decoration: none;
    font-family: var(--font-body);
    font-weight: 500;
  }
  .forgot-link:hover { text-decoration: underline; color: var(--auth-accent-dk); }

  /* ── Submit button ── */
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

  /* ── Séparateur ── */
  .auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
    color: var(--auth-gray-400);
    font-size: 12px;
    font-family: var(--font-body);
  }
  .auth-divider::before,
  .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--auth-gray-200);
  }

  /* ── Footer link ── */
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

  /* ── Alert erreurs globales ── */
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

            <h2 class="auth-card-title">Bon retour 👋</h2>
            <p class="auth-card-subtitle">Connectez-vous à votre compte</p>

            {{-- Erreurs globales --}}
            @if ($errors->any())
              <div class="auth-alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ $errors->first() }}
              </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="/login">
              @csrf

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
                    autofocus
                  >
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Mot de passe --}}
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label for="password" class="form-label mb-0">Mot de passe</label>
                  <a href="/forgot-password" class="forgot-link">Mot de passe oublié ?</a>
                </div>
                <div class="input-icon-wrap">
                  <i class="bi bi-lock field-icon"></i>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                  >
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Se souvenir de moi --}}
              <div class="mb-4 d-flex align-items-center">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="remember"
                    {{ old('remember') ? 'checked' : '' }}
                  >
                  <label class="form-check-label" for="remember">
                    Se souvenir de moi
                  </label>
                </div>
              </div>

              {{-- Bouton --}}
              <button type="submit" class="btn-auth">
                Se connecter
              </button>

            </form>

            {{-- Lien inscription --}}
            <p class="auth-footer-text">
              Pas encore de compte ?
              <a href="/register">Créer un compte</a>
            </p>

          </div>{{-- /card-body --}}
        </div>{{-- /auth-card --}}

      </div>
    </div>
  </div>
</div>

@endsection