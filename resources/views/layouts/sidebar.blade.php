@php
    /** @var \App\Models\User $user */
    $user = auth()->user();
@endphp
<div class="sidebar text-white font-sans">
    <div class="sidebar-inner">
        <div class="sidebar-brand-wrap flex-shrink-0">
            <div class="logo d-flex flex-column align-items-start w-100 sidebar-brand-block">
                <img src="{{ asset('image.png') }}" class="sidebar-brand-logo" alt="Proxyma Technologies">
                <p class="sidebar-brand-title mb-0 fw-bold">PROXY.FACTURE</p>
            </div>
        </div>

        <nav class="sidebar-nav w-100 flex-grow-1" id="sidebar-main-nav" aria-label="Navigation principale">
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fas fa-tachometer-alt sidebar-icon"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/demandes') }}" class="sidebar-link">
                <i class="fas fa-users sidebar-icon"></i>
                <span>Demandes Client</span>
            </a>
            <a href="{{ url('/bon-commandes') }}" class="sidebar-link">
                <i class="fas fa-file-contract sidebar-icon"></i>
                <span>Bons de Commande</span>
            </a>
            <a href="{{ url('/factures') }}" class="sidebar-link">
                <i class="fas fa-file-invoice-dollar sidebar-icon"></i>
                <span>Factures</span>
            </a>
            <a href="{{ url('/relances') }}" class="sidebar-link">
                <i class="fas fa-bell sidebar-icon"></i>
                <span>Relances Paiement</span>
            </a>
            <a href="{{ route('notifications.index') }}" class="sidebar-link">
                <i class="fas fa-inbox sidebar-icon"></i>
                <span>Mes notifications</span>
            </a>
            <a href="{{ route('contrats.index') }}" class="sidebar-link">
                <i class="fas fa-handshake sidebar-icon"></i>
                <span>Contrats</span>
            </a>
        </nav>

        <div class="sidebar-user-area flex-shrink-0">
            <button type="button"
                class="sidebar-user-btn w-100 d-flex align-items-center gap-2 text-start text-white border-0"
                id="sidebarUserToggle"
                aria-expanded="false"
                aria-controls="sidebarUserFlyout"
                aria-label="Menu utilisateur">
                <span class="sidebar-user-avatar d-flex align-items-center justify-content-center flex-shrink-0" aria-hidden="true">
                    <i class="fas fa-user text-secondary"></i>
                </span>
                <span class="sidebar-user-meta flex-grow-1 min-w-0">
                    <span class="d-block text-truncate fw-semibold small">{{ $user->name }}</span>
                    <span class="d-block text-truncate sidebar-user-email small">{{ $user->email }}</span>
                </span>
                <i class="fas fa-chevron-up sidebar-user-chevron flex-shrink-0 small opacity-75" aria-hidden="true"></i>
            </button>

            <div class="sidebar-user-flyout" id="sidebarUserFlyout" role="menu" hidden>
                <div class="sidebar-user-flyout-head px-3 py-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="sidebar-user-avatar-lg d-flex align-items-center justify-content-center flex-shrink-0" aria-hidden="true">
                            <i class="fas fa-user text-secondary"></i>
                        </span>
                        <div class="min-w-0">
                            <div class="fw-bold text-dark text-truncate small" title="{{ $user->name }}">{{ $user->name }}</div>
                            <div class="text-muted text-truncate" style="font-size: 0.72rem;" title="{{ $user->email }}">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action border-0 py-2 px-3 d-flex align-items-center gap-2" role="menuitem">
                        <span class="sidebar-flyout-ico sidebar-flyout-ico--prof"><i class="fas fa-user"></i></span>
                        <span class="text-dark small fw-medium">Mon profil</span>
                    </a>
                    <a href="{{ route('parametres.index') }}" class="list-group-item list-group-item-action border-0 py-2 px-3 d-flex align-items-center gap-2" role="menuitem">
                        <span class="sidebar-flyout-ico sidebar-flyout-ico--set"><i class="fas fa-cog"></i></span>
                        <span class="text-dark small fw-medium">Paramètres</span>
                    </a>
                    <a href="{{ route('aide') }}" class="list-group-item list-group-item-action border-0 py-2 px-3 d-flex align-items-center gap-2" role="menuitem">
                        <span class="sidebar-flyout-ico sidebar-flyout-ico--help"><i class="fas fa-circle-question"></i></span>
                        <span class="text-dark small fw-medium">Aide</span>
                    </a>
                </div>
                <div class="border-top bg-white">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="sidebar-logout-btn w-100 border-0 bg-transparent text-danger d-flex align-items-center gap-2 py-2 px-3 text-start small fw-medium" role="menuitem">
                            <span class="sidebar-flyout-ico sidebar-flyout-ico--out"><i class="fas fa-right-from-bracket"></i></span>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
