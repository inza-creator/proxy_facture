<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: Arial, sans-serif; font-size: 11px; line-height: 1.4; color: #222; }
.header-wrap { width: 100%; margin-bottom: 30px; }
.header-table { width: 100%; border: none; border-collapse: collapse; min-height: 140px; }
.header-table td { border: none; vertical-align: top; padding: 0; }
.col-logo { width: 140px; padding-right: 20px; }
.col-logo img { max-width: 120px; max-height: 70px; display: block; }
.client-block { padding-top: 0; }
.client-block .line { margin: 0 0 12px 0; padding: 0; font-size: 12px; }
.client-block .line:first-child { margin-top: 0; font-size: 14px; font-weight: bold; color: #111; }
.client-block .line strong { font-weight: 600; }
.col-date { width: 38%; text-align: right; vertical-align: bottom; padding-left: 20px; }
.date-block { margin-top: auto; padding-top: 0; }
.date-block .line { margin: 0 0 10px 0; padding: 0; font-size: 12px; }
.date-block .line:last-child { margin-bottom: 0; }
.section-title { font-size: 13px; font-weight: bold; margin: 28px 0 12px 0; padding-bottom: 6px; border-bottom: 1px solid #333; color: #111; }
table.items { width: 100%; border-collapse: collapse; margin-top: 8px; }
table.items th, table.items td { border: 1px solid #333; padding: 10px 12px; text-align: left; font-size: 11px; }
table.items th { background: #f0f0f0; font-weight: bold; }
.totaux { margin-top: 24px; padding: 12px 0; text-align: right; }
.totaux .total-line { margin: 4px 0; font-size: 12px; }
.totaux .total { font-size: 15px; font-weight: bold; margin-top: 8px; }
table.footer-table { width: 100%; margin-top: 35px; border-collapse: collapse; }
table.footer-table td { border: 1px solid #333; padding: 14px 16px; vertical-align: top; width: 50%; font-size: 11px; }
table.footer-table td h3 { margin: 0 0 12px 0; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #333; padding-bottom: 8px; color: #111; }
table.footer-table td p { margin: 6px 0; }
table.footer-table td ul { margin: 8px 0 0 0; padding-left: 20px; }
table.footer-table td li { margin: 6px 0; }
</style>
</head>
<body>

<div class="header-wrap">
    <table class="header-table">
        <tr>
            <td class="col-logo">
                @if(!empty($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo" class="logo">
                @endif
                <div class="client-block" style="margin-top: 22px;">
                    <p class="line">{{ $facture->client }}</p>
                    @if($facture->objet)
                        <p class="line"><strong>Résumé :</strong> {{ $facture->objet }}</p>
                    @endif
                    <p class="line"><strong>Type :</strong> {{ $facture->type_facture }}</p>
                    @if($facture->tva)
                        <p class="line"><strong>TVA :</strong> {{ number_format($facture->tva, 1, ',', ' ') }} %</p>
                    @endif
                </div>
            </td>
            <td class="col-date">
                <div class="date-block">
                    <p class="line"><strong>Date :</strong> {{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</p>
                    <p class="line"><strong>Facture N° :</strong> {{ $facture->numero_facture }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<p class="section-title">Détail de la facture</p>
<table class="items">
    <tr>
        <th>Description</th>
        <th style="text-align:right; width: 12%;">Quantité</th>
        <th style="text-align:right; width: 16%;">Prix unitaire (F CFA)</th>
        <th style="text-align:right; width: 16%;">Montant HT (F CFA)</th>
    </tr>
    @forelse($facture->lignes as $ligne)
    <tr>
        <td>{!! nl2br(e($ligne->description)) !!}</td>
        <td style="text-align:right;">{{ number_format((float) $ligne->quantite, 2, ',', ' ') }}</td>
        <td style="text-align:right;">{{ number_format((float) $ligne->prix_unitaire, 0, ',', ' ') }}</td>
        <td style="text-align:right;">{{ number_format((float) $ligne->montant_ht, 0, ',', ' ') }}</td>
    </tr>
    @empty
    <tr>
        <td>{{ $facture->objet }}</td>
        <td style="text-align:right;">1,00</td>
        <td style="text-align:right;">{{ number_format((float) $facture->montant, 0, ',', ' ') }}</td>
        <td style="text-align:right;">{{ number_format((float) $facture->montant, 0, ',', ' ') }}</td>
    </tr>
    @endforelse
</table>

@php
    $montantHT = $facture->relationLoaded('lignes') && $facture->lignes->isNotEmpty()
        ? (float) $facture->lignes->sum('montant_ht')
        : (float) $facture->montant;
    $tvaPourcent = $facture->tva ? (float) $facture->tva : 0;
    $montantTVA = $tvaPourcent > 0 ? round($montantHT * $tvaPourcent / 100, 0) : 0;
    $totalTTC = $montantHT + $montantTVA;
@endphp

<div class="totaux">
    @if($tvaPourcent > 0)
        <p class="total-line">Total HT : {{ number_format($montantHT, 0, ',', ' ') }} F CFA</p>
        <p class="total-line">TVA ({{ number_format($tvaPourcent, 1, ',', ' ') }} %) : {{ number_format($montantTVA, 0, ',', ' ') }} F CFA</p>
    @endif
    <p class="total total-line">Total TTC : {{ number_format($totalTTC, 0, ',', ' ') }} F CFA</p>
</div>

<table class="footer-table">
    <tr>
        <td>
            <h3>Conditions de paiement</h3>
            @if($facture->condition_paiement)
                <ul>
                    <li>{{ $facture->condition_paiement }}</li>
                </ul>
            @else
                <p>A définir.</p>
            @endif
        </td>
        <td>
            <h3>{{ (isset($parametre) && $parametre) ? $parametre->nom_entreprise : 'PROXYMA TECHNOLOGIES' }}</h3>
            @if(isset($parametre) && $parametre)
                @if($parametre->adresse)<p>{{ $parametre->adresse }}</p>@endif
                @if($parametre->telephone)<p>Tél : {{ $parametre->telephone }}</p>@endif
                @if($parametre->email)<p>Email : {{ $parametre->email }}</p>@endif
            @else
                <p>—</p>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
