@extends('layouts.app')

@section('content')

<h2>Factures</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="/factures/create" class="btn btn-success mb-3">
    <i class="fas fa-plus me-1"></i>Nouvelle facture
</a>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Numéro</th>
                <th>Client</th>
                <th>Objet</th>
                <th>Montant</th>
                <th>Type</th>
                <th>Statut</th>
                <th>PDF</th>
                <th style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($factures as $facture)
            <tr>
                <td>{{ $facture->numero_facture }}</td>
                <td>{{ $facture->client }}</td>
                <td>{{ Str::limit($facture->objet, 40) }}</td>
                <td>{{ number_format($facture->montant, 0, ',', ' ') }} F CFA</td>
                <td>{{ $facture->type_facture }}</td>
                <td>
                    @if(strtolower($facture->type_facture ?? '') === 'proforma')
                        @if(strtolower($facture->statut ?? '') === 'envoyé')
                            <span class="badge bg-success">Envoyé</span>
                        @else
                            <span class="badge bg-secondary">Non envoyé</span>
                        @endif
                    @else
                        @if(strtolower($facture->statut ?? '') === 'payée')
                            <span class="badge bg-success">Payée</span>
                        @else
                            <span class="badge bg-danger">Impayée</span>
                        @endif
                    @endif
                </td>
                <td>
                    <a href="/factures/pdf/{{ $facture->id }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Télécharger PDF">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('factures.edit', $facture) }}" class="btn btn-sm btn-outline-primary" title="{{ strtolower($facture->type_facture ?? '') === 'proforma' ? 'Modifier le statut (Envoyé / Non envoyé)' : 'Modifier le statut (Payée / Impayée)' }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('factures.destroy', $facture) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette facture ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">Aucune facture.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
