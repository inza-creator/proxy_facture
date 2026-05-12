@extends('layouts.app')

@section('content')

<h3>Relances de paiement</h3>

<p class="text-muted">Les relances créent des rappels (notifications) pour vous avec le motif et le commentaire saisis.</p>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="/relances/create" class="btn btn-primary mb-3">
    <i class="fas fa-plus me-1"></i>Nouvelle relance
</a>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Facture</th>
                <th>Date relance</th>
                <th>Motif</th>
                <th>Commentaire</th>
                <th>Statut</th>
                <th style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($relances as $relance)
            <tr>
                <td>
                    @if($relance->facture)
                        {{ $relance->facture->numero_facture }} – {{ $relance->facture->client }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $relance->date_relance ? \Carbon\Carbon::parse($relance->date_relance)->format('d/m/Y') : '—' }}</td>
                <td>{{ $relance->motif_relance ?? '—' }}</td>
                <td>{{ Str::limit($relance->commentaire, 60) }}</td>
                <td>
                    @if(($relance->statut ?? '') === 'Lu')
                        <span class="badge bg-secondary">Lu</span>
                    @else
                        <span class="badge bg-primary">Non lu</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('relances.edit', $relance) }}" class="btn btn-sm btn-outline-primary" title="Modifier le statut (Lu / Non lu)">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('relances.destroy', $relance) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette relance ?');">
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
                <td colspan="6" class="text-center text-muted py-4">Aucune relance.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
