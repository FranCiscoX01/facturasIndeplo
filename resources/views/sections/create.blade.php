@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('section') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <create-section-component></create-section-component>
    </div>
</div>
@endsection