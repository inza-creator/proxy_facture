@extends('layouts.app')

@section('content')

<h2>Demandes Clients</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="/demandes/create" class="btn btn-success mb-3">
    <i class="fas fa-plus me-1"></i>Nouvelle demande
</a>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Objet</th>
                <th>Date</th>
                <th>Statut</th>
                <th style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($demandes as $demande)
            <tr>
                <td>{{ $demande->client }}</td>
                <td>{{ $demande->email ?? '–' }}</td>
                <td>{{ $demande->contact ?? '–' }}</td>
                <td>{{ Str::limit($demande->objet, 40) }}</td>
                <td>{{ $demande->date_demande ? \Carbon\Carbon::parse($demande->date_demande)->format('d/m/Y') : '–' }}</td>
                <td>
                    <span class="badge {{ $demande->statut === 'acceptée' ? 'bg-success' : ($demande->statut === "en cours d'analyse" ? 'bg-info' : 'bg-secondary') }}">
                        {{ $demande->statut }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('demandes.edit', $demande) }}" class="btn btn-sm btn-outline-primary" title="Modifier le statut">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('demandes.destroy', $demande) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette demande ?');">
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
                <td colspan="7" class="text-center text-muted py-4">Aucune demande.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
