@extends('layouts.app')

@section('content')
<div class="aide-page" style="max-width: 720px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1" style="color: #1e5c3d;">Aide</h1>
        <p class="text-muted mb-0">Guide rapide pour utiliser PROXY.FACTURE.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <h2 class="h6 fw-bold mb-3"><i class="fas fa-circle-question text-success me-2"></i>Premiers pas</h2>
            <p class="text-secondary mb-2">Le <strong>tableau de bord</strong> résume vos factures, demandes et relances. Utilisez le menu à gauche pour accéder à chaque module.</p>
            <ul class="text-secondary mb-0 ps-3">
                <li class="mb-2"><strong>Demandes client</strong> : enregistrez et suivez les demandes.</li>
                <li class="mb-2"><strong>Factures</strong> : créez des factures proforma ou définitives et suivez les paiements.</li>
                <li><strong>Paramètres</strong> : configurez les services et domaines utilisés dans l’application.</li>
            </ul>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <h2 class="h6 fw-bold mb-3"><i class="fas fa-headset text-success me-2"></i>Besoin d’assistance ?</h2>
            <p class="text-secondary mb-0">Pour toute question métier ou technique, contactez votre administrateur Proxyma Technologies ou l’équipe support désignée par votre organisation.</p>
        </div>
    </div>

    <p class="small text-muted mb-0">Cette section sera enrichie prochainement (FAQ, tutoriels, captures d’écran).</p>
</div>
@endsection
