<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relance extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'date_relance',
        'motif_relance',
        'commentaire',
        'statut',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}