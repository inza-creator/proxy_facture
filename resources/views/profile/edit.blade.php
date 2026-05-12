@extends('layouts.app')

@push('styles')
<style>
    .profile-page-title { color: #1e5c3d; }
    .profile-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .profile-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eef1f4;
        font-weight: 600;
        padding: 1rem 1.25rem;
        border-radius: 14px 14px 0 0 !important;
    }
    .profile-form-label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; }
    .profile-form-control, .profile-form-control:focus {
        border-radius: 10px;
        border-color: #dee2e6;
        padding: 0.6rem 0.85rem;
    }
    .profile-readonly {
        background-color: #f8f9fa !important;
        color: #495057;
    }
</style>
@endpush

@section('content')
<div class="profile-edit" style="max-width: 640px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold profile-page-title mb-1">Mon profil</h1>
        <p class="text-muted mb-0">Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success rounded-3 border-0 py-2 mb-3" role="alert">Profil mis à jour.</div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="alert alert-success rounded-3 border-0 py-2 mb-3" role="alert">Mot de passe modifié.</div>
    @endif

    {{-- Informations personnelles --}}
    <div class="card profile-card mb-4">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="fas fa-user text-success"></i>
            <span>Informations personnelles</span>
        </div>
        <div class="card-body p-4">
            <p class="small text-muted mb-4">Vos informations de base <span class="text-danger">*</span> champs obligatoires</p>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label class="profile-form-label">Référence utilisateur</label>
                    <input type="text" class="form-control profile-form-control profile-readonly" value="USR-{{ str_pad((string) $user->id, 5, '0', STR_PAD_LEFT) }}" readonly tabindex="-1">
                    <div class="form-text">Identifiant interne (non modifiable).</div>
                </div>

                <div class="mb-3">
                    <label for="name" class="profile-form-label">Nom complet <span class="text-danger">*</span></label>
                    <input id="name" name="name" type="text" class="form-control profile-form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="profile-form-label">Adresse e-mail <span class="text-danger">*</span></label>
                    <input id="email" name="email" type="email" class="form-control profile-form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="profile-form-label">Compte créé le</label>
                    <input type="text" class="form-control profile-form-control profile-readonly"
                        value="{{ $user->created_at ? $user->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') : '—' }}" readonly tabindex="-1">
                </div>

                <button type="submit" class="btn text-white px-4 rounded-pill" style="background-color: #2d6a4f;">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>

    {{-- Mot de passe --}}
    <div class="card profile-card mb-4">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="fas fa-lock text-success"></i>
            <span>Sécurité — mot de passe</span>
        </div>
        <div class="card-body p-4">
            <p class="small text-muted mb-4">Utilisez un mot de passe long et unique pour protéger votre compte.</p>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="profile-form-label">Mot de passe actuel</label>
                    <input id="current_password" name="current_password" type="password" class="form-control profile-form-control @if ($errors->updatePassword->has('current_password')) is-invalid @endif" autocomplete="current-password">
                    @if ($errors->updatePassword->has('current_password'))
                        <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password" class="profile-form-label">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password" class="form-control profile-form-control @if ($errors->updatePassword->has('password')) is-invalid @endif" autocomplete="new-password">
                    @if ($errors->updatePassword->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('password') }}</div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="profile-form-label">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control profile-form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">
                    Mettre à jour le mot de passe
                </button>
            </form>
        </div>
    </div>

    {{-- Suppression du compte --}}
    <div class="card profile-card border-danger border-opacity-25 mb-4">
        <div class="card-header bg-white text-danger border-bottom border-danger border-opacity-25">
            <i class="fas fa-triangle-exclamation me-2"></i>Zone sensible
        </div>
        <div class="card-body p-4">
            <p class="text-secondary small mb-3">La suppression de votre compte est définitive. Les données associées pourront être perdues selon la politique de l’application.</p>
            <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">
                Supprimer mon compte
            </button>
        </div>
    </div>
</div>

{{-- Modal suppression --}}
<div class="modal fade" id="modalDeleteAccount" tabindex="-1" aria-labelledby="modalDeleteAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h5 fw-bold" id="modalDeleteAccountLabel">Supprimer le compte ?</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body pt-2">
                    <p class="text-secondary small">Cette action est irréversible. Saisissez votre mot de passe pour confirmer.</p>
                    <label for="delete_password" class="profile-form-label">Mot de passe</label>
                    <input id="delete_password" name="password" type="password" class="form-control profile-form-control @if ($errors->userDeletion->has('password')) is-invalid @endif" placeholder="••••••••" autocomplete="current-password">
                    @if ($errors->userDeletion->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->userDeletion->first('password') }}</div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger rounded-pill">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if ($errors->userDeletion->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    var m = document.getElementById('modalDeleteAccount');
    if (m && window.bootstrap) new bootstrap.Modal(m).show();
});
</script>
@endif
@endpush
