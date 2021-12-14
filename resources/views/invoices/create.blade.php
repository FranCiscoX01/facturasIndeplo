@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('invoice') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <create-invoice-component></create-invoice-component>
    </div>
</div>
@endsection