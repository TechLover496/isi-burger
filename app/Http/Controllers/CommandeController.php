<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use App\Mail\CommandeConfirmation;
use App\Mail\FactureMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeController extends Controller
{
    public function index() {
        if (auth()->user()->role === 'gestionnaire') {
            $commandes = Commande::with('user', 'lignes.produit')->latest()->get();
        } else {
            $commandes = Commande::with('lignes.produit')->where('user_id', auth()->id())->latest()->get();
        }
        return view('commandes.index', compact('commandes'));
    }

    public function store(Request $request) {
        $request->validate(['produits' => 'required|array']);

        $hasProduct = false;
        foreach ($request->produits as $quantite) {
            if ($quantite > 0) { $hasProduct = true; break; }
        }

        if (!$hasProduct) {
            return back()->with('error', 'Veuillez sélectionner au moins un burger !');
        }

        $total = 0;
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'total'   => 0,
            'statut'  => 'en_attente'
        ]);

        foreach ($request->produits as $produit_id => $quantite) {
            if ($quantite > 0) {
                $produit = Produit::findOrFail($produit_id);
                LigneCommande::create([
                    'commande_id'   => $commande->id,
                    'produit_id'    => $produit_id,
                    'quantite'      => $quantite,
                    'prix_unitaire' => $produit->prix,
                ]);
                $total += $produit->prix * $quantite;
            }
        }

        $commande->update(['total' => $total]);

        // Email de confirmation au client
        try {
            Mail::to($commande->user->email)->send(new CommandeConfirmation($commande));
        } catch (\Exception $e) {}

        // Notification au gestionnaire
        try {
            Mail::to('fayendeyembengue9@gmail.com')->send(new CommandeConfirmation($commande));
        } catch (\Exception $e) {}

        return redirect()->route('commandes.index')->with('success', 'Commande passée avec succès !');
    }

    public function updateStatut(Request $request, Commande $commande) {
        $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,prete,payee,annulee'
        ]);

        $commande->update(['statut' => $request->statut]);

        // Envoi facture PDF si commande prête
        if ($request->statut === 'prete') {
            try {
                $pdf = Pdf::loadView('pdf.facture', compact('commande'));
                Mail::to($commande->user->email)->send(new FactureMail($commande, $pdf));
            } catch (\Exception $e) {}
        }

        return back()->with('success', 'Statut mis à jour !');
    }

    public function destroy(Commande $commande) {
        $commande->update(['statut' => 'annulee']);
        return back()->with('success', 'Commande annulée !');
    }
}
