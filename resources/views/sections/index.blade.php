@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-right">
            <a href="{{ route('section.create') }}" class="btn btn-primary">Agregar Articulo</a>
        </div>
        <section-component :secciones="{{ json_encode($secciones) }}"></section-component>
    </div>
</div>
@endsection