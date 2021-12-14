@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('invoice') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <edit-invoice-component invoice-id="{{ $invoice_id }}"></edit-invoice-component>
    </div>
</div>
@endsection