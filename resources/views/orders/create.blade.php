@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('order') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <create-order-component :costumers="{{ json_encode($costumers) }}" :sections="{{ json_encode($sections) }}"></create-order-component>
    </div>
</div>
@endsection
