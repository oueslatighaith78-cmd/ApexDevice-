@extends('layouts.app')

@section('title', 'Modifier — ' . $product->title)

@section('content')
<div style="max-width:600px;margin:48px auto;padding:0 24px 80px">

    <a href="{{ route('boutique.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#666;text-decoration:none;margin-bottom:28px;">
        <i class="bi bi-arrow-left"></i> Retour à ma boutique
    </a>

    <h1 style="font-size:26px;font-weight:800;color:#1a1a1a;margin-bottom:6px;letter-spacing:-0.5px">Modifier le produit</h1>
    <p style="font-size:14px;color:#888;margin-bottom:32px">{{ $product->title }}</p>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
          style="background:#fff;border:1px solid #e8e8e8;border-radius:16px;overflow:hidden">
        @csrf @method('PUT')

        <div style="padding:28px;display:flex;flex-direction:column;gap:20px">

            <div style="display:flex;flex-direction:column;gap:6px">
                <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.6px">Titre *</label>
                <input type="text" name="title" value="{{ old('title', $product->title) }}" required
                       class="form-control @error('title') is-invalid @enderror">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;flex-direction:column;gap:6px">
                <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.6px">Description</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.6px">Prix (TND) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required
                           class="form-control @error('price') is-invalid @enderror">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.6px">Catégorie *</label>
                    <select name="category_id" required class="form-select @error('category_id') is-invalid @enderror">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:8px">
                <label style="font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.6px">Image</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Image actuelle"
                         style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;border:1px solid #e8e8e8;margin-bottom:8px">
                    <p style="font-size:12px;color:#aaa">Image actuelle — choisissez-en une nouvelle pour la remplacer.</p>
                @endif
                <div style="border:2px dashed #d0d0d0;border-radius:12px;padding:24px;text-align:center;cursor:pointer"
                     onclick="document.getElementById('edit-img').click()">
                    <i class="bi bi-image" style="font-size:28px;color:#ccc"></i>
                    <p style="font-size:13px;color:#888;margin:6px 0 0">Cliquez pour changer l'image</p>
                    <input type="file" id="edit-img" name="image" accept="image/*" style="display:none"
                           onchange="document.getElementById('new-preview').src=URL.createObjectURL(this.files[0]);document.getElementById('new-preview').style.display='block'">
                </div>
                <img id="new-preview" alt="Nouvel aperçu" style="display:none;width:100%;max-height:140px;object-fit:cover;border-radius:8px;border:1px solid #e0e0e0">
            </div>

        </div>

        <div style="padding:16px 28px 24px;border-top:1px solid #f0f0f0;display:flex;gap:10px;justify-content:flex-end">
            <a href="{{ route('boutique.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;font-size:13px;font-weight:600">
                Annuler
            </a>
            <button type="submit" style="padding:11px 24px;background:#1a1a1a;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer">
                Enregistrer les modifications
            </button>
        </div>

    </form>
</div>
@endsection