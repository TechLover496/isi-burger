@extends('layouts.app')
@section('content')
    <style>
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
        .page-title { font-size: 26px; font-weight: 800; color: #1a1a1a; }
        .page-sub { font-size: 14px; color: #aaa; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #F0EDE8; }
        th { background: #FAFAF8; padding: 14px 20px; text-align: left; font-size: 12px; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 20px; font-size: 14px; border-top: 1px solid #F0EDE8; vertical-align: middle; }
        tr:hover td { background: #FAFAF8; }
        .badge { padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-en-attente { background: #fef9c3; color: #854d0e; }
        .badge-en-preparation { background: #dbeafe; color: #1e40af; }
        .badge-prete { background: #d1fae5; color: #065f46; }
        .badge-payee { background: #dcfce7; color: #15803d; }
        .badge-annulee { background: #fee2e2; color: #991b1b; }
        select { padding: 7px 12px; border-radius: 10px; border: 1.5px solid #F0EDE8; font-size: 13px; outline: none; cursor: pointer; }
        select:focus { border-color: #C1440E; }
        .btn-sm { padding: 7px 16px; border-radius: 20px; font-size: 12px; cursor: pointer; border: none; font-weight: 600; }
        .empty { text-align: center; padding: 60px; color: #aaa; }
        .empty-icon { font-size: 48px; margin-bottom: 12px; }
        .empty-text { font-size: 16px; font-weight: 600; margin-bottom: 6px; color: #1a1a1a; }
    </style>

    <div class="page-header">
        <div>
            <div class="page-title">
                @if(auth()->user()->role === 'gestionnaire') Toutes les commandes @else Mes commandes @endif
            </div>
            <div class="page-sub">Suivi en temps réel des commandes</div>
        </div>
    </div>

    @if($commandes->isEmpty())
        <div style="background:#fff;border-radius:16px;border:1px solid #F0EDE8;">
            <div class="empty">
                <div class="empty-icon">📦</div>
                <div class="empty-text">Aucune commande pour le moment</div>
                <div style="font-size:14px;color:#aaa;">Les commandes apparaîtront ici</div>
            </div>
        </div>
    @else
        <table>
            <thead>
            <tr>
                <th>#</th>
                @if(auth()->user()->role === 'gestionnaire') <th>Client</th> @endif
                <th>Produits</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td><strong>#{{ $commande->id }}</strong></td>
                    @if(auth()->user()->role === 'gestionnaire')
                        <td>
                            <strong>{{ $commande->user->name }}</strong>
                            <div style="font-size:12px;color:#aaa;">{{ $commande->user->email }}</div>
                        </td>
                    @endif
                    <td>
                        @foreach($commande->lignes as $ligne)
                            <div style="font-size:13px;">{{ $ligne->produit->nom }} <span style="color:#aaa;">x{{ $ligne->quantite }}</span></div>
                        @endforeach
                    </td>
                    <td><strong style="color:#C1440E;">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></td>
                    <td>
                <span class="badge badge-{{ str_replace('_','-',$commande->statut) }}">
                    {{ ucfirst(str_replace('_',' ',$commande->statut)) }}
                </span>
                    </td>
                    <td style="color:#aaa;font-size:13px;">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                            @if(auth()->user()->role === 'gestionnaire')
                                <form method="POST" action="{{ route('commandes.statut', $commande) }}">
                                    @csrf @method('PUT')
                                    <select name="statut" onchange="this.form.submit()">
                                        @foreach(['en_attente','en_preparation','prete','payee','annulee'] as $s)
                                            <option value="{{ $s }}" {{ $commande->statut === $s ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_',' ',$s)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                                @if(!$commande->paiement && $commande->statut !== 'annulee')
                                    <form method="POST" action="{{ route('paiements.store', $commande) }}">
                                        @csrf
                                        <button class="btn-sm" style="background:#d1fae5;color:#065f46;">Payer</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('commandes.destroy', $commande) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-sm" style="background:#fee2e2;color:#C1440E;">Annuler</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
