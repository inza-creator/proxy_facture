@extends('layouts.app')

@section('content')

<h2>Bons de commande</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="/bon-commandes/create" class="btn btn-success mb-3">
    <i class="fas fa-plus me-1"></i>Nouveau bon de commande
</a>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Client</th>
                <th>Demande liée</th>
                <th>Date réception</th>
                <th>Statut</th>
                <th>Fichier</th>
                <th style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bons as $bon)
            <tr>
                <td>{{ $bon->client }}</td>
                <td>
                    @if($bon->demande)
                        {{ $bon->demande->client }} – {{ Str::limit($bon->demande->objet, 35) }}
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </td>
                <td>{{ $bon->date_reception ? \Carbon\Carbon::parse($bon->date_reception)->format('d/m/Y') : '–' }}</td>
                <td>
                    <span class="badge {{ $bon->statut === 'reçu' ? 'bg-success' : ($bon->statut === 'en attente' ? 'bg-warning' : 'bg-secondary') }}">
                        {{ $bon->statut ?? 'reçu' }}
                    </span>
                </td>
                <td>
                    <a href="/bon_commandes/{{ $bon->fichier }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-alt me-1"></i>Voir
                    </a>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('bon-commandes.edit', $bon) }}" class="btn btn-sm btn-outline-primary" title="Modifier le statut">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('bon-commandes.destroy', $bon) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce bon de commande ?');">
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
                <td colspan="6" class="text-center text-muted py-4">Aucun bon de commande.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
