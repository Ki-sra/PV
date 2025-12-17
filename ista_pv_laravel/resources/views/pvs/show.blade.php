@extends('layouts.app')

@section('title', $pv->title)

@section('content')
<h1>{{ $pv->title }}</h1>
<ul class="list-group mb-3">
  <li class="list-group-item"><strong>Année:</strong> {{ $pv->year }}</li>
  <li class="list-group-item"><strong>Niveau:</strong> {{ $pv->level }}</li>
  <li class="list-group-item"><strong>Département:</strong> {{ $pv->department }}</li>
  <li class="list-group-item"><strong>Groupe:</strong> {{ $pv->group }}</li>
</ul>
<p>{{ $pv->description }}</p>
<a href="{{ route('pvs.index') }}" class="btn btn-secondary">Retour</a>
@auth
<hr>
<h5>Téléverser un document PV</h5>
<form method="post" action="{{ route('pvs.documents.upload', $pv->id) }}" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label class="form-label">Fichier</label>
    <input type="file" name="document" class="form-control" required>
  </div>
  <button class="btn btn-primary">Téléverser</button>
</form>

<hr>
<h5>Téléverser copie étudiant</h5>
<form method="post" action="{{ route('pvs.copies.upload', $pv->id) }}" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label class="form-label">Identifiant étudiant</label>
    <input type="text" name="student_identifier" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <select name="copy_type" class="form-control">
      <option value="control">Contrôle</option>
      <option value="efm">EFM</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Fichier</label>
    <input type="file" name="copy" class="form-control" required>
  </div>
  <button class="btn btn-primary">Téléverser copie</button>
</form>
@endauth
@endsection
