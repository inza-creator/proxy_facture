@extends('layouts.app')

@section('content')

<h3><i class="fas fa-edit me-2"></i>Modifier le statut de la relance</h3>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        @if($relance->facture)
            <p class="mb-0"><strong>Facture :</strong> {{ $relance->facture->numero_facture }} – {{ $relance->facture->client }}</p>
        @endif
        <p class="mb-0 small text-muted">Motif : {{ $relance->motif_relance ?? '—' }}</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('relances.update', $relance) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    <option value="Non lu" {{ ($relance->statut ?? '') === 'Non lu' ? 'selected' : '' }}>Non lu</option>
                    <option value="Lu" {{ ($relance->statut ?? '') === 'Lu' ? 'selected' : '' }}>Lu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="/relances" class="btn btn-outline-secondary">Annuler</a>
        </form>
    </div>
</div>

@endsection
