<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #FAFAF8; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #F0EDE8; }
        .header { background: #C1440E; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; }
        .header p { color: #ffcbb8; margin: 8px 0 0; font-size: 14px; }
        .body { padding: 32px; }
        .body h2 { font-size: 18px; color: #1a1a1a; margin-bottom: 16px; }
        .body p { color: #888; font-size: 14px; line-height: 1.7; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #FAFAF8; padding: 10px 14px; text-align: left; font-size: 12px; color: #aaa; }
        td { padding: 10px 14px; border-top: 1px solid #F0EDE8; font-size: 14px; }
        .total { font-size: 18px; font-weight: 700; color: #C1440E; text-align: right; margin-top: 16px; }
        .footer { background: #FAFAF8; padding: 20px 32px; text-align: center; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>ISI BURGER</h1>
        <p>Commande confirmée !</p>
    </div>
    <div class="body">
        <h2>Bonjour {{ $commande->user->name }},</h2>
        <p>Votre commande <strong>#{{ $commande->id }}</strong> a bien été reçue et est en cours de traitement.</p>
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
    </div>
    <div class="footer">
        ISI BURGER — Dakar, Sénégal
    </div>
</div>
</body>
</html>
