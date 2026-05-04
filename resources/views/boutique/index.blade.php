@extends('layouts.app')

@section('content')

<style>
  /* Masquer les éléments de recherche du header pour la messagerie */
.search-form, .cat-bar { display: none !important; }
.main-nav { border-bottom: 1px solid #e5e7eb; background: #fff; padding: 6px 0; }
  :root { --bm-green:#1a7a00; --bm-green-light:#eaf3de; }
  .boutique-page { background:#fff; min-height:100vh; padding-bottom:80px; }
  .boutique-hero { background:#fff; border-bottom:1px solid #e8e8e8; padding:36px 0 28px; }
  .boutique-hero h1 { font-size:30px; font-weight:800; color:#1a1a1a; letter-spacing:-0.8px; margin-bottom:4px; }
  .boutique-hero p { font-size:14px; color:#888; margin:0; }
  .stat-card { background:#f7f7f5; border-radius:12px; padding:14px 20px; border:none; }
  .stat-val { font-size:22px; font-weight:800; color:#1a1a1a; letter-spacing:-0.5px; }
  .stat-val.green { color:var(--bm-green); }
  .stat-lbl { font-size:11px; color:#999; margin-top:2px; }
  .btn-new-product { background:#1a1a1a; color:#fff !important; border:none; border-radius:10px; padding:11px 20px; font-size:14px; font-weight:700; display:inline-flex; align-items:center; gap:8px; text-decoration:none; transition:background .15s, transform .1s; cursor:pointer; }
  .btn-new-product:hover { background:#333; transform:translateY(-1px); }
  .btn-new-product .plus { width:20px; height:20px; background:rgba(255,255,255,.2); border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:17px; font-weight:300; }
  .boutique-toolbar { padding:16px 0; display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
  .boutique-toolbar .form-control, .boutique-toolbar .form-select { border:1.5px solid #e0e0e0; border-radius:10px; font-size:13px; height:40px; }
  .boutique-toolbar .form-control:focus, .boutique-toolbar .form-select:focus { border-color:#1a1a1a; box-shadow:none; }
  .search-wrap { position:relative; flex:1; max-width:320px; }
  .search-wrap .bi { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#aaa; font-size:14px; pointer-events:none; }
  .search-wrap .form-control { padding-left:36px; }
  .products-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(210px,1fr)); gap:16px; }
  .product-card { background:#fff; border:1px solid #e8e8e8; border-radius:16px; overflow:hidden; transition:box-shadow .2s, transform .15s; display:flex; flex-direction:column; }
  .product-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.10); transform:translateY(-2px); }
  .card-img-zone { aspect-ratio:1; background:#f7f7f5; position:relative; display:flex; align-items:center; justify-content:center; overflow:hidden; }
  .card-img-zone img { width:100%; height:100%; object-fit:contain; padding:16px; }
  .card-placeholder { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px; width:100%; height:100%; }
  .card-placeholder .ph-icon { font-size:44px; }
  .card-placeholder span { font-size:11px; color:#ccc; }
  .card-status { position:absolute; bottom:8px; left:8px; padding:3px 10px; border-radius:100px; font-size:11px; font-weight:600; display:flex; align-items:center; gap:4px; background:#d6f0c8; color:#1a5c00; }
  .card-actions-hover { position:absolute; top:8px; right:8px; display:flex; gap:5px; opacity:0; transition:opacity .15s; }
  .product-card:hover .card-actions-hover { opacity:1; }
  .card-action-btn { width:30px; height:30px; background:#fff; border:1px solid #e0e0e0; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:background .15s; text-decoration:none; color:#444; }
  .card-action-btn:hover { background:#f5f5f5; color:#444; }
  .card-action-btn.del { color:#e53935; }
  .card-action-btn.del:hover { background:#fff0f0; }
  .card-body-zone { padding:12px 14px 16px; flex:1; display:flex; flex-direction:column; }
  .card-cat { font-size:10px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.6px; margin-bottom:4px; }
  .card-title-text { font-size:13.5px; font-weight:600; color:#1a1a1a; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:8px; }
  .card-price { font-size:19px; font-weight:800; color:var(--bm-green); letter-spacing:-0.3px; margin-top:auto; }
  .card-price span { font-size:13px; font-weight:600; }
  .card-date-text { font-size:11px; color:#bbb; margin-top:3px; }
  .empty-state { text-align:center; padding:70px 16px; grid-column:1/-1; }
  .empty-icon { width:68px; height:68px; background:#f5f5f5; border-radius:18px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; }
  .flash-success { background:#d6f0c8; border:1px solid #b0dfaa; color:#1a5c00; border-radius:10px; padding:12px 16px; font-size:13px; font-weight:500; display:flex; align-items:center; gap:8px; margin-bottom:20px; }
  .modal-content { border-radius:18px !important; border:1px solid #e0e0e0 !important; overflow:hidden; }
  .modal-header { border-bottom:1px solid #f0f0f0; padding:20px 24px 16px; }
  .modal-header .modal-title { font-size:17px; font-weight:800; color:#1a1a1a; }
  .modal-body { padding:20px 24px; }
  .modal-footer { border-top:1px solid #f0f0f0; padding:14px 24px 20px; }
  .modal .form-label { font-size:11px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:5px; }
  .modal .form-control, .modal .form-select { border:1.5px solid #e0e0e0; border-radius:10px; font-size:14px; padding:10px 13px; }
  .modal .form-control:focus, .modal .form-select:focus { border-color:#1a1a1a; box-shadow:none; }
  .modal textarea.form-control { resize:vertical; min-height:85px; }
  .upload-zone { border:2px dashed #d0d0d0; border-radius:12px; padding:22px 16px; text-align:center; cursor:pointer; transition:border-color .2s, background .2s; }
  .upload-zone:hover { border-color:var(--bm-green); background:#f2fbee; }
  .upload-zone p { font-size:13px; color:#888; margin:6px 0 0; }
  .upload-zone strong { color:var(--bm-green); }
  #img-preview { width:100%; max-height:130px; object-fit:cover; border-radius:8px; border:1px solid #e0e0e0; margin-top:10px; display:none; }
  .btn-cancel-modal { background:transparent; border:1.5px solid #e0e0e0; border-radius:9px; padding:9px 18px; font-size:13px; font-weight:600; color:#666; }
  .btn-cancel-modal:hover { background:#f5f5f5; color:#333; }
  .btn-submit-modal { background:#1a1a1a; color:#fff; border:none; border-radius:9px; padding:9px 22px; font-size:13px; font-weight:700; }
  .btn-submit-modal:hover { background:#333; }
  @media(max-width:576px) { .products-grid { grid-template-columns:repeat(2,1fr); gap:10px; } .boutique-hero h1 { font-size:22px; } }
</style>

<div class="boutique-page">

  <div class="boutique-hero">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <h1>Ma boutique</h1>
          <p>Gérez vos articles publiés sur ApexDevice</p>
        </div>
        <button class="btn-new-product" data-bs-toggle="modal" data-bs-target="#modalNouveauProduit">
          <span class="plus">+</span> Nouveau produit
        </button>
      </div>
      <div class="d-flex gap-3 mt-4 flex-wrap">
        <div class="stat-card">
          <div class="stat-val">{{ $products->count() }}</div>
          <div class="stat-lbl">Articles publiés</div>
        </div>
        <div class="stat-card">
          <div class="stat-val green">{{ number_format($products->sum('price'), 0, ',', ' ') }} TND</div>
          <div class="stat-lbl">Valeur totale</div>
        </div>
        <div class="stat-card">
          <div class="stat-val">{{ $products->where('created_at', '>=', now()->subDays(7))->count() }}</div>
          <div class="stat-lbl">Cette semaine</div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">

    @if(session('success'))
      <div class="flash-success mt-4">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
      </div>
    @endif

    <div class="boutique-toolbar">
      <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" class="form-control" id="search-input" placeholder="Rechercher..." oninput="filterCards()">
      </div>
      <select class="form-select" style="width:auto" id="cat-filter" onchange="filterCards()">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->name }}">{{ $cat->name }}</option>
        @endforeach
      </select>
      <select class="form-select" style="width:auto" id="sort-filter" onchange="filterCards()">
        <option value="recent">Plus récent</option>
        <option value="price-asc">Prix croissant</option>
        <option value="price-desc">Prix décroissant</option>
      </select>
    </div>

    <div class="products-grid" id="products-grid">
      @forelse($products as $product)
      <div class="product-card"
           data-title="{{ strtolower($product->title) }}"
           data-cat="{{ $product->category->name ?? '' }}"
           data-price="{{ $product->price }}"
           data-date="{{ $product->created_at->timestamp }}">
        <div class="card-img-zone">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
          @else
            <div class="card-placeholder">
              <span class="ph-icon">
                @switch($product->category->name ?? '')
                  @case('Smartphones') 📱 @break
                  @case('Ordinateurs portables') 💻 @break
                  @case('Tablettes') 📟 @break
                  @case('Consoles') 🎮 @break
                  @case('Montres connectées') ⌚ @break
                  @case('Audio') 🎧 @break
                  @default 📦
                @endswitch
              </span>
              <span>Aucune image</span>
            </div>
          @endif
          <span class="card-status">
            <i class="bi bi-circle-fill" style="font-size:7px"></i> Publié
          </span>
          <div class="card-actions-hover">
            <a href="{{ route('products.edit', $product->id) }}" class="card-action-btn" title="Modifier">
              <i class="bi bi-pencil"></i>
            </a>
            <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Supprimer ce produit ?')">
              @csrf @method('DELETE')
              <button type="submit" class="card-action-btn del" title="Supprimer">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </div>
        </div>
        <div class="card-body-zone">
          <div class="card-cat">{{ $product->category->name ?? 'Autres' }}</div>
          <div class="card-title-text">{{ $product->title }}</div>
          <div class="card-price">{{ number_format($product->price, 0, ',', ' ') }}<span> TND</span></div>
          <div class="card-date-text">{{ $product->created_at->diffForHumans() }}</div>
        </div>
      </div>
      @empty
        <div class="empty-state">
          <div class="empty-icon">📦</div>
          <h4>Aucun produit encore</h4>
          <p>Ajoutez votre premier article à vendre.</p>
          <button class="btn-new-product mt-3" data-bs-toggle="modal" data-bs-target="#modalNouveauProduit">
            <span class="plus">+</span> Ajouter un produit
          </button>
        </div>
      @endforelse
    </div>

  </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalNouveauProduit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouveau produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:13px;border-radius:10px">
              <i class="bi bi-exclamation-circle me-1"></i> Veuillez corriger les erreurs ci-dessous.
            </div>
          @endif
          <div class="mb-3">
            <label class="form-label">Titre *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   placeholder="Ex : iPhone 13 Pro — 256 Go" value="{{ old('title') }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"
                      placeholder="État, caractéristiques, accessoires inclus...">{{ old('description') }}</textarea>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label">Prix (TND) *</label>
              <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                     placeholder="0" min="0" step="0.01" value="{{ old('price') }}" required>
              @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-6">
              <label class="form-label">Catégorie *</label>
              <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Choisir...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="mb-1">
            <label class="form-label">Image du produit</label>
            <div class="upload-zone" onclick="document.getElementById('image-input').click()">
              <i class="bi bi-image" style="font-size:28px;color:#ccc"></i>
              <p>Cliquez pour choisir une image<br><strong>JPG, PNG, WEBP</strong> — max 2 Mo</p>
              <input type="file" id="image-input" name="image" accept="image/*" style="display:none" onchange="previewImg(event)">
            </div>
            <img id="img-preview" alt="Aperçu">
            @error('image')<div class="text-danger mt-1" style="font-size:12px">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn-submit-modal">Publier le produit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function previewImg(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    const el = document.getElementById('img-preview');
    el.src = ev.target.result;
    el.style.display = 'block';
  };
  reader.readAsDataURL(file);
}
function filterCards() {
  const q    = document.getElementById('search-input').value.toLowerCase();
  const cat  = document.getElementById('cat-filter').value;
  const sort = document.getElementById('sort-filter').value;
  const cards = Array.from(document.querySelectorAll('.product-card'));
  cards.forEach(c => {
    const okQ   = c.dataset.title.includes(q);
    const okCat = !cat || c.dataset.cat === cat;
    c.style.display = (okQ && okCat) ? '' : 'none';
  });
  const grid    = document.getElementById('products-grid');
  const visible = cards.filter(c => c.style.display !== 'none');
  visible.sort((a, b) => {
    if (sort === 'price-asc')  return +a.dataset.price - +b.dataset.price;
    if (sort === 'price-desc') return +b.dataset.price - +a.dataset.price;
    return +b.dataset.date - +a.dataset.date;
  });
  visible.forEach(c => grid.appendChild(c));
}
@if($errors->any())
document.addEventListener('DOMContentLoaded', () => {
  new bootstrap.Modal(document.getElementById('modalNouveauProduit')).show();
});
@endif
</script>

@endsection