<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model {
    protected $fillable = ['nom', 'description', 'prix', 'image', 'stock', 'archive'];

    public function ligneCommandes() {
        return $this->hasMany(LigneCommande::class);
    }
}
