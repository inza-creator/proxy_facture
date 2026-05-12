<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use App\Models\Service;
use App\Models\Domaine;

class ParametreController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('onglet', 'services');
        if (!in_array($tab, ['services', 'domaines', 'proxyma'])) {
            $tab = 'services';
        }
        $parametre = Parametre::first();
        $services = Service::orderBy('libelle')->get();
        $domaines = Domaine::orderBy('libelle')->get();
        return view('parametres.index', compact('parametre', 'services', 'domaines', 'tab'));
    }

    public function update(Request $request)
    {
        $parametre = Parametre::first();
        if (!$parametre) {
            $parametre = new Parametre();
        }
        $parametre->nom_entreprise = $request->nom_entreprise;
        $parametre->adresse = $request->adresse;
        $parametre->telephone = $request->telephone;
        $parametre->email = $request->email;
        $parametre->conditions_paiement = $request->conditions_paiement;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('logos', 'public');
            $parametre->logo = $logo;
        }
        $parametre->save();
        return redirect()->route('parametres.index', ['onglet' => 'proxyma'])->with('success', 'Informations Proxyma mises à jour.');
    }

    public function storeService(Request $request)
    {
        $request->validate(['libelle' => 'required|string|max:255', 'description' => 'nullable|string']);
        Service::create($request->only('libelle', 'description'));
        return redirect()->route('parametres.index', ['onglet' => 'services'])->with('success', 'Service ajouté.');
    }

    public function destroyService(Service $service)
    {
        $service->delete();
        return redirect()->route('parametres.index', ['onglet' => 'services'])->with('success', 'Service supprimé.');
    }

    public function storeDomaine(Request $request)
    {
        $request->validate(['libelle' => 'required|string|max:255']);
        Domaine::create($request->only('libelle'));
        return redirect()->route('parametres.index', ['onglet' => 'domaines'])->with('success', 'Domaine ajouté.');
    }

    public function destroyDomaine(Domaine $domaine)
    {
        $domaine->delete();
        return redirect()->route('parametres.index', ['onglet' => 'domaines'])->with('success', 'Domaine supprimé.');
    }
}
