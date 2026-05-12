@extends('layouts.app')

@push('styles')
<style>
    .facture-form-page {
        width: 100%;
        max-width: 100%;
    }
    .facture-form-header {
        margin-bottom: 2rem;
    }
    @media (min-width: 992px) {
        .facture-form-header { margin-bottom: 2.5rem; }
    }
    .facture-back-btn {
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
    .facture-back-btn:hover {
        color: #2d6a4f;
        border-color: #b7d4c4;
        background: #f4fbf7;
    }
    .facture-form-page .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1f36;
        letter-spacing: -0.02em;
        line-height: 1.3;
    }
    .facture-form-page .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin-top: 0.5rem;
        line-height: 1.5;
    }
    .facture-form-page .form-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .facture-form-page .form-card .card-body {
        padding: 2rem 1.75rem;
    }
    @media (min-width: 768px) {
        .facture-form-page .form-card .card-body {
            padding: 2.5rem 2.25rem;
        }
    }
    .facture-form-page .section-label {
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
    .facture-form-page .form-label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .facture-form-page .form-control,
    .facture-form-page .form-select {
        border-radius: 10px;
        padding: 0.6rem 0.95rem;
        border-color: #dee2e6;
    }
    .facture-form-page .form-control:focus,
    .facture-form-page .form-select:focus {
        border-color: #40916c;
        box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.15);
    }
    .facture-form-page .form-actions {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid #eef1f4;
        gap: 0.75rem;
    }
    .lignes-facture-table th { font-size: 0.75rem; white-space: nowrap; }
    .lignes-facture-table textarea.ligne-desc {
        min-height: 3.25rem;
        font-size: 0.875rem;
    }
    .lignes-facture-table .col-montant { min-width: 7rem; font-variant-numeric: tabular-nums; }
    .facture-tools-section {
        background: #f8faf9;
        border: 1px solid #e8eeeb;
        border-radius: 12px;
        padding: 1rem 1.15rem 1.1rem;
        margin-bottom: 1.25rem;
    }
    @media (min-width: 992px) {
        .facture-tools-section { padding: 1.15rem 1.35rem 1.2rem; }
    }
    .facture-tools-section .form-label { margin-bottom: 0.35rem; }
</style>
@endpush

