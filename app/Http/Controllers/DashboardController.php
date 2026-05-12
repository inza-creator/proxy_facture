<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Facture;
use App\Models\Contrat;
use App\Models\BonCommande;
use App\Models\Relance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDemandes = Demande::count();
        $totalFactures = Facture::count();
        $totalContrats = Contrat::count();
        $totalBonCommandes = BonCommande::count();
        $totalRelances = Relance::count();

        $montantTotalFactures = Facture::sum('montant');
        $facturesPayees = Facture::where('type_facture', 'definitive')->where('statut', 'payée')->count();
        $facturesImpayees = Facture::where('type_facture', 'definitive')->where('statut', 'impayée')->count();
        $montantEnAttente = Facture::where('type_facture', 'definitive')->where('statut', 'impayée')->sum('montant');

        $dernieresFactures = Facture::orderBy('date_facture', 'desc')
            ->limit(5)
            ->get();

        $dernieresDemandes = Demande::orderBy('date_demande', 'desc')->limit(5)->get();

        $mois = [];
        $montantsParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $mois[] = $date->locale('fr')->translatedFormat('M Y');
            $montantsParMois[] = Facture::whereYear('date_facture', $date->year)
                ->whereMonth('date_facture', $date->month)
                ->sum('montant');
        }

        return view('dashboard', compact(
            'totalDemandes',
            'totalFactures',
            'totalContrats',
            'totalBonCommandes',
            'totalRelances',
            'montantTotalFactures',
            'facturesPayees',
            'facturesImpayees',
            'montantEnAttente',
            'dernieresFactures',
            'dernieresDemandes',
            'mois',
            'montantsParMois'
        ));
    }
}