
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelanceController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/favicon.ico', function () {
    $path = public_path('favicon-32x32.png');
    if (! is_file($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=604800',
    ]);
});

/*
| Page d'accueil : pas de vue publique — invité → login, utilisateur connecté → tableau de bord.
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/demandes', [DemandeController::class,'index'])->middleware('auth');
Route::get('/demandes/create', [DemandeController::class,'create'])->middleware('auth');
Route::post('/demandes/store', [DemandeController::class,'store'])->middleware('auth');
Route::get('/demandes/{demande}/edit', [DemandeController::class,'edit'])->middleware('auth')->name('demandes.edit');
Route::put('/demandes/{demande}', [DemandeController::class,'update'])->middleware('auth')->name('demandes.update');
Route::delete('/demandes/{demande}', [DemandeController::class,'destroy'])->middleware('auth')->name('demandes.destroy');

Route::get('/bon-commandes', [BonCommandeController::class,'index'])->middleware('auth');
Route::get('/bon-commandes/create', [BonCommandeController::class,'create'])->middleware('auth');
Route::post('/bon-commandes/store', [BonCommandeController::class,'store'])->middleware('auth');
Route::get('/bon-commandes/{bon_commande}/edit', [BonCommandeController::class,'edit'])->middleware('auth')->name('bon-commandes.edit');
Route::put('/bon-commandes/{bon_commande}', [BonCommandeController::class,'update'])->middleware('auth')->name('bon-commandes.update');
Route::delete('/bon-commandes/{bon_commande}', [BonCommandeController::class,'destroy'])->middleware('auth')->name('bon-commandes.destroy');

Route::get('/factures', [FactureController::class,'index'])->middleware('auth');
Route::get('/factures/create', [FactureController::class,'create'])->middleware('auth');
Route::post('/factures/store', [FactureController::class,'store'])->middleware('auth');
Route::get('/factures/pdf/{id}', [FactureController::class,'pdf'])->middleware('auth');
Route::get('/factures/{facture}/edit', [FactureController::class,'edit'])->middleware('auth')->name('factures.edit');
Route::put('/factures/{facture}', [FactureController::class,'update'])->middleware('auth')->name('factures.update');
Route::delete('/factures/{facture}', [FactureController::class,'destroy'])->middleware('auth')->name('factures.destroy');

Route::get('/contrats', [ContratController::class,'index'])->middleware('auth')->name('contrats.index');
Route::get('/contrats/create', [ContratController::class,'create'])->middleware('auth')->name('contrats.create');
Route::post('/contrats/store', [ContratController::class,'store'])->middleware('auth')->name('contrats.store');
Route::get('/parametres', [ParametreController::class, 'index'])->middleware('auth')->name('parametres.index');
Route::post('/parametres/update', [ParametreController::class, 'update'])->middleware('auth')->name('parametres.update');
Route::post('/parametres/services', [ParametreController::class, 'storeService'])->middleware('auth')->name('parametres.services.store');
Route::delete('/parametres/services/{service}', [ParametreController::class, 'destroyService'])->middleware('auth')->name('parametres.services.destroy');
Route::post('/parametres/domaines', [ParametreController::class, 'storeDomaine'])->middleware('auth')->name('parametres.domaines.store');
Route::delete('/parametres/domaines/{domaine}', [ParametreController::class, 'destroyDomaine'])->middleware('auth')->name('parametres.domaines.destroy');

Route::get('/relances',[RelanceController::class,'index'])->middleware('auth');

Route::get('/relances/create',[RelanceController::class,'create'])->middleware('auth');

Route::post('/relances/store', [RelanceController::class,'store'])->middleware('auth');
Route::get('/relances/{relance}/edit', [RelanceController::class,'edit'])->middleware('auth')->name('relances.edit');
Route::put('/relances/{relance}', [RelanceController::class,'update'])->middleware('auth')->name('relances.update');
Route::delete('/relances/{relance}', [RelanceController::class,'destroy'])->middleware('auth')->name('relances.destroy');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth')->name('notifications.index');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->middleware('auth')->name('notifications.read-all');
Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->middleware('auth')->name('notifications.read');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/aide', 'aide')->name('aide');
});

require __DIR__.'/auth.php';
