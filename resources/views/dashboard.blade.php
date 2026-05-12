@extends('layouts.app')

@push('styles')
<style>
.dashboard-header {
    background: linear-gradient(135deg, #2d3559 0%, #3d4a6b 100%);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    color: #fff;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(45, 53, 89, 0.25);
}
.dashboard-header h1 { font-size: 1.6rem; font-weight: 700; margin: 0; }
.dashboard-header .date { opacity: 0.9; font-size: 0.95rem; margin-top: 0.35rem; }
.stat-card {
    border: none;
    border-radius: 10px;
    padding: 0.65rem 0.75rem;
    height: 100%;
    min-height: 88px;
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); color: inherit; }
.stat-card .stat-value { font-size: 1.25rem; font-weight: 700; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.stat-card .stat-label { font-size: 0.75rem; opacity: 0.9; margin-top: 0.15rem; }
.card-chart {
    border: none;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}
.card-chart .card-header {
    background: #fff;
    border-bottom: 1px solid #eee;
    font-weight: 600;
    padding: 1rem 1.25rem;
}
.activity-table { font-size: 0.9rem; }
.activity-table th { font-weight: 600; color: #495057; }
.montant-display { font-weight: 600; color: #1a1f36; }
</style>
@endpush

@section('content')

<div class="dashboard-header d-flex flex-wrap align-items-center justify-content-between">
    <div>
        <h1><i class="fas fa-tachometer-alt me-2"></i>Tableau de bord</h1>
        <p class="date mb-0">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
    </div>
    <div class="mt-2 mt-md-0">
        <a href="/factures/create" class="btn btn-light btn-sm me-2"><i class="fas fa-plus me-1"></i>Nouvelle facture</a>
        <a href="/demandes/create" class="btn btn-outline-light btn-sm"><i class="fas fa-plus me-1"></i>Nouvelle demande</a>
    </div>
</div>

{{-- Cartes KPI --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md">
        <a href="/factures" class="stat-card card bg-white shadow-sm">
            <div class="stat-value text-dark">{{ $totalFactures }}</div>
            <div class="stat-label text-secondary">Factures</div>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="/demandes" class="stat-card card bg-white shadow-sm">
            <div class="stat-value text-dark">{{ $totalDemandes }}</div>
            <div class="stat-label text-secondary">Demandes</div>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="/bon-commandes" class="stat-card card bg-white shadow-sm">
            <div class="stat-value text-dark">{{ $totalBonCommandes }}</div>
            <div class="stat-label text-secondary">Bons de commande</div>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="/contrats" class="stat-card card bg-white shadow-sm">
            <div class="stat-value text-dark">{{ $totalContrats }}</div>
            <div class="stat-label text-secondary">Contrats</div>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="/relances" class="stat-card card bg-white shadow-sm">
            <div class="stat-value text-dark">{{ $totalRelances }}</div>
            <div class="stat-label text-secondary">Relances</div>
        </a>
    </div>
</div>

{{-- Activité récente (avant les graphiques) --}}
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card card-chart">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Dernières factures</span>
                <a href="/factures" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @if($dernieresFactures->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">Aucune facture.</p>
                @else
                    <div class="table-responsive">
                        <table class="table activity-table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dernieresFactures as $f)
                                <tr>
                                    <td>{{ $f->numero_facture }}</td>
                                    <td>{{ Str::limit($f->client, 20) }}</td>
                                    <td class="montant-display">{{ number_format($f->montant, 0, ',', ' ') }} F CFA</td>
                                    <td>
                                        @if(strtolower($f->type_facture ?? '') === 'proforma')
                                            @if(strtolower($f->statut ?? '') === 'envoyé')
                                                <span class="badge bg-success">Envoyé</span>
                                            @else
                                                <span class="badge bg-secondary">Non envoyé</span>
                                            @endif
                                        @else
                                            @if(strtolower($f->statut ?? '') === 'payée')
                                                <span class="badge bg-success">Payée</span>
                                            @else
                                                <span class="badge bg-danger">Impayée</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-chart">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Demandes récentes</span>
                <a href="/demandes" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @if($dernieresDemandes->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">Aucune demande.</p>
                @else
                    <div class="table-responsive">
                        <table class="table activity-table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Client</th>
                                    <th>Objet</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dernieresDemandes as $d)
                                <tr>
                                    <td>{{ Str::limit($d->client, 18) }}</td>
                                    <td>{{ Str::limit($d->objet ?? '-', 22) }}</td>
                                    <td>{{ $d->date_demande ? \Carbon\Carbon::parse($d->date_demande)->format('d/m/Y') : '-' }}</td>
                                    <td><span class="badge bg-secondary">{{ $d->statut ?? '-' }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Graphiques --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-chart">
            <div class="card-header">Chiffre d'affaires sur 6 mois</div>
            <div class="card-body">
                <canvas id="chartCa" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-chart">
            <div class="card-header">Factures par statut</div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="chartStatut" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mois = @json($mois);
    const montants = @json($montantsParMois);
    const payees = {{ $facturesPayees }};
    const impayees = {{ $facturesImpayees }};

    new Chart(document.getElementById('chartCa'), {
        type: 'line',
        data: {
            labels: mois,
            datasets: [{
                label: 'CA (F CFA)',
                data: montants,
                borderColor: '#1a1f36',
                backgroundColor: 'rgba(26, 31, 54, 0.08)',
                fill: true,
                tension: 0.35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.06)' } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('chartStatut'), {
        type: 'doughnut',
        data: {
            labels: ['Payées', 'Impayées'],
            datasets: [{
                data: [payees, impayees],
                backgroundColor: ['#198754', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@endpush

@endsection
