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
@endsection
