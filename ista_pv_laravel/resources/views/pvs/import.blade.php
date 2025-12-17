@extends('layouts.app')

@section('title','Importer des PV')

@section('content')
<h2>Importer des PV (CSV / Excel)</h2>
<form method="post" action="{{ route('pvs.import') }}" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label class="form-label">Fichier</label>
    <input type="file" name="file" class="form-control" required>
  </div>
  <button class="btn btn-primary">Téléverser</button>
</form>
@endsection
