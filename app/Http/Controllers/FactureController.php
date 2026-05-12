<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\Demande;
use App\Models\Facture;
use App\Models\Parametre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::query()->orderByDesc('created_at')->get();

        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $bons = BonCommande::with('demande')->orderBy('created_at', 'desc')->get();
        $clients = Demande::query()->select('client')->distinct()->orderBy('client')->pluck('client');

        $demandesParClient = [];
        foreach (Demande::query()->orderBy('client')->orderBy('id')->get(['client', 'objet', 'description']) as $d) {
            $client = $d->client;
            if (! isset($demandesParClient[$client])) {
                $demandesParClient[$client] = [];
            }
            $objet = trim((string) ($d->objet ?? ''));
            $desc = trim((string) ($d->description ?? ''));
            $full = $objet;
            if ($desc !== '') {
                $full .= ($full !== '' ? "\n\n" : '').$desc;
            }
            if ($full === '') {
                $full = 'Prestation';
            }
            $demandesParClient[$client][] = [
                'label' => Str::limit($objet !== '' ? $objet : ($desc !== '' ? $desc : 'Prestation'), 90),
                'description' => $full,
            ];
        }

        return view('factures.create', compact('bons', 'clients', 'demandesParClient'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bon_commande_id' => 'required|exists:bon_commandes,id',
            'client' => 'required|string',
            'lignes' => 'required|array|min:1',
            'lignes.*.description' => 'required|string|max:65000',
            'lignes.*.quantite' => 'required|numeric|min:0.01',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
            'tva' => 'nullable|numeric|min:0|max:100',
            'type_facture' => 'required|in:proforma,definitive',
            'date_facture' => 'required|date',
        ]);

        $lignesPrepared = [];
        $totalHt = 0.0;
        foreach ($validated['lignes'] as $ligne) {
            $q = (float) $ligne['quantite'];
            $pu = (float) $ligne['prix_unitaire'];
            $montantLigne = round($q * $pu, 2);
            $totalHt += $montantLigne;
            $lignesPrepared[] = [
                'description' => $ligne['description'],
                'quantite' => $q,
                'prix_unitaire' => $pu,
                'montant_ht' => $montantLigne,
            ];
        }

        $totalHt = round($totalHt, 2);

        $resumeParts = array_map(function (array $l) {
            return Str::limit(preg_replace('/\s+/', ' ', $l['description']), 80);
        }, $lignesPrepared);
        $objetResume = Str::limit(implode(' ; ', $resumeParts), 191);

        DB::transaction(function () use ($validated, $request, $lignesPrepared, $totalHt, $objetResume) {
            $numero = 'FAC-'.date('Ymd').'-'.rand(100, 999);

            $facture = Facture::create([
                'bon_commande_id' => $validated['bon_commande_id'],
                'numero_facture' => $numero,
                'client' => $validated['client'],
                'objet' => $objetResume,
                'montant' => $totalHt,
                'tva' => $request->filled('tva') ? $request->tva : null,
                'type_facture' => $validated['type_facture'],
                'date_facture' => $validated['date_facture'],
                'statut' => $validated['type_facture'] === 'proforma' ? 'non envoyé' : 'impayée',
                'condition_paiement' => $request->condition_paiement,
            ]);

            foreach ($lignesPrepared as $row) {
                $facture->lignes()->create($row);
            }
        });

        return redirect('/factures')->with('success', 'Facture créée');
    }

    public function pdf($id)
    {
        $facture = Facture::with('lignes')->findOrFail($id);
        $parametre = Parametre::first();
        $logoPath = null;
        if ($parametre && $parametre->logo && Storage::disk('public')->exists($parametre->logo)) {
            $logoPath = storage_path('app/public/'.$parametre->logo);
        }
        $pdf = Pdf::loadView('factures.pdf', compact('facture', 'parametre', 'logoPath'));

        return $pdf->download('facture_'.$facture->numero_facture.'.pdf');
    }

    public function edit(Facture $facture)
    {
        return view('factures.edit', compact('facture'));
    }

    public function update(Request $request, Facture $facture)
    {
        $allowed = $facture->type_facture === 'proforma'
            ? ['envoyé', 'non envoyé']
            : ['payée', 'impayée'];
        $request->validate([
            'statut' => ['required', Rule::in($allowed)],
        ]);
        $facture->update(['statut' => $request->statut]);

        return redirect('/factures')->with('success', 'Statut mis à jour.');
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();

        return redirect('/factures')->with('success', 'Facture supprimée.');
    }
}
