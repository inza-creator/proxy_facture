@extends('layouts.app')

@section('content')

<h2>Nouveau contrat</h2>

<form method="POST" action="{{ route('contrats.store') }}" enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>Client</label>

<input type="text" name="client" class="form-control">

</div>

<div class="mb-3">

<label>Projet</label>

<input type="text" name="projet" class="form-control">

</div>

<div class="mb-3">

<label>Date signature</label>

<input type="date" name="date_signature" class="form-control">

</div>

<div class="mb-3">

<label>Document contrat</label>

<input type="file" name="document" class="form-control">

</div>

<div class="mb-3">

<label>Avenant</label>

<input type="text" name="avenant" class="form-control">

</div>

<button class="btn btn-primary">Enregistrer</button>

</form>

@endsection