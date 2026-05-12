@extends('layouts.app')

@push('styles')
<style>
    .demande-form-page {
        width: 100%;
        max-width: 100%;
    }
    .demande-form-header {
        margin-bottom: 2rem;
    }
    @media (min-width: 992px) {
        .demande-form-header { margin-bottom: 2.5rem; }
    }
    .demande-back-btn {
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
    .demande-back-btn:hover {
        color: #2d6a4f;
        border-color: #b7d4c4;
        background: #f4fbf7;
    }
    .demande-form-page .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1f36;
        letter-spacing: -0.02em;
        line-height: 1.3;
    }
    .demande-form-page .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin-top: 0.5rem;
        line-height: 1.5;
    }
    .demande-form-page .form-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .demande-form-page .form-card .card-body {
        padding: 2rem 1.75rem;
    }
    @media (min-width: 768px) {
        .demande-form-page .form-card .card-body {
            padding: 2.5rem 2.25rem;
        }
    }
    .demande-form-page .section-label {
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
    .demande-form-page .form-label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .demande-form-page .form-control,
    .demande-form-page .form-select {
        border-radius: 10px;
        padding: 0.6rem 0.95rem;
        border-color: #dee2e6;
    }
    .demande-form-page .form-control:focus {
        border-color: #40916c;
        box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.15);
    }
    .demande-form-page .form-actions {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid #eef1f4;
        gap: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="demande-form-page">
    <header class="demande-form-header d-flex align-items-start gap-3 gap-md-4">
        <a href="{{ url('/demandes') }}" class="demande-back-btn" title="Retour à la liste" aria-label="Retour à la liste">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0 flex-grow-1">
            <h1 class="page-title mb-0">Nouvelle demande client</h1>
            <p class="page-subtitle mb-0">Saisissez les informations de contact et le détail de la demande.</p>
        </div>
    </header>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ url('/demandes/store') }}">
                @csrf

                <p class="section-label"><i class="fas fa-user-tag me-2 text-success"></i>Identité & contact</p>
                <div class="row g-4 mb-4 mb-lg-5">
                    <div class="col-12 col-lg-8">
                        <label for="client" class="form-label">Nom du client / Organisation <span class="text-danger">*</span></label>
                        <input type="text" name="client" id="client" class="form-control" value="{{ old('client') }}" required autocomplete="organization" placeholder="Ex. Société ABC ou M. Martin">
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="date_demande" class="form-label">Date de la demande</label>
                        <input type="date" name="date_demande" id="date_demande" class="form-control" value="{{ old('date_demande', date('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row g-4 mb-4 mb-lg-5">
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" autocomplete="email" placeholder="contact@exemple.com">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="contact" class="form-label">Téléphone / Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" autocomplete="tel" placeholder="+224 … ou autre moyen de contact">
                    </div>
                </div>

                <p class="section-label"><i class="fas fa-align-left me-2 text-success"></i>Détail de la demande</p>

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label for="objet" class="form-label">Objet <span class="text-danger">*</span></label>
                        <input type="text" name="objet" id="objet" class="form-control" value="{{ old('objet') }}" required placeholder="Résumé en une ligne">
                    </div>
                </div>

                <div class="row g-4 mb-2">
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6" placeholder="Contexte, besoins, contraintes éventuelles…">{{ old('description') }}</textarea>
                        <div class="form-text mt-2">Informations complémentaires pour le traitement de la demande.</div>
                    </div>
                </div>

                <div class="d-flex flex-wrap form-actions">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #2d6a4f;">
                        <i class="fas fa-check me-2"></i>Enregistrer la demande
                    </button>
                    <a href="{{ url('/demandes') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
