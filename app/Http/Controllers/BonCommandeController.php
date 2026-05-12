<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\Demande;
use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    public function index()
    {
        $bons = BonCommande::with('demande')->orderBy('created_at', 'desc')->get();
        return view('bon_commandes.index', compact('bons'));
    }

    public function create()
    {
        $demandes = Demande::orderBy('created_at', 'desc')->get();
        return view('bon_commandes.create', compact('demandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'fichier' => 'required|file',
            'date_reception' => 'required|date',
        ]);

        $demande = Demande::findOrFail($request->demande_id);
        $file = $request->file('fichier');
        $filename = time() . '.' . $file->extension();
        $file->move(public_path('bon_commandes'), $filename);

        BonCommande::create([
            'demande_id' => $request->demande_id,
            'client' => $demande->client,
            'fichier' => $filename,
            'date_reception' => $request->date_reception,
            'statut' => 'reçu',
        ]);

        return redirect('/bon-commandes')->with('success', 'Bon de commande enregistré');
    }

    public function edit(BonCommande $bon_commande)
    {
        return view('bon_commandes.edit', compact('bon_commande'));
    }

    public function update(Request $request, BonCommande $bon_commande)
    {
        $request->validate([
            'statut' => 'required|in:reçu,en attente,annulé',
        ]);
        $bon_commande->update(['statut' => $request->statut]);
        return redirect('/bon-commandes')->with('success', 'Statut mis à jour.');
    }

    public function destroy(BonCommande $bon_commande)
    {
        $bon_commande->delete();
        return redirect('/bon-commandes')->with('success', 'Bon de commande supprimé.');
    }
}