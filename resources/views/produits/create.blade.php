@extends('layouts.app')
@section('content')
    <style>
        .form-wrap { max-width: 620px; margin: 0 auto; }
        .form-card { background: #fff; border-radius: 20px; padding: 40px; border: 1px solid #F0EDE8; }
        .form-title { font-size: 24px; font-weight: 800; margin-bottom: 6px; }
        .form-sub { font-size: 14px; color: #aaa; margin-bottom: 32px; }
        .form-group { margin-bottom: 20px; }
        label { font-size: 13px; font-weight: 600; color: #555; display: block; margin-bottom: 8px; }
        input[type=text], input[type=number], textarea { width: 100%; padding: 12px 16px; border: 1.5px solid #F0EDE8; border-radius: 12px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; transition: border 0.2s; color: #1a1a1a; background: #fff; }
        input:focus, textarea:focus { border-color: #C1440E; }
        input[type=file] { width: 100%; padding: 12px 16px; border: 1.5px dashed #F0EDE8; border-radius: 12px; font-size: 14px; background: #FAFAF8; cursor: pointer; }
        .btn-submit { background: #C1440E; color: #fff; border: none; padding: 14px; border-radius: 28px; font-size: 15px; cursor: pointer; font-weight: 700; width: 100%; margin-top: 8px; transition: background 0.2s; }
        .btn-submit:hover { background: #a83509; }
        .error { color: #C1440E; font-size: 12px; margin-top: 6px; }
        .errors-box { background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .errors-box ul { margin: 0; padding-left: 16px; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: #888; font-size: 14px; text-decoration: none; margin-bottom: 20px; }
        .back-link:hover { color: #C1440E; }
    </style>

    <div class="form-wrap">
        <a href="{{ route('produits.index') }}" class="back-link">← Retour aux produits</a>
        <div class="form-card">
            <div class="form-title">Ajouter un burger</div>
            <div class="form-sub">Remplissez les informations du nouveau produit</div>

            @if ($errors->any())
                <div class="errors-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('produits.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Nom du burger</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="ex: Classic ISI">
                    @error('nom') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Ingrédients, sauce...">{{ old('description') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-group">
                        <label>Prix (FCFA)</label>
                        <input type="number" name="prix" value="{{ old('prix') }}" placeholder="3500" min="0">
                        @error('prix') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', 10) }}" min="0">
                        @error('stock') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Image du burger</label>
                    <input type="file" name="image" accept="image/*">
                    @error('image') <div class="error">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn-submit">Ajouter le burger</button>
            </form>
        </div>
    </div>
@endsection
