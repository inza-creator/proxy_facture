<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_entreprise',
        'logo',
        'adresse',
        'telephone',
        'email',
        'conditions_paiement'
    ];
}