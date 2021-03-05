@extends('adminlte::page')
@section('title', 'Tipos de Crédito')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Crédito</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('tipo-credito.update', $tipoCredito->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <input class="form-control"
                                            type="text"
                                            name="descripcion"
                                            id="descripcion"
                                            value="{{ old('descripcion', $tipoCredito->descripcion) }}"
                                            placeholder="Introduzca descripción del tipo de crédito">
                                            @foreach ($errors->get('descripcion') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="tasa_diaria"> % Tasa Diaria</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="tasa_diaria"
                                                    id="tasa_diaria"
                                                    value="{{ old('tasa_diaria', $tipoCredito->tasa_diaria) }}"
                                                    placeholder="Introduzca porcentaje de tasa diaria del tipo de crédito">
                                                    @foreach ($errors->get('tasa_diaria') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="tasa"> % Tasa</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="tasa"
                                                    id="tasa"
                                                    value="{{ old('tasa', $tipoCredito->tasa) }}"
                                                    placeholder="Introduzca porcentaje de tasa diaria del tipo de crédito">
                                                    @foreach ($errors->get('tasa') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('tipo-credito.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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