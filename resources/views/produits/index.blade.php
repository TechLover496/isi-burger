@extends('layouts.app')
@section('content')
    <style>
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #1a1a1a; }
        .page-sub { font-size: 14px; color: #aaa; margin-top: 4px; }
        .btn-add { background: #C1440E; color: #fff; border: none; padding: 11px 24px; border-radius: 24px; font-size: 14px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #F0EDE8; }
        th { background: #FAFAF8; padding: 14px 20px; text-align: left; font-size: 12px; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 20px; font-size: 14px; border-top: 1px solid #F0EDE8; vertical-align: middle; }
        tr:hover td { background: #FAFAF8; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-actif { background: #d1fae5; color: #065f46; }
        .badge-archive { background: #fee2e2; color: #991b1b; }
        .stock-ok { color: #065f46; font-weight: 600; }
        .stock-low { color: #C1440E; font-weight: 600; }
        .btn-sm { padding: 6px 14px; border-radius: 20px; font-size: 12px; cursor: pointer; border: none; font-weight: 600; }
    </style>

    <div class="page-header">
        <div>
            <div class="page-title">Gestion des Produits</div>
            <div class="page-sub">Gérez votre catalogue de burgers</div>
        </div>
        <a href="{{ route('produits.create') }}" class="btn-add">+ Ajouter un burger</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Image</th>
            <th>Produit</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($produits as $produit)
            <tr>
                <td>
                    @if($produit->image)
                        <img src="{{ asset('storage/'.$produit->image) }}" style="width:52px;height:52px;object-fit:cover;border-radius:10px;">
                    @else
                        <div style="width:52px;height:52px;background:#FFF0EB;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:24px;">🍔</div>
                    @endif
                </td>
                <td>
                    <strong style="font-size:15px;">{{ $produit->nom }}</strong>
                    <div style="color:#aaa;font-size:12px;margin-top:2px;">{{ Str::limit($produit->description, 50) }}</div>
                </td>
                <td><strong style="color:#C1440E;">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</strong></td>
                <td class="{{ $produit->stock > 5 ? 'stock-ok' : 'stock-low' }}">{{ $produit->stock }} unités</td>
                <td>
                <span class="badge {{ $produit->archive ? 'badge-archive' : 'badge-actif' }}">
                    {{ $produit->archive ? 'Archivé' : 'Actif' }}
                </span>
                </td>
                <td style="display:flex;gap:8px;">
                    <a href="{{ route('produits.edit', $produit) }}">
                        <button class="btn-sm" style="background:#dbeafe;color:#1e40af;">Modifier</button>
                    </a>
                    <form method="POST" action="{{ route('produits.destroy', $produit) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn-sm" style="background:#fee2e2;color:#C1440E;">Archiver</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
