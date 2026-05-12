<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relance;
use App\Models\Facture;
use App\Notifications\RelanceReminderNotification;

class RelanceController extends Controller
{
    public function index()
    {
        $relances = Relance::with('facture')->orderBy('date_relance', 'desc')->get();
        return view('relances.index', compact('relances'));
    }

    public function create()
    {
        $factures = Facture::orderBy('created_at', 'desc')->get();
        return view('relances.create', compact('factures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facture_id' => 'required|exists:factures,id',
            'date_relance' => 'required|date',
            'motif_relance' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);

        $relance = Relance::create([
            'facture_id' => $request->facture_id,
            'date_relance' => $request->date_relance,
            'motif_relance' => $request->motif_relance,
            'commentaire' => $request->commentaire,
            'statut' => 'Non lu',
        ]);

        $request->user()->notify(new RelanceReminderNotification($relance));

        return redirect('/relances')->with('success', 'Relance enregistrée. Vous recevrez un rappel (notification).');
    }

    public function edit(Relance $relance)
    {
        return view('relances.edit', compact('relance'));
    }

    public function update(Request $request, Relance $relance)
    {
        $request->validate(['statut' => 'required|in:Lu,Non lu']);
        $relance->update(['statut' => $request->statut]);
        return redirect('/relances')->with('success', 'Statut mis à jour.');
    }

    public function destroy(Relance $relance)
    {
        $relance->delete();
        return redirect('/relances')->with('success', 'Relance supprimée.');
    }
}