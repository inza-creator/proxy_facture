<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'client',
        'email',
        'contact',
        'objet',
        'description',
        'date_demande',
        'statut'
    ];
}
