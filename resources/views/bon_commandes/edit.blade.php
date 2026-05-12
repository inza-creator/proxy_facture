@extends('layouts.app')

@push('styles')
<style>
    .bc-edit-page { width: 100%; max-width: 100%; }
    .bc-edit-header { margin-bottom: 2rem; }
    @media (min-width: 992px) { .bc-edit-header { margin-bottom: 2.5rem; } }
    .bc-back-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 2.5rem; height: 2.5rem; border-radius: 10px;
        color: #495057; background: #fff; border: 1px solid #e3e6ea;
        text-decoration: none; transition: color 0.2s, border-color 0.2s, background 0.2s;
        flex-shrink: 0; margin-top: 0.2rem;
    }
    .bc-back-btn:hover { color: #2d6a4f; border-color: #b7d4c4; background: #f4fbf7; }
    .bc-edit-page .page-title { font-size: 1.35rem; font-weight: 700; color: #1a1f36; letter-spacing: -0.02em; }
    .bc-edit-page .page-subtitle { font-size: 0.9rem; color: #6c757d; margin-top: 0.35rem; }
    .bc-edit-page .form-card { border: none; border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
    .bc-edit-page .form-card .card-body { padding: 2rem 1.75rem; }
    @media (min-width: 768px) { .bc-edit-page .form-card .card-body { padding: 2.5rem 2.25rem; } }
    .bc-edit-page .form-label { font-weight: 600; color: #2c3e50; }
    .bc-edit-page .form-select { border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="bc-edit-page" style="max-width: 640px;">
    <header class="bc-edit-header d-flex align-items-start gap-3 gap-md-4">
        <a href="{{ url('/bon-commandes') }}" class="bc-back-btn" title="Retour à la liste" aria-label="Retour à la liste">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0 flex-grow-1">
            <h1 class="page-title mb-0">Statut du bon de commande</h1>
            <p class="page-subtitle mb-0">{{ $bon_commande->client }} — {{ Str::limit($bon_commande->demande?->objet ?? '—', 55) }}</p>
        </div>
    </header>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ route('bon-commandes.update', $bon_commande) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                    <select name="statut" id="statut" class="form-select form-select-lg" style="border-radius: 10px;" required>
                        <option value="reçu" {{ old('statut', $bon_commande->statut ?? 'reçu') == 'reçu' ? 'selected' : '' }}>Reçu</option>
                        <option value="en attente" {{ old('statut', $bon_commande->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="annulé" {{ old('statut', $bon_commande->statut) == 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('statut')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #2d6a4f;">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                    <a href="{{ url('/bon-commandes') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
