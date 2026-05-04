<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer un produit — ApexDevice</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
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
  --red: #dc2626;
  --red-light: #fef2f2;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--gray-50); color: var(--black); min-height: 100vh; }

/* ─── TOPBAR ─── */
.topbar { background: var(--blue-dark); color: var(--white); text-align: center; padding: 8px 24px; font-size: 12.5px; }
.topbar span { color: #93c5fd; font-weight: 500; }

/* ─── NAVBAR ─── */
nav { background: var(--white); border-bottom: 1px solid var(--gray-200); padding: 0 40px; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
.nav-top { display: flex; align-items: center; gap: 16px; padding: 12px 0; }
.logo-wrap { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
.logo-img { height: 46px; width: auto; object-fit: contain; }
.logo-name { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
.logo-name .apex { color: var(--blue-mid); }
.logo-name .device { color: #4a4a4a; }
.logo-sub { font-size: 9px; font-weight: 600; letter-spacing: 0.12em; color: var(--gray-400); text-transform: uppercase; display: block; margin-top: 1px; }
.nav-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
.back-btn { display: flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: 9px; font-size: 13px; color: var(--gray-600); text-decoration: none; border: 1.5px solid var(--gray-200); transition: all 0.15s; }
.back-btn:hover { background: var(--gray-100); color: var(--black); }

/* ─── PAGE ─── */
.page-wrap { max-width: 860px; margin: 0 auto; padding: 48px 24px; }

.page-header { margin-bottom: 32px; }
.page-header h1 { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: var(--black); letter-spacing: -0.5px; margin-bottom: 6px; }
.page-header p { font-size: 14px; color: var(--gray-600); }

/* ─── CARD ─── */
.form-card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 20px; padding: 36px; margin-bottom: 20px; }
.card-title { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; color: var(--black); margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 10px; }
.card-title i { font-size: 18px; color: var(--accent); }

/* ─── FORM ─── */
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 13px; font-weight: 600; color: var(--black); margin-bottom: 8px; }
.form-label span { color: var(--red); margin-left: 2px; }
.form-input {
  width: 100%; padding: 12px 16px;
  border: 1.5px solid var(--gray-200); border-radius: 10px;
  font-size: 14px; font-family: 'DM Sans', sans-serif;
  color: var(--black); background: var(--gray-50); outline: none;
  transition: all 0.2s;
}
.form-input:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
.form-input::placeholder { color: var(--gray-400); }
.form-input.error { border-color: var(--red); background: var(--red-light); }
textarea.form-input { resize: vertical; min-height: 120px; line-height: 1.6; }
select.form-input { cursor: pointer; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.error-msg { font-size: 12px; color: var(--red); margin-top: 5px; display: flex; align-items: center; gap: 4px; }

/* ─── IMAGE UPLOAD ─── */
.upload-zone {
  border: 2px dashed var(--gray-200);
  border-radius: 12px;
  padding: 40px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s;
  position: relative;
  background: var(--gray-50);
}
.upload-zone:hover { border-color: var(--accent); background: var(--accent-light); }
.upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-icon { font-size: 36px; color: var(--gray-400); margin-bottom: 12px; }
.upload-text { font-size: 14px; color: var(--gray-600); margin-bottom: 4px; }
.upload-text strong { color: var(--accent); }
.upload-hint { font-size: 12px; color: var(--gray-400); }
.upload-preview { display: none; margin-top: 16px; }
.upload-preview img { width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px; border: 1px solid var(--gray-200); }

/* ─── ALERT ─── */
.alert { padding: 14px 18px; border-radius: 10px; font-size: 13.5px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 10px; }
.alert-error { background: var(--red-light); color: var(--red); border: 1px solid #fecaca; }
.alert i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }

/* ─── SUBMIT ─── */
.form-actions { display: flex; align-items: center; gap: 12px; justify-content: flex-end; }
.btn-cancel { padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: 'DM Sans', sans-serif; color: var(--gray-600); background: var(--white); border: 1.5px solid var(--gray-200); cursor: pointer; text-decoration: none; transition: all 0.15s; }
.btn-cancel:hover { background: var(--gray-100); color: var(--black); }
.btn-submit { padding: 12px 32px; border-radius: 10px; font-size: 14px; font-weight: 700; font-family: 'DM Sans', sans-serif; color: var(--white); background: var(--accent); border: none; cursor: pointer; transition: all 0.15s; display: flex; align-items: center; gap: 8px; }
.btn-submit:hover { background: var(--accent-dark); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,0.3); }
.btn-submit:active { transform: translateY(0); }

/* ─── PRICE INPUT ─── */
.price-wrap { position: relative; }
.price-wrap .form-input { padding-right: 60px; }
.price-suffix { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 13px; font-weight: 600; color: var(--gray-400); }

/* ─── FOOTER ─── */
footer { background: var(--blue-dark); color: rgba(255,255,255,0.5); text-align: center; padding: 20px 40px; font-size: 13px; margin-top: 48px; }
footer strong { color: var(--white); }
</style>
</head>
<body>

<div class="topbar">
  Livraison gratuite dès 200 TND &nbsp;·&nbsp; <span>Retour 30 jours</span> &nbsp;·&nbsp; Garantie 12 mois
</div>

<nav>
  <div class="nav-top">
    <a href="/" class="logo-wrap">
      <img src="{{ asset('images/logo.png') }}" alt="ApexDevice" class="logo-img"
           onerror="this.style.display='none'; document.getElementById('logo-fb').style.display='block';">
      <div id="logo-fb" style="display:none;">
        <div class="logo-name"><span class="apex">Apex</span><span class="device">Device</span></div>
        <span class="logo-sub">Electronics E-Commerce</span>
      </div>
    </a>
    <div class="nav-right">
      <a href="/boutique" class="back-btn">
        <i class="bi bi-arrow-left"></i> Ma boutique
      </a>
      @auth
        <span style="font-size:13px; color:var(--gray-600);">{{ Auth::user()->name }}</span>
      @endauth
    </div>
  </div>
</nav>

<div class="page-wrap">

  <div class="page-header">
    <h1>Publier un produit</h1>
    <p>Remplissez les informations ci-dessous pour mettre votre appareil en vente sur ApexDevice.</p>
  </div>

  {{-- Erreurs --}}
  @if($errors->any())
    <div class="alert alert-error">
      <i class="bi bi-exclamation-circle"></i>
      <div>
        <strong>Erreurs détectées :</strong>
        <ul style="margin: 6px 0 0 16px; padding: 0;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <form method="POST" action="{{ route('vendeur.produits.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- ── INFORMATIONS GÉNÉRALES ── --}}
    <div class="form-card">
      <div class="card-title">
        <i class="bi bi-info-circle"></i>
        Informations générales
      </div>

      <div class="form-group">
        <label class="form-label" for="title">Titre du produit <span>*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"
          class="form-input {{ $errors->has('title') ? 'error' : '' }}"
          placeholder="Ex : iPhone 14 Pro 128Go — Noir Sidéral" required>
        @error('title') <div class="error-msg"><i class="bi bi-exclamation-triangle"></i> {{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description"
          class="form-input {{ $errors->has('description') ? 'error' : '' }}"
          placeholder="Décrivez l'état, les accessoires inclus, les caractéristiques importantes…">{{ old('description') }}</textarea>
        @error('description') <div class="error-msg"><i class="bi bi-exclamation-triangle"></i> {{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" for="category_id">Catégorie <span>*</span></label>
          <select id="category_id" name="category_id"
            class="form-input {{ $errors->has('category_id') ? 'error' : '' }}" required>
            <option value="">— Choisir une catégorie —</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('category_id') <div class="error-msg"><i class="bi bi-exclamation-triangle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" for="price">Prix <span>*</span></label>
          <div class="price-wrap">
            <input type="number" id="price" name="price" value="{{ old('price') }}"
              class="form-input {{ $errors->has('price') ? 'error' : '' }}"
              placeholder="0" min="0" step="0.01" required>
            <span class="price-suffix">TND</span>
          </div>
          @error('price') <div class="error-msg"><i class="bi bi-exclamation-triangle"></i> {{ $message }}</div> @enderror
        </div>
      </div>
    </div>

    {{-- ── IMAGE ── --}}
    <div class="form-card">
      <div class="card-title">
        <i class="bi bi-image"></i>
        Photo du produit
      </div>

      <div class="upload-zone" id="uploadZone">
        <input type="file" name="image" id="imageInput" accept="image/jpg,image/jpeg,image/png,image/webp"
               onchange="previewImage(this)">
        <div id="uploadContent">
          <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
          <div class="upload-text"><strong>Cliquez pour choisir</strong> ou glissez une image ici</div>
          <div class="upload-hint">JPG, PNG, WEBP — max 2 Mo</div>
        </div>
        <div class="upload-preview" id="uploadPreview">
          <img id="previewImg" src="" alt="Aperçu">
          <div style="margin-top:8px; font-size:12px; color:var(--gray-600);" id="fileName"></div>
        </div>
      </div>
      @error('image') <div class="error-msg" style="margin-top:8px;"><i class="bi bi-exclamation-triangle"></i> {{ $message }}</div> @enderror
    </div>

    {{-- ── ACTIONS ── --}}
    <div class="form-actions">
      <a href="/boutique" class="btn-cancel">Annuler</a>
      <button type="submit" class="btn-submit">
        <i class="bi bi-check-circle"></i>
        Publier le produit
      </button>
    </div>

  </form>
</div>

<footer>
  <strong>ApexDevice</strong> &copy; {{ date('Y') }} &nbsp;·&nbsp; Electronics E-Commerce
</footer>

<script>
function previewImage(input) {
  const preview = document.getElementById('uploadPreview');
  const content = document.getElementById('uploadContent');
  const img     = document.getElementById('previewImg');
  const name    = document.getElementById('fileName');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      img.src = e.target.result;
      name.textContent = input.files[0].name;
      preview.style.display = 'block';
      content.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</body>
</html>