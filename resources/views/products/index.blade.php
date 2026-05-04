@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Catalogue</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;"
                             alt="{{ $product->title }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center text-muted"
                             style="height:200px;">
                            Aucune image
                        </div>
                    @endif

                    <div class="card-body">
                        @if($product->category)
                            <span class="badge bg-secondary mb-1">{{ $product->category->name }}</span>
                        @endif
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        <p class="fw-bold">{{ number_format($product->price, 3, ',', ' ') }} TND</p>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('products.show', $product->id) }}"
                           class="btn btn-primary w-100">
                            Voir le produit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center text-muted py-5 border rounded">
                    Aucun produit disponible pour le moment.
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection