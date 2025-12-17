@extends('layouts.app')

@section('title','Créer PV')

@section('content')
<h2>Créer un PV</h2>
<form method="post" action="{{ route('pvs.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label class="form-label">Année</label>
    <input type="number" name="year" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Niveau</label>
    <input type="text" name="level" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Département</label>
    <input type="text" name="department" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Groupe</label>
    <input type="text" name="group" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Titre</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Fichier (PDF, JPG, PNG)</label>
    <input type="file" name="file" class="form-control">
  </div>
  <button class="btn btn-primary">Créer</button>
</form>
@endsection
