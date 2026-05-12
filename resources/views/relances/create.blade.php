@extends('layouts.app')

@section('content')

<h3>Nouvelle relance de paiement</h3>

<p class="text-muted">La relance crée un rappel pour vous : vous recevrez une notification avec le motif et le commentaire saisis.</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="/relances/store">
    @csrf

    <div class="mb-3">
        <label for="facture_id" class="form-label">Facture</label>
        <select name="facture_id" id="facture_id" class="form-select" required>
            <option value="">-- Choisir une facture --</option>
            @foreach($factures as $facture)
                <option value="{{ $facture->id }}" {{ old('facture_id') == $facture->id ? 'selected' : '' }}>
                    {{ $facture->numero_facture }} – {{ $facture->client }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="date_relance" class="form-label">Date de la relance</label>
        <input type="date" name="date_relance" id="date_relance" class="form-control" value="{{ old('date_relance', date('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label for="motif_relance" class="form-label">Motif de relance</label>
        <input type="text" name="motif_relance" id="motif_relance" class="form-control" value="{{ old('motif_relance') }}" placeholder="Ex. Rappel échéance, Relance client...">
    </div>

    <div class="mb-3">
        <label for="commentaire" class="form-label">Commentaire</label>
        <textarea name="commentaire" id="commentaire" class="form-control" rows="3" placeholder="Détail du rappel">{{ old('commentaire') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="/relances" class="btn btn-outline-secondary">Annuler</a>
</form>

@endsection
