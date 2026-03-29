<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function store(Request $request, Commande $commande) {
        if ($commande->paiement) {
            return back()->with('error', 'Cette commande est déjà payée !');
        }

        Paiement::create([
            'commande_id' => $commande->id,
            'montant' => $commande->total,
            'date_paiement' => now(),
            'mode' => 'especes',
        ]);

        $commande->update(['statut' => 'payee', 'date_paiement' => now()]);
        return back()->with('success', 'Paiement enregistré !');
    }
}
