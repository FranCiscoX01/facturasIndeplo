@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-block">
        <div class="col-12 pb-2 text-left">
            <a href="{{ route('section') }}" class="btn btn-secondary">Regresar</a>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <fieldset>
                    <legend>Editar Artículo</legend>
                    <form action="{{ route('section.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="code">Código</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $seccion->code }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $seccion->name }}">
                        </div>
                        <div class="form-group">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" id="price" name="price" step="any" value="{{ $seccion->price }}">
                        </div>
                        <div class="form-group text-right">
                            <input type="hidden" name="id" value="{{ $seccion->id }}">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </fieldset>
            </div>
            @if(Session::has('response') && Session::get('response') == 200)
            <div class="col-md-8 my-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Cambio Exitoso!</h4>
                    <p>Se han guardado los cambios exitosamente.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
            @if(Session::has('response') && Session::get('response') == 400)
            <div class="col-md-8 my-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Algo salio mal.</h4>
                    <p>Se ha producido un problema, verifique todos sus datos e intentelo nuevamente.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection