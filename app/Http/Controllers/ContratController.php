<?php

namespace App\Http\Controllers;
use App\Models\Contrat;
use Illuminate\Http\Request;

class ContratController extends Controller
{

public function index()
{

$contrats = Contrat::all();

return view('contrats.index', compact('contrats'));

}

public function create()
{

return view('contrats.create');

}

public function store(Request $request)
{

$file = $request->file('document');
        $filename = time() . '.' . $file->extension();
        // Dossier distinct de la route URL /contrats (évite conflit Apache : répertoire vs Laravel)
        $dir = public_path('fichiers_contrats');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file->move($dir, $filename);

Contrat::create([

'client' => $request->client,
'projet' => $request->projet,
'date_signature' => $request->date_signature,
'document' => $filename,
'avenant' => $request->avenant

]);

return redirect()->route('contrats.index')->with('success','Contrat enregistré');

}

}