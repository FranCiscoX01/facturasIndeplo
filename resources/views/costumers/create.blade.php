@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('home') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <create-costumers-component></create-costumers-component>
    </div>
</div>
@endsection
