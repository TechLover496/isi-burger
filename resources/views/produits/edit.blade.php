@extends('layouts.app')
@section('content')
    <style>
        .form-card { background: #fff; border-radius: 20px; padding: 40px; max-width: 600px; margin: 0 auto; border: 1px solid #F0EDE8; }
        .form-title { font-size: 24px; font-weight: 600; margin-bottom: 28px; }
        .form-group { margin-bottom: 20px; }
        label { font-size: 13px; font-weight: 500; color: #555; display: block; margin-bottom: 6px; }
        input, textarea { width: 100%; padding: 12px 16px; border: 1.5px solid #F0EDE8; border-radius: 10px; font-size: 14px; outline: none; }
        input:focus, textarea:focus { border-color: #C1440E; }
        .btn-submit { background: #C1440E; color: #fff; border: none; padding: 13px 32px; border-radius: 28px; font-size: 15px; cursor: pointer; font-weight: 500; width: 100%; margin-top: 8px; }
    </style>

    <div class="form-card">
        <div class="form-title">✏️ Modifier {{ $produit->nom }}</div>
        <form method="POST" action="{{ route('produits.update', $produit) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nom du burger</label>
                <input type="text" name="nom" value="{{ $produit->nom }}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3">{{ $produit->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Prix (FCFA)</label>
                <input type="number" name="prix" value="{{ $produit->prix }}">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="{{ $produit->stock }}">
            </div>
            <div class="form-group">
                <label>Image</label>
                @if($produit->image)
                    <img src="{{ asset('storage/'.$produit->image) }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:block;">
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        </form>
    </div>
@endsection
