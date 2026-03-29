<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\StatistiqueController;

Route::get('/', [ProduitController::class, 'catalogue'])->name('catalogue');

Route::middleware(['auth'])->group(function () {
    // Commandes client
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');

    // Gestionnaire uniquement
    Route::middleware(['role:gestionnaire'])->group(function () {
        Route::resource('/produits', ProduitController::class);
        Route::put('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');
        Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
        Route::post('/paiements/{commande}', [PaiementController::class, 'store'])->name('paiements.store');
        Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    });
});

require __DIR__.'/auth.php';