@section('content')
<div class="facture-form-page">
    <header class="facture-form-header d-flex align-items-start gap-3 gap-md-4">
        <a href="{{ url('/factures') }}" class="facture-back-btn" title="Retour à la liste" aria-label="Retour à la liste">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0 flex-grow-1">
            <h1 class="page-title mb-0">Nouvelle facture</h1>
            <p class="page-subtitle mb-0">Associez un bon de commande, le client, les lignes (description, quantité, prix) et le type de facture.</p>
        </div>
    </header>

    <div class="card form-card">
        <div class="card-body">
            <form method="POST" action="{{ url('/factures/store') }}">
                @csrf

                <p class="section-label"><i class="fas fa-link me-2 text-success"></i>Bon de commande &amp; client</p>
                <div class="row g-3 g-lg-4 mb-4 mb-lg-5 align-items-start">
                    <div class="col-12 col-md-6">
                        <label for="bon_commande_id" class="form-label">Bon de commande <span class="text-danger">*</span></label>
                        <select name="bon_commande_id" id="bon_commande_id" class="form-select" required>
                            <option value="">— Choisir un bon de commande —</option>
                            @forelse($bons as $bon)
                                <option value="{{ $bon->id }}" {{ (string) old('bon_commande_id') === (string) $bon->id ? 'selected' : '' }}>
                                    {{ $bon->client }} — {{ $bon->demande ? Str::limit($bon->demande->objet, 55) : '—' }}
                                </option>
                            @empty
                                <option value="" disabled>Aucun bon de commande disponible</option>
                            @endforelse
                        </select>
                        @error('bon_commande_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                        <select name="client" id="client" class="form-select" required>
                            <option value="">— Choisir un client —</option>
                            @foreach($clients as $c)
                                <option value="{{ $c }}" {{ old('client') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        @error('client')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <p class="section-label"><i class="fas fa-list-ul me-2 text-success"></i>Lignes de facturation</p>

                <div class="facture-tools-section">
                    <div class="row g-3 g-lg-4 align-items-start">
                        <div class="col-12 col-lg-6">
                            <label for="import_demande" class="form-label">Importer depuis une demande client</label>
                            <select id="import_demande" class="form-select">
                                <option value="">— Choisir après avoir sélectionné le client —</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="tva" class="form-label">TVA (%)</label>
                            <input type="number" name="tva" id="tva" class="form-control" step="0.01" min="0" max="100" value="{{ old('tva') }}" placeholder="Ex. 18">
                            @error('tva')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @error('lignes')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror
                @if($errors->has('lignes.*'))
                    <div class="text-danger small mb-2">Vérifiez les champs de chaque ligne (description, quantité, prix unitaire).</div>
                @endif

                <div class="table-responsive border rounded-3 mb-3">
                    <table class="table table-sm align-middle mb-0 lignes-facture-table">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 220px;">Description <span class="text-danger">*</span></th>
                                <th style="width: 6rem;">Quantité</th>
                                <th style="width: 8rem;">Prix unitaire (F CFA)</th>
                                <th class="col-montant">Montant HT</th>
                                <th style="width: 3rem;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes-tbody"></tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill mb-4" id="btn-add-ligne">
                    <i class="fas fa-plus me-1"></i>Ajouter une ligne
                </button>

                <p class="section-label"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Type, date & paiement</p>
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <label for="condition_paiement" class="form-label">Condition de paiement</label>
                        <select name="condition_paiement" id="condition_paiement" class="form-select">
                            <option value="">— Choisir —</option>
                            <option value="40 % à la demande 60 % à la livraison" {{ old('condition_paiement') == '40 % à la demande 60 % à la livraison' ? 'selected' : '' }}>40 % à la demande, 60 % à la livraison</option>
                            <option value="50 % à la commande 50 % à la livraison" {{ old('condition_paiement') == '50 % à la commande 50 % à la livraison' ? 'selected' : '' }}>50 % à la commande, 50 % à la livraison</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="type_facture" class="form-label">Type de facture <span class="text-danger">*</span></label>
                        <select name="type_facture" id="type_facture" class="form-select" required>
                            <option value="proforma" {{ old('type_facture', 'proforma') == 'proforma' ? 'selected' : '' }}>Proforma</option>
                            <option value="definitive" {{ old('type_facture') == 'definitive' ? 'selected' : '' }}>Définitive</option>
                        </select>
                        @error('type_facture')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="date_facture" class="form-label">Date de la facture <span class="text-danger">*</span></label>
                        <input type="date" name="date_facture" id="date_facture" class="form-control" value="{{ old('date_facture', date('Y-m-d')) }}" required>
                        @error('date_facture')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap form-actions">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white" style="background-color: #2d6a4f;">
                        <i class="fas fa-check me-2"></i>Créer la facture
                    </button>
                    <a href="{{ url('/factures') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    $oldLignes = old('lignes');
    if (! is_array($oldLignes) || count($oldLignes) < 1) {
        $oldLignes = [['description' => '', 'quantite' => '1', 'prix_unitaire' => '']];
    }
@endphp

@push('scripts')
<script>
(function () {
    const demandesParClient = @json($demandesParClient);
    const initialLignes = @json($oldLignes);
    const tbody = document.getElementById('lignes-tbody');
    const clientSel = document.getElementById('client');
    const importSel = document.getElementById('import_demande');
    const btnAdd = document.getElementById('btn-add-ligne');

    function formatMontant(n) {
        const v = Math.round(Number(n) || 0);
        return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(v) + ' F CFA';
    }

    function reindexRows() {
        tbody.querySelectorAll('tr').forEach(function (tr, i) {
            tr.querySelector('.ligne-desc').name = 'lignes[' + i + '][description]';
            tr.querySelector('.ligne-qty').name = 'lignes[' + i + '][quantite]';
            tr.querySelector('.ligne-pu').name = 'lignes[' + i + '][prix_unitaire]';
        });
    }

    function recalcRow(tr) {
        const q = parseFloat(tr.querySelector('.ligne-qty').value);
        const pu = parseFloat(tr.querySelector('.ligne-pu').value);
        const qOk = !isNaN(q) ? q : 0;
        const puOk = !isNaN(pu) ? pu : 0;
        const mt = Math.round(qOk * puOk * 100) / 100;
        tr.querySelector('.ligne-montant').textContent = formatMontant(mt);
    }

    function refreshImportOptions() {
        const client = clientSel.value;
        importSel.innerHTML = '';
        const opt0 = document.createElement('option');
        opt0.value = '';
        opt0.textContent = '— Choisir un objet de la demande —';
        importSel.appendChild(opt0);
        if (!client || !demandesParClient[client]) return;
        demandesParClient[client].forEach(function (item, idx) {
            const opt = document.createElement('option');
            opt.value = String(idx);
            opt.textContent = item.label;
            opt.dataset.description = item.description;
            importSel.appendChild(opt);
        });
    }

    function addRow(data) {
        data = data || {};
        const tr = document.createElement('tr');
        tr.innerHTML =
            '<td><textarea class="form-control ligne-desc" rows="2" required></textarea></td>' +
            '<td><input type="number" class="form-control ligne-qty" step="0.01" min="0.01" value="1" required></td>' +
            '<td><input type="number" class="form-control ligne-pu" step="0.01" min="0" value="0" required></td>' +
            '<td class="col-montant ligne-montant text-end">' + formatMontant(0) + '</td>' +
            '<td><button type="button" class="btn btn-sm btn-outline-danger ligne-remove" title="Supprimer la ligne" aria-label="Supprimer la ligne"><i class="fas fa-times"></i></button></td>';
        const desc = tr.querySelector('.ligne-desc');
        const qty = tr.querySelector('.ligne-qty');
        const pu = tr.querySelector('.ligne-pu');
        if (data.description != null) desc.value = data.description;
        if (data.quantite != null) qty.value = data.quantite;
        if (data.prix_unitaire != null) pu.value = data.prix_unitaire;
        tbody.appendChild(tr);
        reindexRows();
        recalcRow(tr);
        qty.addEventListener('input', function () { recalcRow(tr); });
        pu.addEventListener('input', function () { recalcRow(tr); });
        tr.querySelector('.ligne-remove').addEventListener('click', function () {
            if (tbody.querySelectorAll('tr').length <= 1) return;
            tr.remove();
            reindexRows();
        });
    }

    initialLignes.forEach(function (row) {
        addRow({
            description: row.description != null ? row.description : '',
            quantite: row.quantite != null ? row.quantite : '1',
            prix_unitaire: row.prix_unitaire != null ? row.prix_unitaire : '0',
        });
    });
    if (tbody.querySelectorAll('tr').length === 0) addRow({});

    clientSel.addEventListener('change', function () {
        refreshImportOptions();
        importSel.value = '';
    });
    refreshImportOptions();

    importSel.addEventListener('change', function () {
        const opt = importSel.options[importSel.selectedIndex];
        if (!opt || !opt.value) return;
        const text = opt.dataset.description || '';
        addRow({ description: text, quantite: '1', prix_unitaire: '0' });
        importSel.value = '';
    });

    btnAdd.addEventListener('click', function () {
        addRow({ description: '', quantite: '1', prix_unitaire: '0' });
    });
})();
</script>
@endpush
@endsection
