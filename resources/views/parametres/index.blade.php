@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Paramètres de l'application</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ ($tab ?? 'services') === 'services' ? 'active' : '' }}" href="{{ route('parametres.index', ['onglet' => 'services']) }}">Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($tab ?? '') === 'domaines' ? 'active' : '' }}" href="{{ route('parametres.index', ['onglet' => 'domaines']) }}">Domaines</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($tab ?? '') === 'proxyma' ? 'active' : '' }}" href="{{ route('parametres.index', ['onglet' => 'proxyma']) }}">Proxyma</a>
        </li>
    </ul>

    {{-- Onglet Services --}}
    @if(($tab ?? 'services') === 'services')
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Liste des services</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalService">
                        <i class="fas fa-plus me-1"></i> Nouveau
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Libellé</th>
                                <th>Description</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td>{{ $service->libelle }}</td>
                                    <td>{{ Str::limit($service->description, 60) ?: '–' }}</td>
                                    <td>
                                        <form action="{{ route('parametres.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce service ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted text-center">Aucun service. Cliquez sur « Nouveau » pour en ajouter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalService" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('parametres.services.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Nouveau service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Libellé <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}" required maxlength="255">
                                @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Onglet Domaines --}}
    @if(($tab ?? '') === 'domaines')
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Liste des domaines</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDomaine">
                        <i class="fas fa-plus me-1"></i> Nouveau
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Libellé</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($domaines as $domaine)
                                <tr>
                                    <td>{{ $domaine->libelle }}</td>
                                    <td>
                                        <form action="{{ route('parametres.domaines.destroy', $domaine) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce domaine ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-muted text-center">Aucun domaine. Cliquez sur « Nouveau » pour en ajouter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDomaine" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('parametres.domaines.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Nouveau domaine</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Libellé <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}" required maxlength="255">
                                @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Onglet Proxyma --}}
    @if(($tab ?? '') === 'proxyma')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Informations Proxyma</h5>
                <p class="text-muted small mb-4">Modifiez les informations affichées sur les documents (factures, etc.).</p>
                <form method="POST" action="{{ route('parametres.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom de l'entreprise</label>
                            <input type="text" name="nom_entreprise" class="form-control" value="{{ optional($parametre)->nom_entreprise ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ optional($parametre)->email ?? '' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" value="{{ optional($parametre)->adresse ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="{{ optional($parametre)->telephone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo entreprise</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @if($parametre && $parametre->logo)
                            <small class="text-muted">Logo actuel enregistré.</small>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Conditions de paiement</label>
                        <textarea name="conditions_paiement" class="form-control" rows="4">{{ optional($parametre)->conditions_paiement ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
