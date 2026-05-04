<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — ApexDevice</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
  --red: #dc2626;
  --green: #16a34a;
  --green-light: #dcfce7;
  --amber: #d97706;
  --amber-light: #fef3c7;
  --font-display: 'Syne', sans-serif;
  --font-body: 'DM Sans', sans-serif;
}
*, body { font-family: var(--font-body); margin: 0; padding: 0; box-sizing: border-box; }
body { background: var(--gray-50); }

/* ── TOPBAR ── */
.topbar {
  background: var(--blue-dark);
  color: rgba(255,255,255,0.75);
  font-size: 12.5px; letter-spacing: 0.03em;
  padding: 7px 0; text-align: center;
}
.topbar span { color: #93c5fd; font-weight: 600; }

/* ── NAVBAR ── */
.main-nav {
  background: var(--white);
  border-bottom: 1px solid var(--gray-200);
  box-shadow: 0 1px 12px rgba(0,0,0,0.07);
  position: sticky; top: 0; z-index: 1000; padding: 10px 0;
}
.nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 0 32px; }
.logo-wrap { text-decoration: none; display: flex; align-items: center; gap: 8px; }
.logo-name { font-family: var(--font-display); font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
.logo-name .apex { color: var(--blue-mid); }
.logo-name .device { color: #4a4a4a; }
.logo-sub { font-size: 9px; font-weight: 600; letter-spacing: 0.12em; color: var(--gray-400); text-transform: uppercase; }
.admin-badge { background: var(--blue-dark); color: white; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; letter-spacing: 0.06em; text-transform: uppercase; }
.nav-right { display: flex; align-items: center; gap: 12px; }
.btn-back { display: flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 600; color: var(--gray-600); text-decoration: none; border: 1.5px solid var(--gray-200); transition: all .15s; }
.btn-back:hover { border-color: var(--accent); color: var(--accent); }
.btn-logout-nav { display: flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 600; color: var(--red); background: #fef2f2; border: 1.5px solid #fecaca; cursor: pointer; transition: all .15s; font-family: var(--font-body); }
.btn-logout-nav:hover { background: #fee2e2; }

/* ── HERO ── */
.admin-hero {
  background: linear-gradient(135deg, #0f1f3d 0%, #1a3a6b 55%, #1e55a0 100%);
  padding: 36px 32px 72px; position: relative; overflow: hidden;
}
.admin-hero::after { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 80% 50%, rgba(37,99,235,.2) 0%, transparent 60%); pointer-events: none; }
.admin-hero-title { font-family: var(--font-display); font-size: 30px; font-weight: 800; color: white; letter-spacing: -0.5px; position: relative; z-index: 1; }
.admin-hero-sub { color: rgba(255,255,255,0.6); font-size: 14px; margin-top: 6px; position: relative; z-index: 1; }
.hero-date { color: rgba(255,255,255,0.4); font-size: 12px; margin-top: 4px; position: relative; z-index: 1; }

/* ── STATS ── */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; padding: 0 32px; margin-top: -44px; position: relative; z-index: 10; }
.stat-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 16px; padding: 22px 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 16px; transition: transform .2s; }
.stat-card:hover { transform: translateY(-2px); }
.stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
.stat-icon.blue  { background: var(--accent-light); color: var(--accent); }
.stat-icon.green { background: var(--green-light); color: var(--green); }
.stat-icon.orange{ background: #fff7ed; color: #ea580c; }
.stat-icon.red   { background: #fef2f2; color: var(--red); }
.stat-value { font-family: var(--font-display); font-size: 26px; font-weight: 800; color: var(--black); line-height: 1; }
.stat-label { font-size: 11px; color: var(--gray-400); font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.05em; }
.stat-trend { font-size: 11px; margin-top: 4px; font-weight: 600; }
.stat-trend.up { color: var(--green); }
.stat-trend.down { color: var(--red); }

/* ── MAIN ── */
.main-content { padding: 32px; }
.section-title { font-family: var(--font-display); font-size: 18px; font-weight: 700; color: var(--black); display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }

/* ── CHARTS GRID ── */
.charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 32px; }
.chart-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
.chart-title { font-family: var(--font-display); font-size: 15px; font-weight: 700; color: var(--black); margin-bottom: 4px; }
.chart-sub { font-size: 12px; color: var(--gray-400); margin-bottom: 20px; }

/* ── TABLE CARD ── */
.table-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.05); margin-bottom: 32px; }
.table-card-header { padding: 18px 24px; border-bottom: 1px solid var(--gray-100); background: var(--gray-50); font-family: var(--font-display); font-size: 15px; font-weight: 700; color: var(--black); display: flex; align-items: center; justify-content: space-between; }
.custom-table { width: 100%; border-collapse: collapse; }
.custom-table thead th { padding: 12px 20px; font-size: 11px; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 1px solid var(--gray-100); background: var(--gray-50); text-align: left; }
.custom-table tbody td { padding: 14px 20px; font-size: 14px; border-bottom: 1px solid var(--gray-100); color: var(--black); vertical-align: middle; }
.custom-table tbody tr:last-child td { border-bottom: none; }
.custom-table tbody tr:hover { background: var(--gray-50); }

/* ── USER AVATAR ── */
.user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--accent-light); color: var(--accent); display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; font-family: var(--font-display); }
.avatar-green { background: var(--green-light); color: var(--green); }
.avatar-amber { background: var(--amber-light); color: var(--amber); }
.avatar-red { background: #fef2f2; color: var(--red); }

/* ── BADGES ── */
.badge-role { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: 0.04em; text-transform: uppercase; }
.badge-admin { background: var(--blue-dark); color: white; }
.badge-user { background: var(--gray-100); color: var(--gray-600); }
.badge-active { background: var(--green-light); color: var(--green); }

/* ── BUTTONS ── */
.btn-msg { background: var(--accent-light); color: var(--accent); border: none; border-radius: 8px; font-weight: 600; font-size: 12px; padding: 6px 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
.btn-msg:hover { background: #bfdbfe; color: var(--accent); }
.btn-del-sm { background: #fef2f2; color: var(--red); border: none; border-radius: 8px; font-weight: 600; font-size: 12px; padding: 6px 14px; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; cursor: pointer; font-family: var(--font-body); }
.btn-del-sm:hover { background: #fee2e2; }

/* ── PROGRESS BAR ── */
.progress-wrap { background: var(--gray-100); border-radius: 4px; height: 6px; overflow: hidden; }
.progress-fill { height: 100%; border-radius: 4px; background: var(--accent); }

/* ── DELETE SECTION ── */
.delete-section { background: var(--white); border: 1px solid var(--gray-200); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
.delete-header { padding: 18px 24px; border-bottom: 1px solid #fecaca; background: #fef2f2; font-family: var(--font-display); font-size: 15px; font-weight: 700; color: var(--red); display: flex; align-items: center; gap: 10px; }
.delete-body { padding: 24px; }
.form-label-custom { font-size: 12px; font-weight: 700; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: block; }
.form-input-custom { border: 1.5px solid var(--gray-200); border-radius: 10px; padding: 11px 16px; font-size: 14px; font-family: var(--font-body); outline: none; transition: border-color .15s; width: 100%; max-width: 400px; }
.form-input-custom:focus { border-color: var(--red); }
.btn-delete { background: var(--red); color: white; border: none; padding: 11px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background .15s; margin-top: 16px; font-family: var(--font-body); }
.btn-delete:hover { background: #b91c1c; }

/* ── ALERTS ── */
.alert-custom { padding: 14px 20px; border-radius: 12px; font-size: 14px; font-weight: 500; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
.alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

/* ── RECENT ACTIVITY ── */
.activity-item { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--gray-100); }
.activity-item:last-child { border-bottom: none; }
.activity-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.activity-text { font-size: 13px; color: var(--gray-600); flex: 1; }
.activity-text strong { color: var(--black); }
.activity-time { font-size: 11px; color: var(--gray-400); white-space: nowrap; }

@media(max-width: 1024px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .charts-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    Panneau d'administration &nbsp;·&nbsp; <span>ApexDevice</span> &nbsp;·&nbsp; Accès restreint
</div>

{{-- NAVBAR --}}
<nav class="main-nav">
    <div class="nav-inner">
        <div style="display:flex; align-items:center; gap:16px;">
            <a href="{{ url('/') }}" class="logo-wrap">
                <div>
                    <div class="logo-name"><span class="apex">Apex</span><span class="device">Device</span></div>
                    <div class="logo-sub">Electronics E-Commerce</div>
                </div>
            </a>
            <span class="admin-badge"><i class="bi bi-shield-fill"></i> Admin</span>
        </div>
        <div class="nav-right">
            <a href="{{ url('/') }}" class="btn-back"><i class="bi bi-arrow-left"></i> Retour au site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout-nav">
                    <i class="bi bi-box-arrow-right"></i> Se déconnecter
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- HERO --}}
<div class="admin-hero">
    <div class="admin-hero-title">
        <i class="bi bi-speedometer2" style="color:#60a5fa;"></i>
        Tableau de bord Admin
    </div>
    <div class="admin-hero-sub">Bienvenue, {{ Auth::user()->name }} — Gestion de la plateforme ApexDevice</div>
    <div class="hero-date">Samedi 25 Avril 2026 &nbsp;·&nbsp; Dernière mise à jour : il y a 2 min</div>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
        <div>
            <div class="stat-value">{{ $productCount ?? 24 }}</div>
            <div class="stat-label">Produits</div>
            <div class="stat-trend up">↑ +3 ce mois</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
        <div>
            <div class="stat-value">{{ $loyalUsers->count() ?? 3 }}</div>
            <div class="stat-label">Utilisateurs fidèles</div>
            <div class="stat-trend up">↑ +1 cette semaine</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="bi bi-bag-check-fill"></i></div>
        <div>
            <div class="stat-value">18</div>
            <div class="stat-label">Commandes</div>
            <div class="stat-trend up">↑ +5 ce mois</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="bi bi-graph-up-arrow"></i></div>
        <div>
            <div class="stat-value">12 400</div>
            <div class="stat-label">CA (TND)</div>
            <div class="stat-trend up">↑ +18% vs mois dernier</div>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content" style="margin-top: 32px;">

    {{-- Alertes --}}
    @if(session('success'))
        <div class="alert-custom alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-custom alert-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    {{-- CHARTS --}}
    <div class="charts-grid">

        {{-- Courbe des ventes --}}
        <div class="chart-card">
            <div class="chart-title">Évolution des ventes</div>
            <div class="chart-sub">Chiffre d'affaires mensuel — Année 2026</div>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        {{-- Camembert catégories --}}
        <div class="chart-card">
            <div class="chart-title">Ventes par catégorie</div>
            <div class="chart-sub">Répartition des produits vendus</div>
            <canvas id="categoryChart" height="180"></canvas>
        </div>

    </div>

    {{-- Deuxième ligne charts --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">

        {{-- Barres utilisateurs --}}
        <div class="chart-card">
            <div class="chart-title">Activité des utilisateurs</div>
            <div class="chart-sub">Nombre de commandes par utilisateur</div>
            <canvas id="userChart" height="140"></canvas>
        </div>

        {{-- Activité récente --}}
        <div class="chart-card">
            <div class="chart-title">Activité récente</div>
            <div class="chart-sub">Dernières actions sur la plateforme</div>
            <div style="margin-top: 8px;">
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--green);"></div>
                    <div class="activity-text"><strong>Ghaith Oueslati</strong> a passé une commande de 1 200 TND</div>
                    <div class="activity-time">Il y a 5 min</div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--accent);"></div>
                    <div class="activity-text"><strong>Rayen Chaouri</strong> a publié un nouveau produit</div>
                    <div class="activity-time">Il y a 12 min</div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--amber);"></div>
                    <div class="activity-text"><strong>Ahmed Ghribi</strong> a laissé un avis 5 étoiles</div>
                    <div class="activity-time">Il y a 28 min</div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--green);"></div>
                    <div class="activity-text"><strong>Ghaith Oueslati</strong> a contacté un vendeur</div>
                    <div class="activity-time">Il y a 1h</div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--red);"></div>
                    <div class="activity-text"><strong>Ahmed Ghribi</strong> a annulé une commande</div>
                    <div class="activity-time">Il y a 2h</div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--accent);"></div>
                    <div class="activity-text"><strong>Rayen Chaouri</strong> s'est inscrit sur la plateforme</div>
                    <div class="activity-time">Il y a 3h</div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE UTILISATEURS FIDÈLES --}}
    <div class="section-title">
        <i class="bi bi-trophy-fill" style="color:#f59e0b;"></i>
        Utilisateurs les plus actifs
    </div>

    <div class="table-card" style="margin-bottom: 32px;">
        <div class="table-card-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="bi bi-star-fill" style="color:#f59e0b;"></i>
                Top acheteurs — classés par total dépensé
            </div>
            <span style="font-size:12px; color:var(--gray-400); font-weight:400;">Mise à jour en temps réel</span>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Commandes</th>
                    <th>Total Achats</th>
                    <th>Progression</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Données réelles Laravel --}}
                @isset($loyalUsers)
                    @foreach($loyalUsers as $index => $user)
                        <tr>
                            <td><span style="font-weight:700; color:var(--gray-400);">{{ $index + 1 }}</span></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="user-avatar {{ $index == 0 ? 'avatar-amber' : ($index == 1 ? 'avatar-green' : '') }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;">{{ $user->name }}</div>
                                        <span class="badge-role badge-user">User</span>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--gray-600);">{{ $user->email }}</td>
                            <td><span style="font-weight:600;">{{ $user->orders_count ?? '—' }}</span></td>
                            <td>
                                <span style="font-family:var(--font-display); font-weight:700; color:var(--green);">
                                    {{ number_format($user->total_spent, 0, ',', ' ') }} TND
                                </span>
                            </td>
                            <td style="min-width: 120px;">
                                <div class="progress-wrap">
                                    <div class="progress-fill" style="width: {{ min(100, ($user->total_spent / 5000) * 100) }}%; background: var(--green);"></div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('message.index', $user->id) }}" class="btn-msg">
                                    <i class="bi bi-chat-dots"></i> Message
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endisset

                {{-- Données fake --}}
                <tr>
                    <td><span style="font-weight:700; color:#f59e0b;">🥇 1</span></td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar avatar-amber">G</div>
                            <div>
                                <div style="font-weight:600;">Ghaith Oueslati</div>
                                <span class="badge-role badge-user">User</span>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">ghaith.oueslati@gmail.com</td>
                    <td><span style="font-weight:600;">7</span></td>
                    <td><span style="font-family:var(--font-display); font-weight:700; color:var(--green);">4 850 TND</span></td>
                    <td style="min-width:120px;">
                        <div class="progress-wrap"><div class="progress-fill" style="width:97%; background:var(--green);"></div></div>
                    </td>
                    <td><a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a></td>
                </tr>
                <tr>
                    <td><span style="font-weight:700; color:var(--gray-400);">🥈 2</span></td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar avatar-green">R</div>
                            <div>
                                <div style="font-weight:600;">Rayen Chaouri</div>
                                <span class="badge-role badge-user">User</span>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">rayen.chaouri@gmail.com</td>
                    <td><span style="font-weight:600;">5</span></td>
                    <td><span style="font-family:var(--font-display); font-weight:700; color:var(--green);">3 200 TND</span></td>
                    <td style="min-width:120px;">
                        <div class="progress-wrap"><div class="progress-fill" style="width:64%; background:var(--accent);"></div></div>
                    </td>
                    <td><a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a></td>
                </tr>
                <tr>
                    <td><span style="font-weight:700; color:var(--gray-400);">🥉 3</span></td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar">A</div>
                            <div>
                                <div style="font-weight:600;">Ahmed Ghribi</div>
                                <span class="badge-role badge-user">User</span>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">ahmedghribi@gmail.com</td>
                    <td><span style="font-weight:600;">3</span></td>
                    <td><span style="font-family:var(--font-display); font-weight:700; color:var(--green);">1 750 TND</span></td>
                    <td style="min-width:120px;">
                        <div class="progress-wrap"><div class="progress-fill" style="width:35%;"></div></div>
                    </td>
                    <td><a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TABLE TOUS LES UTILISATEURS --}}
    <div class="section-title">
        <i class="bi bi-people-fill" style="color:var(--accent);"></i>
        Tous les utilisateurs
    </div>

    <div class="table-card" style="margin-bottom: 32px;">
        <div class="table-card-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="bi bi-person-lines-fill"></i>
                Liste complète des membres inscrits
            </div>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar avatar-amber">G</div>
                            <span style="font-weight:600;">Ghaith Oueslati</span>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">ghaith.oueslati@gmail.com</td>
                    <td><span class="badge-role badge-admin">Admin</span></td>
                    <td><span class="badge-role badge-active">Actif</span></td>
                    <td style="color:var(--gray-400); font-size:13px;">01 Jan 2026</td>
                    <td>
                        <a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar avatar-green">R</div>
                            <span style="font-weight:600;">Rayen Chaouri</span>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">rayen.chaouri@gmail.com</td>
                    <td><span class="badge-role badge-user">User</span></td>
                    <td><span class="badge-role badge-active">Actif</span></td>
                    <td style="color:var(--gray-400); font-size:13px;">15 Jan 2026</td>
                    <td>
                        <a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="user-avatar">A</div>
                            <span style="font-weight:600;">Ahmed Ghribi</span>
                        </div>
                    </td>
                    <td style="color:var(--gray-600);">ahmedghribi@gmail.com</td>
                    <td><span class="badge-role badge-user">User</span></td>
                    <td><span class="badge-role badge-active">Actif</span></td>
                    <td style="color:var(--gray-400); font-size:13px;">20 Fév 2026</td>
                    <td>
                        <a href="#" class="btn-msg"><i class="bi bi-chat-dots"></i> Message</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- SUPPRIMER UN UTILISATEUR --}}
    <div class="section-title">
        <i class="bi bi-person-x-fill" style="color:var(--red);"></i>
        Supprimer un utilisateur
    </div>

    <div class="delete-section">
        <div class="delete-header">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Zone dangereuse — Suppression d'utilisateur
        </div>
        <div class="delete-body">
            <p style="font-size:13px; color:var(--gray-600); margin-bottom:20px;">
                Cette action est irréversible. L'utilisateur et toutes ses données seront supprimés définitivement.
            </p>
            <form action="{{ route('Admin.users.destroyByName') }}" method="POST">
                @csrf
                @method('DELETE')
                <label for="username" class="form-label-custom">Nom d'utilisateur à supprimer</label>
                <input type="text" class="form-input-custom" id="username" name="username" placeholder="Ex: Ahmed Ghribi" required>
                <br>
                <button type="submit" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                    <i class="bi bi-trash3-fill"></i> Supprimer définitivement
                </button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── COURBE DES VENTES
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
        datasets: [{
            label: 'Chiffre d\'affaires (TND)',
            data: [1200, 1900, 1500, 2800, 2200, 3100, 2700, 3500, 3200, 4100, 3800, 4500],
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#2563eb',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0efeb' }, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9b9a93' } },
            x: { grid: { display: false }, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9b9a93' } }
        }
    }
});

// ── CAMEMBERT CATÉGORIES
const catCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(catCtx, {
    type: 'doughnut',
    data: {
        labels: ['Smartphones', 'Ordinateurs', 'Consoles', 'Audio', 'Tablettes', 'Autres'],
        datasets: [{
            data: [35, 25, 15, 12, 8, 5],
            backgroundColor: ['#2563eb','#16a34a','#d97706','#dc2626','#7c3aed','#9b9a93'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { family: 'DM Sans', size: 11 }, padding: 12 } }
        },
        cutout: '65%'
    }
});

// ── BARRES UTILISATEURS
const userCtx = document.getElementById('userChart').getContext('2d');
new Chart(userCtx, {
    type: 'bar',
    data: {
        labels: ['Ghaith Oueslati', 'Rayen Chaouri', 'Ahmed Ghribi'],
        datasets: [{
            label: 'Commandes',
            data: [7, 5, 3],
            backgroundColor: ['rgba(37,99,235,0.85)', 'rgba(22,163,74,0.85)', 'rgba(217,119,6,0.85)'],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0efeb' }, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9b9a93', stepSize: 1 } },
            x: { grid: { display: false }, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9b9a93' } }
        }
    }
});
</script>
</body>
</html>