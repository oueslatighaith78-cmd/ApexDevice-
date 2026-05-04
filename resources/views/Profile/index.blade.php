@extends('layouts.app')

@section('title', 'Mon Profil | ApexDevice')

@section('styles')
<style>
    /* Épuration du header */
    .search-form, .cat-bar { display: none !important; }
    .main-nav { border-bottom: 1px solid #e5e7eb; background: #fff; padding: 6px 0; }

    :root{
        --bg-light: #f9fafb;
        --card-bg: #ffffff;
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-color: #e5e7eb;
        --accent-blue: #1a3a6b;
        --accent-green: #106c42;
        --radius: 20px;
    }

    .profile-wrapper {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg-light);
        padding: 30px 0 60px;
        min-height: 100vh;
        color: var(--text-main);
    }

    .container-profile { width: min(1200px, 94%); margin: 0 auto; }
    .grid-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; }

    .card-profile { 
        background: var(--card-bg); 
        border: 1px solid var(--border-color); 
        border-radius: var(--radius); 
        box-shadow: 0 1px 3px rgba(0,0,0,0.02); 
        padding: 24px;
        margin-bottom: 24px;
    }

    .section-title { font-size: 17px; font-weight: 700; color: var(--text-main); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }

    /* Sidebar Navigation */
    .nav-list { display: flex; flex-direction: column; gap: 5px; }
    .nav-item { 
        display: flex; align-items: center; gap: 12px; padding: 12px 15px; 
        border-radius: 12px; color: var(--text-main); font-size: 14px; 
        font-weight: 600; text-decoration: none; transition: 0.2s; 
    }
    .nav-item:hover { background: #f3f4f6; }
    .nav-item.active { background: var(--accent-blue); color: #fff; }

    /* Boutons Rôles */
    .btn-role { margin-top: 10px; padding: 12px; border-radius: 12px; font-weight: 700; font-size: 13px; text-align: center; text-decoration: none; display: block; transition: 0.2s; }
    .btn-boutique { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .btn-boutique:hover { background: #d1fae5; }
    .btn-achats { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; margin-top: 8px; }
    .btn-achats:hover { background: #dbeafe; }

    /* Formulaire */
    .form-control-custom { width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; margin-bottom: 15px; }
    .btn-save { background: var(--accent-blue); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; }

    /* Stats */
    .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-mini { padding: 15px; text-align: center; background: #fff; border: 1px solid var(--border-color); border-radius: 15px; }
    .stat-value { font-size: 20px; font-weight: 800; color: var(--accent-blue); display: block; }
    .stat-label { font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 700; }

    /* Bouton déconnexion */
    .btn-logout {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 15px; border-radius: 12px;
        width: 100%; font-size: 14px; font-weight: 700;
        cursor: pointer; transition: 0.2s;
        color: #dc2626;
        background: #fef2f2;
        border: 1px solid #fecaca;
        text-align: left;
    }
    .btn-logout:hover { background: #fee2e2; }
</style>
@endsection

@section('content')
<div class="profile-wrapper">
    <div class="container-profile">
        <div class="grid-layout">

            {{-- ── Sidebar ── --}}
            <aside>
                <div class="card-profile" style="padding: 15px;">

                    {{-- Avatar + infos --}}
                    <div style="text-align: center; padding: 10px 0 20px;">
                        <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 20px; font-weight: 800; color: var(--accent-blue);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 style="font-size: 15px; font-weight: 700; margin: 0;">{{ $user->name }}</h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0;">{{ $user->email }}</p>
                    </div>

                    {{-- Navigation --}}
                    <nav class="nav-list">
                        <a href="{{ url('/profil') }}" class="nav-item active">
                            <i class="bi bi-person-fill"></i> Mon Profil
                        </a>
                        <a href="{{ url('/messages') }}" class="nav-item">
                            <i class="bi bi-chat-dots-fill"></i> Messages
                        </a>

                        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 10px 0;">

                        {{-- Boutique & Achats --}}
                        <a href="{{ route('boutique.index') }}" class="btn-role btn-boutique">
                            <i class="bi bi-shop"></i> Ma Boutique
                        </a>
                        <a href="{{ route('panier.index') }}" class="btn-role btn-achats">
                            <i class="bi bi-bag-check"></i> Mes Achats
                        </a>

                        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0 10px;">

                        {{-- Retour accueil --}}
                        <a href="{{ url('/') }}" class="nav-item" style="color: var(--text-muted);">
                            <i class="bi bi-arrow-left"></i> Retour boutique
                        </a>

                        {{-- ── BOUTON SE DÉCONNECTER ── --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="bi bi-box-arrow-right"></i> Se déconnecter
                            </button>
                        </form>

                    </nav>
                </div>
            </aside>

            {{-- ── Main Content ── --}}
            <main>

                {{-- Stats --}}
                <div class="stats-row">
                    <div class="stat-mini">
                        <span class="stat-value">{{ $ordersCount }}</span>
                        <span class="stat-label">Commandes</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-value">{{ $cartCount }}</span>
                        <span class="stat-label">Dans le panier</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-value">{{ $unreadNotifications }}</span>
                        <span class="stat-label">Notifications</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-value">{{ number_format($totalSpent, 0) }} DT</span>
                        <span class="stat-label">Dépenses</span>
                    </div>
                </div>

                {{-- Formulaire profil --}}
                <div class="card-profile">
                    <h2 class="section-title"><i class="bi bi-gear-fill"></i> Paramètres personnels</h2>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-muted);">NOM COMPLET</label>
                                <input type="text" name="name" class="form-control-custom" value="{{ $user->name }}">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-muted);">ADRESSE EMAIL</label>
                                <input type="email" name="email" class="form-control-custom" value="{{ $user->email }}">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-muted);">TÉLÉPHONE</label>
                                <input type="text" name="phone" class="form-control-custom" value="{{ $user->phone ?? '' }}" placeholder="Ex: +216 55 123 456">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 12px; font-weight: 700; color: var(--text-muted);">LIEN RÉSEAUX / WEB</label>
                                <input type="text" name="website" class="form-control-custom" value="{{ $user->website ?? '' }}" placeholder="Lien boutique ou profil">
                            </div>
                        </div>
                        <div style="text-align: right; margin-top: 10px;">
                            <button type="submit" class="btn-save">Mettre à jour mon profil</button>
                        </div>
                    </form>
                </div>

                {{-- Activité récente --}}
                <div class="card-profile">
                    <h2 class="section-title"><i class="bi bi-clock-history"></i> Activité récente</h2>
                    <p style="font-size: 13px; color: var(--text-muted);">Retrouvez ici vos derniers messages et statuts de commandes.</p>
                </div>

            </main>

        </div>
    </div>
</div>
@endsection