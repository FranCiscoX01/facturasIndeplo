@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('order') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <edit-order-component order-id="{{ $order_id }}"></edit-order-component>
    </div>
</div>
@endsection
