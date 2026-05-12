<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
 protected $fillable = [

'client',
'projet',
'date_signature',
'document',
'avenant'

];
}
