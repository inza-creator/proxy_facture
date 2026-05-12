@extends('layouts.app')

@push('styles')
<style>
    .bc-form-page {
        width: 100%;
        max-width: 100%;
    }
    .bc-form-header {
        margin-bottom: 2rem;
    }
    @media (min-width: 992px) {
        .bc-form-header { margin-bottom: 2.5rem; }
    }
    .bc-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 10px;
        color: #495057;
        background: #fff;
        border: 1px solid #e3e6ea;
        text-decoration: none;
        transition: color 0.2s, border-color 0.2s, background 0.2s;
        flex-shrink: 0;
        margin-top: 0.2rem;
    }
    .bc-back-btn:hover {
        color: #2d6a4f;
        border-color: #b7d4c4;
        background: #f4fbf7;
    }
    .bc-form-page .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1f36;
        letter-spacing: -0.02em;
        line-height: 1.3;
    }
    .bc-form-page .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin-top: 0.5rem;
        line-height: 1.5;
    }
    .bc-form-page .form-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .bc-form-page .form-card .card-body {
        padding: 2rem 1.75rem;
    }
    @media (min-width: 768px) {
        .bc-form-page .form-card .card-body {
            padding: 2.5rem 2.25rem;
        }
    }
    .bc-form-page .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 1.25rem;
        margin-top: 0.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eef1f4;
    }
    .bc-form-page .form-label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .bc-form-page .form-control,
    .bc-form-page .form-select {
        border-radius: 10px;
        padding: 0.6rem 0.95rem;
        border-color: #dee2e6;
    }
    .bc-form-page .form-control:focus,
    .bc-form-page .form-select:focus {
        border-color: #40916c;
        box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.15);
    }
    .bc-form-page .form-actions {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid #eef1f4;
        gap: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="bc-form-page">
    <header class="bc-form-header d-flex align-items-start gap-3 gap-md-4">
        <a href="{{ url('/bon-commandes') }}" class="bc-back-btn" title="Retour à la liste" aria-label="Retour à la liste">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0 flex-grow-1">
            <h1 class="page-title mb-0">Nouveau bon de commande</h1>
            <p class="page-subtitle mb-0">Liez une demande client, joignez le document et indiquez la date de réception.</p>
        </div>
    </header>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ url('/bon-commandes/store') }}" enctype="multipart/form-data">
                @csrf

                <p class="section-label"><i class="fas fa-link me-2 text-success"></i>Demande client associée</p>
                <div class="row g-4 mb-4 mb-lg-5">
                    <div class="col-12">
                        <label for="demande_id" class="form-label">Demande client <span class="text-danger">*</span></label>
                        <select name="demande_id" id="demande_id" class="form-select" required>
                            <option value="">— Choisir une demande client —</option>
                            @foreach($demandes as $demande)
                                <option value="{{ $demande->id }}" {{ (string) old('demande_id') === (string) $demande->id ? 'selected' : '' }}>
                                    {{ $demande->client }} — {{ Str::limit($demande->objet, 60) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text mt-2">Le nom du client sera repris automatiquement à partir de la demande sélectionnée.</div>
                        @error('demande_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <p class="section-label"><i class="fas fa-file-invoice me-2 text-success"></i>Document & réception</p>
                <div class="row g-4 mb-2">
                    <div class="col-12 col-lg-8">
                        <label for="fichier" class="form-label">Fichier du bon de commande <span class="text-danger">*</span></label>
                        <input type="file" name="fichier" id="fichier" class="form-control" accept=".pdf,image/*" required>
                        <div class="form-text mt-2">PDF ou image (scan, photo).</div>
                        @error('fichier')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="date_reception" class="form-label">Date de réception <span class="text-danger">*</span></label>
                        <input type="date" name="date_reception" id="date_reception" class="form-control" value="{{ old('date_reception', date('Y-m-d')) }}" required>
                        @error('date_reception')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap form-actions">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #2d6a4f;">
                        <i class="fas fa-check me-2"></i>Enregistrer le bon de commande
                    </button>
                    <a href="{{ url('/bon-commandes') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
