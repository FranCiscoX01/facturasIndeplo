@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-right">
            <a href="{{ route('invoice.create') }}" class="btn btn-primary">Elaborar Factura</a>
        </div>
        <invoice-component></invoice-component>
    </div>
</div>
@endsection