<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model {
    protected $fillable = ['user_id', 'statut', 'total', 'date_paiement'];

    public function user() { return $this->belongsTo(User::class); }
    public function lignes() { return $this->hasMany(LigneCommande::class); }
    public function paiement() { return $this->hasOne(Paiement::class); }
}
