@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-right">
            <a href="{{ route('order.create') }}" class="btn btn-primary">Crear Pedido</a>
        </div>
        <order-component></order-component>
    </div>
</div>
@endsection
