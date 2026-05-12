@extends('layouts.app')

@section('content')

<h2>Modifier le statut</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <p class="text-muted mb-3">Facture <strong>{{ $facture->numero_facture }}</strong> – {{ $facture->client }}</p>
        <p class="small text-muted mb-3">Type : <strong>{{ $facture->type_facture === 'proforma' ? 'Proforma' : 'Définitive' }}</strong></p>

        @php
            $isProforma = strtolower($facture->type_facture ?? '') === 'proforma';
            $st = old('statut', $facture->statut);
            if ($isProforma) {
                $stNorm = strtolower($st ?? '');
                if (! in_array($stNorm, ['envoyé', 'non envoyé'], true)) {
                    $st = 'non envoyé';
                }
            }
        @endphp

        <form method="POST" action="{{ route('factures.update', $facture) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    @if($isProforma)
                        <option value="non envoyé" {{ $st === 'non envoyé' ? 'selected' : '' }}>Non envoyé</option>
                        <option value="envoyé" {{ $st === 'envoyé' ? 'selected' : '' }}>Envoyé</option>
                    @else
                        <option value="impayée" {{ old('statut', $facture->statut) == 'impayée' ? 'selected' : '' }}>Impayée</option>
                        <option value="payée" {{ old('statut', $facture->statut) == 'payée' ? 'selected' : '' }}>Payée</option>
                    @endif
                </select>
                @error('statut')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="/factures" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
