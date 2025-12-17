@extends('layouts.app')

@section('title','Liste des PV')

@section('content')
<div class="row mb-3">
  <div class="col-md-8">
    <form method="get" class="row g-2">
      <div class="col-auto">
        <input class="form-control" name="year" placeholder="Année" value="{{ request('year') }}">
      </div>
      <div class="col-auto">
        <input class="form-control" name="department" placeholder="Département" value="{{ request('department') }}">
      </div>
      <div class="col-auto">
        <button class="btn btn-secondary">Filtrer</button>
      </div>
    </form>
  </div>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Titre</th>
      <th>Année</th>
      <th>Niveau</th>
      <th>Département</th>
      <th>Archive</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pvs as $pv)
      <tr>
        <td><a href="{{ route('pvs.show', $pv->id) }}">{{ $pv->title }}</a></td>
        <td>{{ $pv->year }}</td>
        <td>{{ $pv->level }}</td>
        <td>{{ $pv->department }}</td>
        <td>{{ $pv->archived ? 'Oui' : 'Non' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ $pvs->withQueryString()->links() }}
@endsection
