<?php
namespace App\Http\Controllers;
use App\Models\Demande;
use Illuminate\Http\Request;

class DemandeController extends Controller
{

    public function index()
    {
        $demandes = Demande::all();
        return view('demandes.index', compact('demandes'));
    }

    public function create()
    {
        return view('demandes.create');
    }

    public function store(Request $request)
    {

        Demande::create([
            'client' => $request->client,
            'email' => $request->email,
            'contact' => $request->contact,
            'objet' => $request->objet,
            'description' => $request->description,
            'date_demande' => $request->date_demande,
            'statut' => 'en attente'
        ]);

        return redirect('/demandes')->with('success','Demande enregistrée');
    }

    public function edit(Demande $demande)
    {
        return view('demandes.edit', compact('demande'));
    }

    public function update(Request $request, Demande $demande)
    {
        $request->validate([
            'statut' => ['required', 'in:en attente,en cours d\'analyse,acceptée'],
        ]);
        $demande->update(['statut' => $request->statut]);
        return redirect('/demandes')->with('success', 'Statut mis à jour.');
    }

    public function destroy(Demande $demande)
    {
        $demande->delete();
        return redirect('/demandes')->with('success', 'Demande supprimée.');
    }
}
