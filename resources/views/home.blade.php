@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-right">
            <a href="{{ route('costumer.create') }}" class="btn btn-primary">Agregar Cliente</a>
        </div>
        <costumers-component></costumers-component>
    </div>
</div>
@endsection
