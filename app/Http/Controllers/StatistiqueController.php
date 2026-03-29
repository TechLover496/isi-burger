<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index() {
        $commandesJour = Commande::whereDate('created_at', today())->count();
        $commandesValidees = Commande::whereDate('created_at', today())->where('statut', 'payee')->count();
        $recetteJour = Paiement::whereDate('created_at', today())->sum('montant');
        $totalProduits = Produit::where('archive', false)->count();

        $data = Commande::select(DB::raw('MONTH(created_at) as mois'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')->orderBy('mois')->get();

        $mois = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
        $commandesParMois = array_fill(0, 12, 0);
        foreach ($data as $d) { $commandesParMois[$d->mois - 1] = $d->total; }

        return view('statistiques.index', compact('commandesJour','commandesValidees','recetteJour','totalProduits','mois','commandesParMois'));
    }
}
