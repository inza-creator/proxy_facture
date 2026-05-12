@extends('layouts.app')

@push('styles')
<style>
    .demande-edit-page .page-hero {
        background: linear-gradient(135deg, #2d3559 0%, #3d4a6b 100%);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        color: #fff;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 32px rgba(45, 53, 89, 0.2);
    }
    .demande-edit-page .page-hero h1 { font-size: 1.25rem; font-weight: 700; margin: 0; }
    .demande-edit-page .form-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .demande-edit-page .form-label { font-weight: 600; color: #2c3e50; }
    .demande-edit-page .form-select { border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="demande-edit-page" style="max-width: 640px;">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div class="page-hero flex-grow-1" style="min-width: 200px;">
            <h1><i class="fas fa-tasks me-2 opacity-75"></i>Statut de la demande</h1>
            <p class="mb-0 mt-2 small opacity-90">{{ $demande->client }} — {{ Str::limit($demande->objet, 60) }}</p>
        </div>
        <a href="{{ url('/demandes') }}" class="btn btn-light border shadow-sm align-self-center">
            <i class="fas fa-arrow-left me-2"></i>Liste
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('demandes.update', $demande) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                    <select name="statut" id="statut" class="form-select form-select-lg" style="border-radius: 10px;" required>
                        <option value="en attente" {{ old('statut', $demande->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en cours d'analyse" {{ old('statut', $demande->statut) == "en cours d'analyse" ? 'selected' : '' }}>En cours d'analyse</option>
                        <option value="acceptée" {{ old('statut', $demande->statut) == 'acceptée' ? 'selected' : '' }}>Acceptée</option>
                    </select>
                    @error('statut')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #2d6a4f;">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                    <a href="{{ url('/demandes') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
