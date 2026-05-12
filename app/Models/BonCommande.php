<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonCommande extends Model
{
    protected $fillable = [
        'demande_id',
        'client',
        'fichier',
        'date_reception',
        'statut',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
