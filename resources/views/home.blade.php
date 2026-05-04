<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ApexDevice — Electronics E-Commerce</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
:root {
  --black: #0a0a0a;
  --white: #ffffff;
  --gray-50: #f8f8f6;
  --gray-100: #f0efeb;
  --gray-200: #e0dfd8;
  --gray-400: #9b9a93;
  --gray-600: #5c5b56;
  --blue-dark: #1a3a6b;
  --blue-mid: #1e55a0;
  --accent: #2563eb;
  --accent-light: #dbeafe;
  --accent-dark: #1d4ed8;
  --green: #16a34a;
  --amber: #d97706;
  --red: #dc2626;
  --font-display: 'Syne', sans-serif;
  --font-body: 'DM Sans', sans-serif;
}

*, body { font-family: var(--font-body); }

/* ─── TOPBAR ─── */
.topbar {
  background: var(--blue-dark);
  color: rgba(255,255,255,0.75);
  font-size: 12.5px;
  letter-spacing: 0.03em;
  padding: 7px 0;
}
.topbar span { color: #93c5fd; font-weight: 600; }

/* ─── NAVBAR ─── */
.main-nav {
  background: var(--white);
  border-bottom: 1px solid var(--gray-200);
  box-shadow: 0 1px 12px rgba(0,0,0,0.07);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.logo-wrap { text-decoration: none; display: flex; align-items: center; gap: 10px; }
.logo-img  { height: 44px; width: auto; object-fit: contain; }
.logo-fallback { display: none; }
.logo-name { font-family: var(--font-display); font-size: 20px; font-weight: 800; letter-spacing: -0.5px; line-height: 1.1; }
.logo-name .apex   { color: var(--blue-mid); }
.logo-name .device { color: #4a4a4a; }
.logo-sub  { font-size: 9px; font-weight: 600; letter-spacing: 0.12em; color: var(--gray-400); text-transform: uppercase; }

/* Search */
.search-form .form-control {
  border: 1.5px solid var(--gray-200);
  border-right: none;
  border-radius: 10px 0 0 10px;
  font-size: 14px;
  background: var(--gray-50);
  color: var(--black);
  padding: 10px 16px;
  box-shadow: none;
}
.search-form .form-control:focus {
  border-color: var(--accent);
  background: var(--white);
  box-shadow: none;
}
.search-form .form-control::placeholder { color: var(--gray-400); }
.search-form .btn-search {
  background: var(--accent);
  border: none;
  border-radius: 0 10px 10px 0;
  width: 46px;
  padding: 0;
  display: flex; align-items: center; justify-content: center;
  transition: background .15s;
}
.search-form .btn-search:hover  { background: var(--accent-dark); }
.search-form .btn-search i      { color: #fff; font-size: 15px; }

/* Sell button */
.btn-sell {
  background: var(--blue-mid);
  color: var(--white) !important;
  font-size: 13px;
  font-weight: 600;
  border-radius: 9px;
  padding: 9px 16px;
  border: none;
  text-decoration: none;
  display: inline-flex; align-items: center; gap: 7px;
  white-space: nowrap;
  transition: background .15s;
}
.btn-sell:hover { background: var(--blue-dark); }

/* Icon action buttons */
.nav-icon-btn {
  display: flex; flex-direction: column; align-items: center; gap: 2px;
  padding: 7px 10px;
  border-radius: 9px;
  color: var(--gray-600);
  text-decoration: none;
  background: transparent;
  border: none;
  cursor: pointer;
  transition: all .15s;
  position: relative;
  font-family: var(--font-body);
}
.nav-icon-btn:hover { background: var(--gray-100); color: var(--black); }
.nav-icon-btn i       { font-size: 20px; }
.nav-icon-label       { font-size: 10px; font-weight: 500; color: inherit; }
.nav-badge {
  position: absolute; top: 4px; right: 5px;
  width: 8px; height: 8px;
  background: var(--red);
  border-radius: 50%;
  border: 2px solid var(--white);
}

/* Auth buttons */
.btn-login {
  color: var(--accent);
  border: 1.5px solid var(--accent);
  background: transparent;
  padding: 8px 16px;
  border-radius: 9px;
  font-size: 13px; font-weight: 600;
  text-decoration: none;
  transition: all .15s;
}
.btn-login:hover { background: var(--accent-light); color: var(--accent); }

.btn-register {
  background: var(--accent);
  color: var(--white);
  border: none;
  padding: 8px 16px;
  border-radius: 9px;
  font-size: 13px; font-weight: 600;
  text-decoration: none;
  transition: background .15s;
}
.btn-register:hover { background: var(--accent-dark); color: var(--white); }

/* Category bar */
.cat-bar {
  border-top: 1px solid var(--gray-100);
  display: flex;
  overflow-x: auto;
  scrollbar-width: none;
}
.cat-bar::-webkit-scrollbar { display: none; }
.cat-link {
  display: inline-flex; align-items: center;
  padding: 13px 18px;
  font-family: var(--font-display);
  font-size: 13.5px; font-weight: 500;
  letter-spacing: -0.01em;
  color: #1a1a1a;
  text-decoration: none;
  white-space: nowrap;
  border-bottom: 2px solid transparent;
  transition: color .15s, border-color .15s;
}
.cat-link:hover  { color: #000; border-bottom-color: #000; }
.cat-link.active { color: #000; border-bottom-color: #000; font-weight: 700; }
/* "Bons plans" — rose + gras + étoile SVG comme Back Market */
.cat-link-bonplan {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 13px 18px;
  font-family: var(--font-display);
  font-size: 13.5px; font-weight: 700;
  letter-spacing: -0.01em;
  color: #db3060;
  text-decoration: none;
  white-space: nowrap;
  border-bottom: 2px solid transparent;
  transition: color .15s, border-color .15s;
}
.cat-link-bonplan:hover  { color: #b02050; border-bottom-color: #db3060; }
.cat-link-bonplan.active { border-bottom-color: #db3060; }
.bonplan-star { width: 15px; height: 15px; flex-shrink: 0; }

/* ─── HERO ─── */
.hero-section {
  background: linear-gradient(135deg, #0f1f3d 0%, #1a3a6b 55%, #1e55a0 100%);
  overflow: hidden;
  position: relative;
  min-height: 360px;
}
.hero-section::after {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse at 75% 50%, rgba(37,99,235,.2) 0%, transparent 60%);
  pointer-events: none;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.2);
  color: #93c5fd;
  font-size: 11px; font-weight: 600;
  padding: 5px 14px;
  border-radius: 20px;
  letter-spacing: .06em;
  text-transform: uppercase;
}
.hero-title {
  font-family: var(--font-display);
  font-size: 44px; font-weight: 800;
  color: var(--white);
  line-height: 1.1; letter-spacing: -1px;
}
.hero-title span { color: #60a5fa; }
.hero-desc  { font-size: 15px; color: rgba(255,255,255,.65); line-height: 1.7; max-width: 420px; }
.btn-hero-white {
  background: var(--white);
  color: var(--blue-dark);
  padding: 12px 24px;
  border-radius: 10px;
  font-weight: 700; font-size: 14px;
  border: none; text-decoration: none;
  transition: opacity .15s;
}
.btn-hero-white:hover { opacity: .9; color: var(--blue-dark); }
.btn-hero-outline {
  background: transparent;
  color: var(--white);
  padding: 11px 24px;
  border-radius: 10px;
  font-weight: 500; font-size: 14px;
  border: 1.5px solid rgba(255,255,255,.35);
  text-decoration: none;
  transition: all .15s;
}
.btn-hero-outline:hover { border-color: var(--white); background: rgba(255,255,255,.08); color: var(--white); }

/* ─── HERO IMAGE STACK ─── */
.hero-img-stack {
  position: relative;
  width: 320px;
  height: 300px;
}
.hero-img-stack .himg {
  position: absolute;
  width: 200px;
  height: 240px;
  border-radius: 18px;
  object-fit: cover;
  border: 3px solid rgba(255,255,255,0.18);
  box-shadow: 0 20px 60px rgba(0,0,0,0.45), 0 4px 16px rgba(0,0,0,0.3);
  transition: transform .3s ease;
}
/* Image de derrière — légèrement à gauche, inclinée */
.hero-img-stack .himg:nth-child(1) {
  top: 20px;
  left: 0;
  transform: rotate(-6deg);
  z-index: 1;
  opacity: .85;
  width: 185px;
  height: 220px;
}
/* Image du milieu — légèrement à droite, rotation opposée */
.hero-img-stack .himg:nth-child(2) {
  top: 35px;
  left: 55px;
  transform: rotate(3deg);
  z-index: 2;
  width: 190px;
  height: 228px;
}
/* Image de devant — centrée, droite, au premier plan */
.hero-img-stack .himg:nth-child(3) {
  top: 0;
  left: 108px;
  transform: rotate(-2deg);
  z-index: 3;
  width: 195px;
  height: 235px;
  box-shadow: 0 24px 70px rgba(0,0,0,0.55), 0 6px 20px rgba(0,0,0,0.35);
}
.hero-img-stack:hover .himg:nth-child(1) { transform: rotate(-8deg) translateX(-6px); }
.hero-img-stack:hover .himg:nth-child(2) { transform: rotate(4deg) translateY(-4px); }
.hero-img-stack:hover .himg:nth-child(3) { transform: rotate(-1deg) translateY(-6px); }

/* ─── TRUST STRIP ─── */
.trust-strip {
  background: #eef0f4;
  padding: 72px 0 68px;
  border-bottom: 1px solid var(--gray-200);
}
.trust-strip-headline {
  font-family: var(--font-display);
  font-size: 32px; font-weight: 800;
  color: var(--black);
  letter-spacing: -0.8px; line-height: 1.2;
  text-align: center;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 16px;
}
.trust-strip-sub {
  font-size: 15px; color: #555;
  text-align: center; margin-bottom: 48px;
  font-weight: 400;
  line-height: 1.7;
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
}
.trust-strip-sub a {
  color: var(--black); font-weight: 500;
  text-decoration: underline; text-underline-offset: 3px;
}
.trust-items-row {
  display: flex;
  justify-content: center;
  align-items: stretch;
  flex-wrap: nowrap;
  background: var(--white);
  border-radius: 16px;
  border: 1px solid #dddde0;
  overflow: hidden;
  max-width: 980px;
  margin: 0 auto;
  box-shadow: 0 2px 16px rgba(0,0,0,0.05);
}
.trust-item {
  display: flex;
  align-items: center;
  gap: 13px;
  padding: 26px 36px;
  flex: 1;
  border-right: 1px solid #dddde0;
  font-size: 14px;
  color: #1a1a1a;
  font-weight: 500;
  font-family: var(--font-body);
  white-space: nowrap;
  line-height: 1;
}
.trust-item:last-child { border-right: none; }
.trust-item svg { flex-shrink: 0; opacity: .85; }

/* ─── SECTIONS ─── */
.section-title {
  font-family: var(--font-display);
  font-size: 21px; font-weight: 700;
  color: var(--black); letter-spacing: -.5px;
}
.section-link { font-size: 13px; color: var(--accent); text-decoration: none; font-weight: 500; }
.section-link:hover { text-decoration: underline; color: var(--accent-dark); }

/* ─── CATEGORY CARDS ─── */
.cat-card {
  background: var(--white);
  border: 1px solid var(--gray-200);
  border-radius: 16px;
  padding: 26px 16px;
  display: flex; flex-direction: column; align-items: center; gap: 10px;
  cursor: pointer; text-decoration: none;
  transition: all .2s;
}
.cat-card:hover {
  border-color: var(--accent);
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(37,99,235,.12);
  text-decoration: none;
}
.cat-card-icon {
  width: 64px; height: 64px;
  background: var(--gray-50);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 30px;
  transition: background .2s;
}
.cat-card:hover .cat-card-icon { background: var(--accent-light); }
.cat-card-name  { font-family: var(--font-display); font-size: 13px; font-weight: 600; color: var(--black); text-align: center; }
.cat-card-count { font-size: 11px; color: var(--gray-400); }

/* ─── FILTERS ─── */
.filter-chip {
  padding: 7px 16px;
  border-radius: 20px;
  font-size: 13px; font-weight: 500;
  border: 1.5px solid var(--gray-200);
  background: var(--white);
  color: var(--gray-600);
  cursor: pointer;
  font-family: var(--font-body);
  transition: all .15s;
}
.filter-chip:hover          { border-color: var(--accent); color: var(--accent); }
.filter-chip.active         { background: var(--accent); border-color: var(--accent); color: var(--white); }
.filter-label               { font-size: 13px; color: var(--gray-600); font-weight: 500; }

/* ─── PRODUCT CARDS ─── */
.product-card {
  background: var(--white);
  border: 1px solid var(--gray-200);
  border-radius: 16px;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  display: flex; flex-direction: column;
  position: relative;
  transition: all .2s;
  height: 100%;
}
.product-card:hover {
  border-color: var(--gray-400);
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(0,0,0,.09);
  text-decoration: none;
  color: inherit;
}
.product-img-wrap {
  background: var(--gray-100);
  height: 175px;
  display: flex; align-items: center; justify-content: center;
  font-size: 60px;
  position: relative; overflow: hidden;
}
.product-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
.product-badge {
  position: absolute; top: 10px; left: 10px;
  font-size: 10px; font-weight: 700;
  padding: 3px 9px;
  border-radius: 6px;
  letter-spacing: .04em;
  text-transform: uppercase;
}
.badge-new  { background: var(--green);  color: #fff; }
.badge-hot  { background: var(--red);    color: #fff; }
.badge-promo{ background: var(--amber);  color: #fff; }
.wishlist-btn {
  position: absolute; top: 10px; right: 10px;
  width: 32px; height: 32px;
  background: var(--white);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; opacity: 0;
  transition: opacity .2s;
  border: 1px solid var(--gray-200);
}
.product-card:hover .wishlist-btn { opacity: 1; }
.wishlist-btn i { color: var(--gray-600); font-size: 14px; }

.product-info {
  padding: 14px 14px 8px;
  flex: 1;
  display: flex; flex-direction: column; gap: 5px;
}
.product-cat-tag  { font-size: 11px; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: .05em; }
.product-title    { font-family: var(--font-display); font-size: 14px; font-weight: 600; color: var(--black); line-height: 1.3; }
.product-seller   { font-size: 11.5px; color: var(--gray-400); }
.product-stars    { display: flex; align-items: center; gap: 4px; font-size: 12px; color: var(--amber); }
.product-stars span{ color: var(--gray-600); font-size: 11px; }
.product-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding: 10px 14px;
  border-top: 1px solid var(--gray-100);
}
.product-price { font-family: var(--font-display); font-size: 17px; font-weight: 700; color: var(--black); }
.add-cart-btn {
  width: 34px; height: 34px;
  background: var(--accent);
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; border: none;
  transition: all .15s;
  flex-shrink: 0;
}
.add-cart-btn:hover  { background: var(--accent-dark); }
.add-cart-btn:active { transform: scale(.92); }
.add-cart-btn i      { color: #fff; font-size: 15px; }

/* ─── RECOMMENDATIONS ─── */
.reco-header {
  background: linear-gradient(135deg, #0f1f3d, #1a3a6b);
  border-radius: 16px 16px 0 0;
  padding: 22px 28px;
}
.reco-icon {
  width: 42px; height: 42px;
  background: rgba(96,165,250,.15);
  border: 1px solid rgba(96,165,250,.3);
  border-radius: 11px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
}
.reco-title { font-family: var(--font-display); font-size: 17px; font-weight: 700; color: var(--white); }
.reco-sub   { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }
.reco-tag   {
  background: rgba(37,99,235,.25);
  border: 1px solid rgba(96,165,250,.4);
  color: #93c5fd;
  font-size: 12px; font-weight: 600;
  padding: 5px 16px;
  border-radius: 20px;
  letter-spacing: .04em;
}
.reco-body {
  background: var(--white);
  border: 1px solid var(--gray-200);
  border-top: none;
  border-radius: 0 0 16px 16px;
  padding: 22px;
}

/* ─── FOOTER ─── */
.site-footer {
  background: var(--blue-dark);
  color: rgba(255,255,255,.5);
  font-size: 13px;
}
.site-footer strong { color: var(--white); }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation: fadeUp .45s ease both; }
.fade-up:nth-child(1){animation-delay:.05s}
.fade-up:nth-child(2){animation-delay:.1s}
.fade-up:nth-child(3){animation-delay:.15s}
.fade-up:nth-child(4){animation-delay:.2s}
.fade-up:nth-child(5){animation-delay:.25s}
.fade-up:nth-child(6){animation-delay:.3s}
.fade-up:nth-child(7){animation-delay:.35s}
.fade-up:nth-child(8){animation-delay:.4s}

/* ─── RESPONSIVE ─── */
@media (max-width: 992px) {
  .hero-title  { font-size: 32px; }
  .hero-visual { display: none; }
}
@media (max-width: 576px) {
  .hero-title   { font-size: 26px; }
  .btn-sell span{ display: none; }
  .trust-item   { padding: 10px 14px; }
}
</style>
</head>
<body style="background:var(--gray-50);">

<!-- ── TOPBAR ── -->
<div class="topbar text-center">
  Livraison gratuite dès 200 TND &nbsp;·&nbsp; <span>Retour 30 jours</span> &nbsp;·&nbsp; Garantie 12 mois sur tous les produits
</div>

<!-- ── NAVBAR ── -->
<nav class="main-nav">
  <div class="container-fluid px-4">

    <!-- Row 1 : Logo + Search + Actions -->
    <div class="d-flex align-items-center gap-3 py-2">

      <!-- LOGO -->
      <a href="/" class="logo-wrap flex-shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="ApexDevice" class="logo-img"
             onerror="this.style.display='none';document.getElementById('logo-fallback').style.display='flex';">
        <div id="logo-fallback" class="logo-fallback flex-column">
          <div class="logo-name"><span class="apex">Apex</span><span class="device">Device</span></div>
          <span class="logo-sub">Electronics E-Commerce</span>
        </div>
      </a>

      <!-- SEARCH -->
      <div class="flex-grow-1" style="max-width:520px;">
        <form action="/" method="GET" class="search-form d-flex">
          @if(request('cat'))<input type="hidden" name="cat" value="{{ request('cat') }}">@endif
          <input type="text" name="search" class="form-control"
                 value="{{ request('search') }}"
                 placeholder="Rechercher un smartphone, laptop, console…"
                 autocomplete="off">
          <button type="submit" class="btn-search flex-shrink-0">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

      <!-- RIGHT ACTIONS -->
      <div class="d-flex align-items-center gap-1 ms-auto">

        <!-- Sell -->
        <a href="/vendeur/produits/creer" class="btn-sell">
          <i class="bi bi-plus-circle"></i>
          <span>Vendre un appareil</span>
        </a>

        <div style="width:1px;height:30px;background:var(--gray-200);margin:0 4px;"></div>

        <!-- Cart -->
        <a href="/panier" class="nav-icon-btn">
          <i class="bi bi-bag"></i>
          <span class="nav-icon-label">Panier</span>
          <span class="nav-badge"></span>
        </a>

        <!-- Messages -->
        <a href="/messages" class="nav-icon-btn">
          <i class="bi bi-chat-dots"></i>
          <span class="nav-icon-label">Messages</span>
        </a>

        @auth
          <!-- Profile (authenticated) -->
          <a href="/profil" class="nav-icon-btn">
            <i class="bi bi-person-circle"></i>
            <span class="nav-icon-label">{{ Str::limit(Auth::user()->name, 8) }}</span>
          </a>
        @else
          <!-- Profile icon (guest) -->
          <a href="/login" class="nav-icon-btn">
            <i class="bi bi-person"></i>
            <span class="nav-icon-label">Profil</span>
          </a>
          <a href="/login"    class="btn-login">Connexion</a>
          <a href="/register" class="btn-register">S'inscrire</a>
        @endauth
      </div>
    </div>

    <!-- Row 2 : Category bar -->
    <div class="cat-bar">
      {{-- Bons plans — rose + étoile SVG comme Back Market --}}
      <a href="/" class="cat-link-bonplan {{ !request('cat') && !request('search') ? 'active' : '' }}">
        <svg class="bonplan-star" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2C12 2 9.5 7.5 8 9C6.5 10.5 2 10.5 2 10.5C2 10.5 5.5 13.5 6 16C6.5 18.5 4.5 22 4.5 22C4.5 22 8 20 10 19.5C12 19 12 19 12 19C12 19 12 19 14 19.5C16 20 19.5 22 19.5 22C19.5 22 17.5 18.5 18 16C18.5 13.5 22 10.5 22 10.5C22 10.5 17.5 10.5 16 9C14.5 7.5 12 2 12 2Z" fill="#db3060"/>
        </svg>
        Bons plans
      </a>
      @foreach($categories as $cat)
        <a href="/?cat={{ $cat->slug }}" class="cat-link {{ request('cat') == $cat->slug ? 'active' : '' }}">
          {{ $cat->name }}
        </a>
      @endforeach
    </div>

  </div>
</nav>

<!-- ── HERO ── -->
<section class="hero-section">
  <div class="container-fluid px-4 position-relative" style="z-index:1;">
    <div class="row align-items-center" style="min-height:360px;">

      <!-- Text -->
      <div class="col-lg-6 py-5">
        <div class="hero-badge mb-4">✦ Nouveautés Avril 2026</div>
        <h1 class="hero-title mb-4">La tech premium,<br>au <span>meilleur prix</span></h1>
        <p class="hero-desc lh-lg mb-5">Des milliers de produits électroniques certifiés, vendus par des vendeurs vérifiés partout en Tunisie.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="/?tri=recent"              class="btn-hero-white">Explorer les produits</a>
          <a href="/vendeur/produits/creer"   class="btn-hero-outline">Vendre un appareil</a>
        </div>
      </div>

      <!-- Visual -->
      <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center py-4">
        <div class="hero-img-stack">
          <img src="{{ asset('images/pic1.avif') }}" alt="Produit 1" class="himg">
          <img src="{{ asset('images/pic2.PNG') }}" alt="Produit 2" class="himg">
          <img src="{{ asset('images/pic1.avif') }}" alt="Produit 3" class="himg">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── TRUST STRIP ── -->
<div class="trust-strip">
  <div class="container-fluid px-4">

    <p class="trust-strip-headline mb-4">Ici, on s&rsquo;offre le meilleur de l&rsquo;électronique.</p>
    <p class="trust-strip-sub lh-lg mb-5">
      Moins cher et aussi performant que le neuf grâce à notre
      <a href="#">Engagement Qualité ApexDevice.</a>
    </p>

    <div class="trust-items-row">
      <div class="row g-0 w-100">

        <div class="col-md-3 col-6">
          <div class="trust-item h-100">
            <!-- icône : étoile outline cercle -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 6l1.5 4H18l-3.6 2.6 1.4 4.2L12 14l-3.8 2.8 1.4-4.2L6 10h4.5z"/>
            </svg>
            Vendeurs vérifiés
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="trust-item h-100">
            <!-- icône : liste avec coche -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <line x1="8" y1="6"  x2="21" y2="6"/>
              <line x1="8" y1="12" x2="21" y2="12"/>
              <line x1="8" y1="18" x2="21" y2="18"/>
              <polyline points="3 6 4 7 6 5"/>
              <polyline points="3 12 4 13 6 11"/>
              <polyline points="3 18 4 19 6 17"/>
            </svg>
            Jusqu&rsquo;à 100 points de contrôle
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="trust-item h-100">
            <!-- icône : flèches gauche-droite -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M7 16H3l5 5 5-5h-4V3H7v13z" opacity=".4"/>
              <path d="M17 8h4l-5-5-5 5h4v13h2V8z"/>
            </svg>
            Retour gratuit sous 30 jours
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="trust-item h-100" style="border-right:none;">
            <!-- icône : médaille / award -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="9" r="5"/>
              <path d="M8.5 14.5L7 22l5-3 5 3-1.5-7.5"/>
            </svg>
            12 mois de garantie
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- ── PRODUCTS (Nouveautés) ── -->
<section class="py-5" style="background:var(--white);">
  <div class="container-fluid px-4">
    <div class="d-flex align-items-baseline justify-content-between mb-3">
      <h2 class="section-title mb-0">
        @if(request('search')) Résultats pour "{{ request('search') }}"
        @elseif(request('cat')) {{ $categories->firstWhere('slug', request('cat'))?->name ?? 'Produits' }}
        @else Nouveautés
        @endif
      </h2>
      @if($latestProducts->isNotEmpty())
        <a href="/" class="section-link">Voir tout →</a>
      @endif
    </div>

    <!-- Filters — affichés uniquement s'il y a des produits -->
    @if($latestProducts->isNotEmpty())
      <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
        <span class="filter-label">Trier :</span>
        <button class="filter-chip {{ !request('tri') || request('tri') == 'recent'  ? 'active' : '' }}" onclick="setFilter('recent')">Plus récents</button>
        <button class="filter-chip {{ request('tri') == 'prix-asc'                   ? 'active' : '' }}" onclick="setFilter('prix-asc')">Prix ↑</button>
        <button class="filter-chip {{ request('tri') == 'prix-desc'                  ? 'active' : '' }}" onclick="setFilter('prix-desc')">Prix ↓</button>
        <button class="filter-chip {{ request('tri') == 'populaire'                  ? 'active' : '' }}" onclick="setFilter('populaire')">Populaires</button>
      </div>
    @endif

    <div class="row g-3">
      @forelse($latestProducts as $p)
        <div class="col-6 col-md-4 col-xl-3">
          <a href="/produits/{{ $p->id }}" class="product-card fade-up">
            <div class="product-img-wrap">
              @if($p->image)
                <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->title }}">
              @else
                @switch($p->category->slug ?? '')
                  @case('smartphones')          <span>📱</span> @break
                  @case('ordinateurs-portables') <span>💻</span> @break
                  @case('consoles')             <span>🎮</span> @break
                  @case('audio')               <span>🎧</span> @break
                  @case('tablettes')            <span>📲</span> @break
                  @case('montres-connectees')   <span>⌚</span> @break
                  @default                       <span>📦</span>
                @endswitch
              @endif
              <span class="product-badge badge-new">Nouveau</span>
              <div class="wishlist-btn"><i class="bi bi-heart"></i></div>
            </div>
            <div class="product-info">
              <div class="product-cat-tag">{{ $p->category->name ?? 'Électronique' }}</div>
              <div class="product-title">{{ $p->title }}</div>
              <div class="product-seller">Par {{ $p->user->name ?? 'Vendeur' }}</div>
              <div class="product-stars">
                @php $r = round($p->averageRating()); @endphp
                @for($i=1;$i<=5;$i++){{ $i<=$r ? '★' : '☆' }}@endfor
                <span>({{ $p->reviews_count ?? 0 }} avis)</span>
              </div>
            </div>
            <div class="product-footer">
              <div class="product-price">{{ number_format($p->price, 0, ',', ' ') }} TND</div>
              <form action="/panier/ajouter" method="POST" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="product_id" value="{{ $p->id }}">
                <button type="submit" class="add-cart-btn">
                  <i class="bi bi-bag-plus"></i>
                </button>
              </form>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center py-5 px-3" style="background:var(--gray-50);border-radius:16px;border:1px dashed var(--gray-200);">
            <div style="font-size:48px;margin-bottom:16px;">🛍️</div>
            <h5 style="font-family:var(--font-display);font-weight:700;color:var(--black);margin-bottom:8px;">
              Aucun produit disponible pour le moment
            </h5>
            <p style="color:var(--gray-400);font-size:14px;max-width:360px;margin:0 auto 20px;">
              Notre catalogue est en cours de constitution. Revenez bientôt — de belles nouveautés arrivent !
            </p>
            <a href="/vendeur/produits/creer" class="btn-sell" style="display:inline-flex;">
              <i class="bi bi-plus-circle"></i> Ajouter le premier produit
            </a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ── RECOMMENDATIONS ── -->
<section class="pb-5">
  <div class="container-fluid px-4">
    <div class="reco-header d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <div class="reco-icon">✦</div>
        <div>
          <div class="reco-title">Recommandés pour vous</div>
          <div class="reco-sub">Basé sur votre historique de navigation</div>
        </div>
      </div>
      <span class="reco-tag">{{ session('last_category', 'Populaires') }}</span>
    </div>
    <div class="reco-body">
      <div class="row g-3">
        @forelse($recommended as $p)
          <div class="col-6 col-md-4 col-xl-3">
            <a href="/produits/{{ $p->id }}" class="product-card fade-up">
              <div class="product-img-wrap">
                @if($p->image)
                  <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->title }}">
                @else
                  <span>📦</span>
                @endif
                <div class="wishlist-btn"><i class="bi bi-heart"></i></div>
              </div>
              <div class="product-info">
                <div class="product-cat-tag">{{ $p->category->name ?? 'Électronique' }}</div>
                <div class="product-title">{{ $p->title }}</div>
                <div class="product-seller">Par {{ $p->user->name ?? 'Vendeur' }}</div>
                <div class="product-stars">
                  @php $r = round($p->averageRating()); @endphp
                  @for($i=1;$i<=5;$i++){{ $i<=$r ? '★' : '☆' }}@endfor
                  <span>({{ $p->reviews_count ?? 0 }} avis)</span>
                </div>
              </div>
              <div class="product-footer">
                <div class="product-price">{{ number_format($p->price, 0, ',', ' ') }} TND</div>
                <form action="/panier/ajouter" method="POST" onclick="event.stopPropagation()">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $p->id }}">
                  <button type="submit" class="add-cart-btn">
                    <i class="bi bi-bag-plus"></i>
                  </button>
                </form>
              </div>
            </a>
          </div>
        @empty
          <div class="col-12 text-center py-4" style="color:var(--gray-400);">Naviguez sur des produits pour obtenir des recommandations.</div>
        @endforelse
      </div>
    </div>
  </div>
</section>

<!-- ── FOOTER ── -->
<footer class="site-footer py-4 text-center">
  <strong>ApexDevice</strong> &copy; {{ date('Y') }} &nbsp;·&nbsp; Electronics E-Commerce &nbsp;·&nbsp; Développé avec Laravel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setFilter(val) {
  const url = new URL(window.location.href);
  url.searchParams.set('tri', val);
  window.location.href = url.toString();
}
</script>
</body>
</html>