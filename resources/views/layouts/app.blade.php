<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'ApexDevice')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root {
      --black:        #0a0a0a;
      --white:        #ffffff;
      --gray-50:      #f8f8f6;
      --gray-100:     #f0efeb;
      --gray-200:     #e0dfd8;
      --gray-400:     #9b9a93;
      --gray-600:     #5c5b56;
      --blue-dark:    #1a3a6b;
      --blue-mid:     #1e55a0;
      --accent:       #2563eb;
      --accent-light: #dbeafe;
      --accent-dark:  #1d4ed8;
      --green:        #16a34a;
      --amber:        #d97706;
      --red:          #dc2626;
      --font-display: 'Syne', sans-serif;
      --font-body:    'DM Sans', sans-serif;
    }
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; background:var(--gray-50); font-family:var(--font-body); color:var(--black); }

    /* ── TOPBAR ── */
    .topbar { background:var(--blue-dark); color:rgba(255,255,255,.75); font-size:12.5px; letter-spacing:.03em; padding:7px 0; }
    .topbar span { color:#93c5fd; font-weight:600; }

    /* ── NAVBAR ── */
    .main-nav { background:var(--white); border-bottom:1px solid var(--gray-200); box-shadow:0 1px 12px rgba(0,0,0,.07); position:sticky; top:0; z-index:1000; }
    .logo-wrap { text-decoration:none; display:flex; align-items:center; gap:10px; }
    .logo-img  { height:44px; width:auto; object-fit:contain; }
    .logo-fallback { display:none; }
    .logo-name { font-family:var(--font-display); font-size:20px; font-weight:800; letter-spacing:-.5px; line-height:1.1; }
    .logo-name .apex   { color:var(--blue-mid); }
    .logo-name .device { color:#4a4a4a; }
    .logo-sub  { font-size:9px; font-weight:600; letter-spacing:.12em; color:var(--gray-400); text-transform:uppercase; }

    .search-form .form-control { border:1.5px solid var(--gray-200); border-right:none; border-radius:10px 0 0 10px; font-size:14px; background:var(--gray-50); color:var(--black); padding:10px 16px; box-shadow:none; }
    .search-form .form-control:focus { border-color:var(--accent); background:var(--white); box-shadow:none; }
    .search-form .form-control::placeholder { color:var(--gray-400); }
    .search-form .btn-search { background:var(--accent); border:none; border-radius:0 10px 10px 0; width:46px; padding:0; display:flex; align-items:center; justify-content:center; transition:background .15s; }
    .search-form .btn-search:hover { background:var(--accent-dark); }
    .search-form .btn-search i { color:#fff; font-size:15px; }

    .btn-sell { background:var(--blue-mid); color:var(--white)!important; font-size:13px; font-weight:600; border-radius:9px; padding:9px 16px; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:7px; white-space:nowrap; transition:background .15s; }
    .btn-sell:hover { background:var(--blue-dark); }

    .nav-icon-btn { display:flex; flex-direction:column; align-items:center; gap:2px; padding:7px 10px; border-radius:9px; color:var(--gray-600); text-decoration:none; background:transparent; border:none; cursor:pointer; transition:all .15s; position:relative; font-family:var(--font-body); }
    .nav-icon-btn:hover { background:var(--gray-100); color:var(--black); }
    .nav-icon-btn i { font-size:20px; }
    .nav-icon-label { font-size:10px; font-weight:500; color:inherit; }
    .nav-badge { position:absolute; top:4px; right:5px; width:8px; height:8px; background:var(--red); border-radius:50%; border:2px solid var(--white); }

    .btn-login { color:var(--accent); border:1.5px solid var(--accent); background:transparent; padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; transition:all .15s; }
    .btn-login:hover { background:var(--accent-light); color:var(--accent); }
    .btn-register { background:var(--accent); color:var(--white); border:none; padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; transition:background .15s; }
    .btn-register:hover { background:var(--accent-dark); color:var(--white); }

    /* ── CAT BAR ── */
    .cat-bar { border-top:1px solid var(--gray-100); display:flex; overflow-x:auto; scrollbar-width:none; }
    .cat-bar::-webkit-scrollbar { display:none; }
    .cat-link { display:inline-flex; align-items:center; padding:13px 18px; font-family:var(--font-display); font-size:13.5px; font-weight:500; letter-spacing:-.01em; color:#1a1a1a; text-decoration:none; white-space:nowrap; border-bottom:2px solid transparent; transition:color .15s, border-color .15s; }
    .cat-link:hover  { color:#000; border-bottom-color:#000; }
    .cat-link.active { color:#000; border-bottom-color:#000; font-weight:700; }
    .cat-link-bonplan { display:inline-flex; align-items:center; gap:6px; padding:13px 18px; font-family:var(--font-display); font-size:13.5px; font-weight:700; letter-spacing:-.01em; color:#db3060; text-decoration:none; white-space:nowrap; border-bottom:2px solid transparent; transition:color .15s, border-color .15s; }
    .cat-link-bonplan:hover  { color:#b02050; border-bottom-color:#db3060; }
    .cat-link-bonplan.active { border-bottom-color:#db3060; }
    .bonplan-star { width:15px; height:15px; flex-shrink:0; }

    /* ── FOOTER ── */
    .site-footer { background:var(--blue-dark); color:rgba(255,255,255,.5); font-size:13px; }
    .site-footer strong { color:var(--white); }

    /* ── Flash messages ── */
    .flash-success { background:#f0fdf4; border:1px solid #86efac; border-radius:12px; padding:12px 18px; font-size:14px; color:#16a34a; display:flex; align-items:center; gap:10px; margin:16px 0; }
    .flash-error   { background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:12px 18px; font-size:14px; color:#dc2626; display:flex; align-items:center; gap:10px; margin:16px 0; }
  </style>

  @yield('styles')
</head>
<body>

<!-- ── TOPBAR ── -->
<div class="topbar text-center">
  Livraison gratuite dès 200 TND &nbsp;·&nbsp; <span>Retour 30 jours</span> &nbsp;·&nbsp; Garantie 12 mois sur tous les produits
</div>

<!-- ── NAVBAR ── -->
<nav class="main-nav">
  <div class="container-fluid px-4">
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

      <!-- ACTIONS -->
      <div class="d-flex align-items-center gap-1 ms-auto">
        <a href="/vendeur/produits/creer" class="btn-sell">
          <i class="bi bi-plus-circle"></i>
          <span>Vendre un appareil</span>
        </a>
        <div style="width:1px;height:30px;background:var(--gray-200);margin:0 4px;"></div>
        <a href="/panier" class="nav-icon-btn">
          <i class="bi bi-bag"></i>
          <span class="nav-icon-label">Panier</span>
          <span class="nav-badge"></span>
        </a>
        <a href="/messages" class="nav-icon-btn">
          <i class="bi bi-chat-dots"></i>
          <span class="nav-icon-label">Messages</span>
        </a>
        @auth
          <a href="/profil" class="nav-icon-btn">
            <i class="bi bi-person-circle"></i>
            <span class="nav-icon-label">{{ Str::limit(Auth::user()->name, 8) }}</span>
          </a>
        @else
          <a href="/login" class="nav-icon-btn">
            <i class="bi bi-person"></i>
            <span class="nav-icon-label">Profil</span>
          </a>
          <a href="/login"    class="btn-login">Connexion</a>
          <a href="/register" class="btn-register">S'inscrire</a>
        @endauth
      </div>
    </div>

    <!-- CAT BAR -->
    <div class="cat-bar">
      <a href="/" class="cat-link-bonplan {{ !request('cat') && !request('search') ? 'active' : '' }}">
        <svg class="bonplan-star" viewBox="0 0 24 24" fill="none">
          <path d="M12 2C12 2 9.5 7.5 8 9C6.5 10.5 2 10.5 2 10.5C2 10.5 5.5 13.5 6 16C6.5 18.5 4.5 22 4.5 22C4.5 22 8 20 10 19.5C12 19 12 19 12 19C12 19 12 19 14 19.5C16 20 19.5 22 19.5 22C19.5 22 17.5 18.5 18 16C18.5 13.5 22 10.5 22 10.5C22 10.5 17.5 10.5 16 9C14.5 7.5 12 2 12 2Z" fill="#db3060"/>
        </svg>
        Bons plans
      </a>
      @foreach(App\Models\Category::orderBy('name')->get() as $cat)
        <a href="/?cat={{ $cat->slug }}" class="cat-link {{ request('cat') == $cat->slug ? 'active' : '' }}">
          {{ $cat->name }}
        </a>
      @endforeach
    </div>
  </div>
</nav>

<!-- ── FLASH MESSAGES ── -->
@if(session('success') || session('error'))
  <div class="container-fluid px-4 mt-3">
    @if(session('success'))
      <div class="flash-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="flash-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif
  </div>
@endif

<!-- ── CONTENU ── -->
@yield('content')

<!-- ── FOOTER ── -->
<footer class="site-footer py-4 text-center mt-5">
  <strong>ApexDevice</strong> &copy; {{ date('Y') }} &nbsp;·&nbsp; Electronics E-Commerce &nbsp;·&nbsp; Développé avec Laravel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>