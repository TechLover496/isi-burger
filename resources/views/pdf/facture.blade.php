<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #1a1a1a; }
        .header { display: flex; justify-content: space-between; margin-bottom: 32px; }
        .logo { font-size: 24px; font-weight: 800; color: #C1440E; }
        .logo span { color: #1a1a1a; }
        .facture-title { font-size: 28px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px; }
        .info { background: #FAFAF8; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background: #C1440E; color: #fff; padding: 10px 14px; text-align: left; font-size: 13px; }
        td { padding: 10px 14px; border-bottom: 1px solid #F0EDE8; font-size: 13px; }
        .total { text-align: right; font-size: 18px; font-weight: 800; color: #C1440E; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">ISI <span>BURGER</span></div>
    <div>
        <div class="facture-title">FACTURE</div>
        <div style="font-size:13px;color:#888;">N° {{ $commande->id }} — {{ $commande->created_at->format('d/m/Y') }}</div>
    </div>
</div>

<div class="info">
    <strong>Client :</strong> {{ $commande->user->name }}<br>
    <strong>Email :</strong> {{ $commande->user->email }}<br>
    <strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}<br>
    <strong>Statut :</strong> {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
</div>

<table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($commande->lignes as $ligne)
        <tr>
            <td>{{ $ligne->produit->nom }}</td>
            <td>{{ $ligne->quantite }}</td>
            <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
            <td>{{ number_format($ligne->prix_unitaire * $ligne->quantite, 0, ',', ' ') }} FCFA</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total">Total : {{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>

<div class="footer">Merci pour votre commande — ISI BURGER, Dakar Sénégal</div>
</body>
</html>
