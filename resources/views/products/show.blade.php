@extends('layouts.app')

@section('content')

<style>
    /* ── BACK MARKET STYLE ── */
    :root {
        --bm-green: #15c26b;
        --bm-green-dark: #0fa058;
        --bm-green-light: #e8faf1;
        --bm-black: #1a1a1a;
        --bm-gray: #f5f5f5;
        --bm-gray2: #e8e8e8;
        --bm-text: #1a1a1a;
        --bm-muted: #717171;
        --bm-border: #e0e0e0;
        --bm-white: #ffffff;
        --bm-radius: 8px;
        --bm-radius-lg: 16px;
        --bm-shadow: 0 2px 8px rgba(0,0,0,0.08);
        --bm-shadow-hover: 0 4px 16px rgba(0,0,0,0.12);
    }

    body { background: #f7f7f7; color: var(--bm-text); font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

    /* BREADCRUMB */
    .bm-breadcrumb { font-size: 13px; color: var(--bm-muted); padding: 14px 0; }
    .bm-breadcrumb a { color: var(--bm-muted); text-decoration: none; }
    .bm-breadcrumb a:hover { color: var(--bm-text); text-decoration: underline; }
    .bm-breadcrumb .sep { margin: 0 6px; }

    /* PAGE LAYOUT */
    .bm-page { max-width: 1100px; margin: 0 auto; padding: 0 20px 60px; }

    /* PRODUCT SECTION */
    .bm-product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        background: var(--bm-white);
        border-radius: var(--bm-radius-lg);
        padding: 32px;
        box-shadow: var(--bm-shadow);
        margin-bottom: 24px;
    }
    @media(max-width:768px){ .bm-product-grid { grid-template-columns: 1fr; padding: 20px; } }

    /* IMAGE */
    .bm-img-wrap {
        background: var(--bm-gray);
        border-radius: var(--bm-radius-lg);
        aspect-ratio: 1;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; position: relative;
    }
    .bm-img-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 20px; }
    .bm-no-img { color: var(--bm-muted); font-size: 13px; text-align: center; }
    .bm-no-img svg { display: block; margin: 0 auto 8px; opacity: .3; }

    /* BADGE */
    .bm-badge {
        display: inline-block; font-size: 11px; font-weight: 600;
        padding: 4px 10px; border-radius: 99px;
        background: var(--bm-green-light); color: var(--bm-green-dark);
        margin-bottom: 12px;
    }
    .bm-badge-cat {
        background: #f0f0f0; color: #555;
    }

    /* TITLE */
    .bm-title { font-size: 24px; font-weight: 700; line-height: 1.3; margin-bottom: 12px; color: var(--bm-text); }

    /* STARS */
    .bm-stars { display: flex; align-items: center; gap: 4px; margin-bottom: 16px; }
    .bm-star { font-size: 16px; color: #f5a623; }
    .bm-star.empty { color: #ddd; }
    .bm-rat-label { font-size: 13px; color: var(--bm-muted); margin-left: 4px; }

    /* PRICE */
    .bm-price { font-size: 32px; font-weight: 800; color: var(--bm-text); margin-bottom: 4px; }
    .bm-price-sub { font-size: 12px; color: var(--bm-muted); margin-bottom: 20px; }

    /* GUARANTEE BADGES */
    .bm-guarantees { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
    .bm-guarantee {
        display: flex; align-items: center; gap: 6px;
        background: var(--bm-gray); border-radius: var(--bm-radius);
        padding: 8px 12px; font-size: 12px; font-weight: 500; color: var(--bm-text);
    }
    .bm-guarantee .icon { font-size: 14px; }

    /* DESCRIPTION */
    .bm-desc { font-size: 14px; color: var(--bm-muted); line-height: 1.7; margin-bottom: 24px; }

    /* BUTTONS */
    .bm-btn-primary {
        display: block; width: 100%; padding: 15px;
        background: var(--bm-green); color: #fff;
        border: none; border-radius: var(--bm-radius);
        font-size: 15px; font-weight: 700; cursor: pointer;
        text-align: center; text-decoration: none;
        transition: background .2s;
    }
    .bm-btn-primary:hover { background: var(--bm-green-dark); color: #fff; }
    .bm-btn-secondary {
        display: block; width: 100%; padding: 13px;
        background: transparent; color: var(--bm-text);
        border: 1.5px solid var(--bm-border); border-radius: var(--bm-radius);
        font-size: 14px; font-weight: 600; cursor: pointer;
        text-align: center; text-decoration: none; margin-top: 10px;
        transition: border-color .2s, background .2s;
    }
    .bm-btn-secondary:hover { border-color: var(--bm-text); background: var(--bm-gray); }

    /* DIVIDER */
    .bm-divider { border: none; border-top: 1px solid var(--bm-border); margin: 24px 0; }

    /* CARD */
    .bm-card {
        background: var(--bm-white); border-radius: var(--bm-radius-lg);
        box-shadow: var(--bm-shadow); padding: 24px; margin-bottom: 16px;
    }
    .bm-card-title { font-size: 18px; font-weight: 700; color: var(--bm-text); margin-bottom: 16px; }

    /* SELLER */
    .bm-seller-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .bm-seller-left { display: flex; align-items: center; gap: 14px; }
    .bm-avatar {
        width: 50px; height: 50px; border-radius: 50%;
        background: var(--bm-green-light); color: var(--bm-green-dark);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px; flex-shrink: 0;
        border: 2px solid var(--bm-green);
    }
    .bm-seller-name { font-size: 15px; font-weight: 700; color: var(--bm-text); }
    .bm-seller-meta { font-size: 12px; color: var(--bm-muted); margin-top: 2px; }
    .bm-btn-msg {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: var(--bm-radius);
        background: var(--bm-green-light); color: var(--bm-green-dark);
        border: 1.5px solid var(--bm-green); font-size: 13px; font-weight: 700;
        cursor: pointer; transition: all .2s; text-decoration: none;
    }
    .bm-btn-msg:hover { background: var(--bm-green); color: #fff; }

    /* MSG FORM */
    .bm-msg-form {
        display: none; margin-top: 16px; padding-top: 16px;
        border-top: 1px solid var(--bm-border);
    }
    .bm-form-label { font-size: 13px; font-weight: 600; color: var(--bm-text); margin-bottom: 8px; display: block; }
    .bm-form-hint { font-size: 12px; color: var(--bm-muted); margin-bottom: 10px; }
    .bm-form-hint code { background: var(--bm-gray); padding: 2px 6px; border-radius: 4px; font-size: 11px; }
    .bm-textarea, .bm-select {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid var(--bm-border); border-radius: var(--bm-radius);
        font-size: 14px; font-family: inherit; background: var(--bm-white);
        color: var(--bm-text); outline: none; transition: border .2s; resize: vertical;
    }
    .bm-textarea:focus, .bm-select:focus { border-color: var(--bm-green); }
    .bm-form-row { display: flex; gap: 8px; justify-content: flex-end; margin-top: 10px; }
    .bm-btn-sm-ghost {
        padding: 9px 16px; border-radius: var(--bm-radius);
        background: transparent; border: 1.5px solid var(--bm-border);
        font-size: 13px; font-weight: 600; cursor: pointer; color: var(--bm-muted);
    }
    .bm-btn-sm-ghost:hover { color: var(--bm-text); border-color: var(--bm-text); }
    .bm-btn-sm-green {
        padding: 9px 16px; border-radius: var(--bm-radius);
        background: var(--bm-green); border: none;
        font-size: 13px; font-weight: 700; cursor: pointer; color: #fff;
    }
    .bm-btn-sm-green:hover { background: var(--bm-green-dark); }

    /* ALERT */
    .bm-alert { padding: 12px 16px; border-radius: var(--bm-radius); font-size: 13px; margin-top: 10px; }
    .bm-alert-success { background: var(--bm-green-light); color: var(--bm-green-dark); border: 1px solid #a8e6c8; }
    .bm-alert-warning { background: #fff8e1; color: #795600; border: 1px solid #ffe082; }
    .bm-alert-info { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .bm-alert-danger { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

    /* REVIEWS */
    .bm-reviews-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .bm-score-big { font-size: 44px; font-weight: 800; color: var(--bm-text); line-height: 1; }
    .bm-rev-card {
        background: var(--bm-white); border: 1px solid var(--bm-border);
        border-radius: var(--bm-radius-lg); padding: 16px 20px; margin-bottom: 12px;
        transition: box-shadow .2s;
    }
    .bm-rev-card:hover { box-shadow: var(--bm-shadow-hover); }
    .bm-rev-top { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .bm-avatar-sm {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; flex-shrink: 0;
    }
    .bm-av-1 { background: #e3f2fd; color: #1565c0; }
    .bm-av-2 { background: #fce4ec; color: #880e4f; }
    .bm-av-3 { background: var(--bm-green-light); color: var(--bm-green-dark); }
    .bm-av-4 { background: #fff3e0; color: #e65100; }
    .bm-av-5 { background: #f3e5f5; color: #6a1b9a; }
    .bm-rev-author { font-size: 14px; font-weight: 700; color: var(--bm-text); }
    .bm-rev-date { font-size: 12px; color: var(--bm-muted); }
    .bm-rev-text { font-size: 14px; color: var(--bm-muted); line-height: 1.65; }
    .bm-no-rev {
        text-align: center; padding: 32px; color: var(--bm-muted); font-size: 14px;
        background: var(--bm-gray); border-radius: var(--bm-radius-lg); margin-bottom: 16px;
    }

    /* STAR PICKER */
    .bm-star-picker { display: flex; gap: 8px; margin-bottom: 16px; }
    .bm-sp { font-size: 28px; cursor: pointer; color: #ddd; transition: color .12s, transform .12s; user-select: none; }
    .bm-sp:hover, .bm-sp.on { color: #f5a623; }
    .bm-sp:hover { transform: scale(1.2); }
</style>

<div class="bm-page">

    {{-- BREADCRUMB --}}
    <div class="bm-breadcrumb">
        <a href="{{ url('/') }}">Accueil</a>
        <span class="sep">›</span>
        <a href="{{ route('products.index') }}">Catalogue</a>
        <span class="sep">›</span>
        <span>{{ Str::limit($product->title, 40) }}</span>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bm-alert bm-alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bm-alert bm-alert-danger mb-3">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bm-alert bm-alert-danger mb-3">
            @foreach($errors->all() as $e){{ $e }}<br>@endforeach
        </div>
    @endif

    {{-- ═══ PRODUIT ═══ --}}
    <div class="bm-product-grid">

        {{-- IMAGE --}}
        <div class="bm-img-wrap">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
            @else
                <div class="bm-no-img">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
                        <rect x="3" y="3" width="18" height="18" rx="3"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="M21 15l-5-5L5 21"/>
                    </svg>
                    Aucune image disponible
                </div>
            @endif
        </div>

        {{-- INFOS --}}
        <div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px;">
                @if($product->category)
                    <span class="bm-badge bm-badge-cat">{{ $product->category->name }}</span>
                @endif
                <span class="bm-badge">✓ Disponible</span>
            </div>

            <h1 class="bm-title">{{ $product->title }}</h1>

            @php
                $avg = $product->reviews->avg('rating') ?? 0;
                $count = $product->reviews->count();
            @endphp
            <div class="bm-stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="bm-star {{ $i <= round($avg) ? '' : 'empty' }}">★</span>
                @endfor
                <span class="bm-rat-label">{{ number_format($avg,1) }}/5 · {{ $count }} avis</span>
            </div>

            <div class="bm-price">{{ number_format($product->price, 3, ',', ' ') }} TND</div>
            <div class="bm-price-sub">Prix TTC · Frais de livraison offerts</div>

            {{-- GARANTIES style Back Market --}}
            <div class="bm-guarantees">
                <div class="bm-guarantee"><span class="icon">🛡️</span> Garantie 12 mois</div>
                <div class="bm-guarantee"><span class="icon">↩️</span> Retour 30 jours</div>
                <div class="bm-guarantee"><span class="icon">🚚</span> Livraison gratuite</div>
            </div>

            <p class="bm-desc">{{ $product->description }}</p>

            @auth
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bm-btn-primary">🛒 Ajouter au panier</button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="bm-btn-primary">Connectez-vous pour acheter</a>
            @endauth

            <a href="{{ route('products.index') }}" class="bm-btn-secondary">← Retour au catalogue</a>
        </div>
    </div>

    {{-- ═══ VENDEUR ═══ --}}
    <div class="bm-card">
        <div class="bm-card-title">Vendu par</div>
        <div class="bm-seller-row">
            <div class="bm-seller-left">
                <div class="bm-avatar">
                    {{ strtoupper(substr($product->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $product->user->name)[1] ?? $product->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="bm-seller-name">{{ $product->user->name }}</div>
                    <div class="bm-seller-meta">
                        Membre depuis {{ $product->user->created_at->format('M Y') }}
                        @php
                            $sellerAvg = \App\Models\Review::whereHas('product', fn($q) => $q->where('user_id', $product->user_id))->avg('rating');
                        @endphp
                        @if($sellerAvg) · ★ {{ number_format($sellerAvg,1) }} @endif
                        · {{ \App\Models\Product::where('user_id',$product->user_id)->count() }} produit(s)
                    </div>
                </div>
            </div>

            @auth
                @if(auth()->id() !== $product->user_id)
                    <button class="bm-btn-msg" id="toggle-msg">
                        <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round">
                            <path d="M14 2H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2v2.5l3-2.5h7a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Z"/>
                        </svg>
                        Contacter le vendeur
                    </button>
                @endif
            @else
                <a href="{{ url('/login') }}" class="bm-btn-msg">
                    <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round">
                        <path d="M14 2H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2v2.5l3-2.5h7a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Z"/>
                    </svg>
                    Contacter le vendeur
                </a>
            @endauth
        </div>

        @auth
            @if(auth()->id() !== $product->user_id)
            <div class="bm-msg-form" id="msg-form">
                <p class="bm-form-hint">
                    Message privé → table <code>messages</code>
                    (sender: {{ auth()->id() }}, receiver: {{ $product->user_id }})
                </p>
                <form action="{{ route('messages.storeFromProduct') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $product->user_id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label class="bm-form-label">Votre message à {{ $product->user->name }}</label>
                    <textarea name="content" class="bm-textarea" rows="3"
                              placeholder="Bonjour, est-ce que ce produit est encore disponible ?"
                              required></textarea>
                    <div class="bm-form-row">
                        <button type="button" class="bm-btn-sm-ghost" id="cancel-msg">Annuler</button>
                        <button type="submit" class="bm-btn-sm-green">Envoyer</button>
                    </div>
                </form>
            </div>
            @endif
        @endauth
    </div>

    {{-- ═══ AVIS ═══ --}}
    <div class="bm-card">
        <div class="bm-reviews-header">
            <div class="bm-card-title" style="margin-bottom:0;">Avis clients</div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="bm-score-big">{{ number_format($avg,1) }}</div>
                <div>
                    <div class="bm-stars">
                        @for($i=1;$i<=5;$i++)
                            <span class="bm-star {{ $i<=round($avg)?'':'empty' }}">★</span>
                        @endfor
                    </div>
                    <div style="font-size:12px;color:var(--bm-muted);">{{ $count }} avis</div>
                </div>
            </div>
        </div>

        <hr class="bm-divider">

        @forelse($product->reviews as $review)
            @php $avColors=['bm-av-1','bm-av-2','bm-av-3','bm-av-4','bm-av-5']; @endphp
            <div class="bm-rev-card">
                <div class="bm-rev-top">
                    <div class="bm-avatar-sm {{ $avColors[$loop->index % 5] }}">
                        {{ strtoupper(substr($review->user->name,0,1)) }}
                    </div>
                    <div style="flex:1;">
                        <div class="bm-rev-author">{{ $review->user->name }}</div>
                        <div class="bm-rev-date">{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="bm-stars">
                        @for($i=1;$i<=5;$i++)
                            <span class="bm-star {{ $i<=$review->rating?'':'empty' }}" style="font-size:13px;">★</span>
                        @endfor
                    </div>
                </div>
                @if($review->comment)
                    <p class="bm-rev-text">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <div class="bm-no-rev">
                Aucun avis pour ce produit. Soyez le premier !
            </div>
        @endforelse

        {{-- FORMULAIRE AVIS --}}
        @auth
            @php $alreadyReviewed = $product->reviews->where('user_id', auth()->id())->isNotEmpty(); @endphp
            @if($alreadyReviewed)
                <div class="bm-alert bm-alert-info">✓ Vous avez déjà laissé un avis pour ce produit.</div>
            @elseif(auth()->id() === $product->user_id)
                <div class="bm-alert bm-alert-warning">Vous ne pouvez pas évaluer votre propre produit.</div>
            @else
                <hr class="bm-divider">
                <div class="bm-card-title">Laisser un avis</div>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="rating" id="rating-input" value="0">

                    <label class="bm-form-label">Votre note</label>
                    <div class="bm-star-picker" id="star-picker">
                        @for($i=1;$i<=5;$i++)
                            <span class="bm-sp" data-val="{{ $i }}">★</span>
                        @endfor
                    </div>

                    <label class="bm-form-label">Votre commentaire</label>
                    <textarea name="comment" class="bm-textarea" rows="3"
                              placeholder="Partagez votre expérience avec ce produit..."
                              style="margin-bottom:14px;"></textarea>

                    <button type="submit" class="bm-btn-primary">Publier mon avis</button>
                </form>
            @endif
        @else
            <div class="bm-alert bm-alert-info" style="margin-top:10px;">
                <a href="{{ url('/login') }}" style="color:inherit;font-weight:600;">Connectez-vous</a> pour laisser un avis.
            </div>
        @endauth
    </div>

</div>

<script>
    // Toggle message form
    const toggleBtn = document.getElementById('toggle-msg');
    const msgForm   = document.getElementById('msg-form');
    const cancelBtn = document.getElementById('cancel-msg');
    if (toggleBtn && msgForm) {
        toggleBtn.addEventListener('click', () => {
            msgForm.style.display = msgForm.style.display === 'block' ? 'none' : 'block';
        });
    }
    if (cancelBtn && msgForm) {
        cancelBtn.addEventListener('click', () => { msgForm.style.display = 'none'; });
    }

    // Star picker
    const picker = document.getElementById('star-picker');
    const ratingInput = document.getElementById('rating-input');
    if (picker) {
        const stars = picker.querySelectorAll('.bm-sp');
        let selected = 0;
        stars.forEach(s => {
            s.addEventListener('mouseenter', () => {
                const v = +s.dataset.val;
                stars.forEach(x => x.style.color = +x.dataset.val <= v ? '#f5a623' : '#ddd');
            });
            s.addEventListener('mouseleave', () => {
                stars.forEach(x => x.style.color = +x.dataset.val <= selected ? '#f5a623' : '#ddd');
            });
            s.addEventListener('click', () => {
                selected = +s.dataset.val;
                ratingInput.value = selected;
                stars.forEach(x => {
                    const on = +x.dataset.val <= selected;
                    x.classList.toggle('on', on);
                    x.style.color = on ? '#f5a623' : '#ddd';
                });
            });
        });
    }
</script>

@endsection