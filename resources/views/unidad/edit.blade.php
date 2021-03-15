@extends('adminlte::page')
@section('title', 'Unidades de Medida')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Unidad de Medida</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('unidad.update', $unidad->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="nombre"
                                                    id="nombre"
                                                    value="{{ old('nombre', $unidad->nombre) }}"
                                                    placeholder="Introduzca nombre de la unidad">
                                                    @foreach ($errors->get('nombre') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="abreviacion">Abreviación</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="abreviacion"
                                                    id="abreviacion"
                                                    value="{{ old('abreviacion', $unidad->abreviacion) }}"
                                                    placeholder="Introduzca abreviaciónn de la unidad">
                                                    @foreach ($errors->get('abreviacion') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('unidad.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
</div>
@stop