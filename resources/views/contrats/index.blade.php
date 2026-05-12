@extends('layouts.app')

@section('content')

<h2>Contrats</h2>

<a href="{{ route('contrats.create') }}" class="btn btn-success mb-3">Nouveau contrat</a>

<table class="table table-bordered">

<tr>

<th>Client</th>
<th>Projet</th>
<th>Date</th>
<th>Document</th>

</tr>

@foreach($contrats as $contrat)

<tr>

<td>{{ $contrat->client }}</td>

<td>{{ $contrat->projet }}</td>

<td>{{ $contrat->date_signature }}</td>

<td>

@php
    $doc = $contrat->document;
    $urlDoc = file_exists(public_path('fichiers_contrats/'.$doc))
        ? asset('fichiers_contrats/'.$doc)
        : (file_exists(public_path('contrats/'.$doc)) ? asset('contrats/'.$doc) : null);
@endphp
@if($urlDoc)
    <a href="{{ $urlDoc }}" target="_blank">Voir document</a>
@else
    <span class="text-muted">—</span>
@endif

</td>

</tr>

@endforeach

</table>

@endsection