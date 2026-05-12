<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    protected $fillable = [
        'bon_commande_id',
        'numero_facture',
        'client',
        'objet',
        'montant',
        'tva',
        'type_facture',
        'date_facture',
        'statut',
        'condition_paiement',
    ];

    public function lignes(): HasMany
    {
        return $this->hasMany(FactureLigne::class);
    }
}
