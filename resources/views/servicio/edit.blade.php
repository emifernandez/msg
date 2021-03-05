@extends('adminlte::page')
@section('title', 'Servicios')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Servicio</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('servicio.update', $servicio->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <input class="form-control"
                                            type="text"
                                            name="descripcion"
                                            id="descripcion"
                                            value="{{ old('descripcion', $servicio->descripcion) }}"
                                            placeholder="Introduzca descripción del servicio">
                                            @foreach ($errors->get('descripcion') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="precio">Precio</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="precio"
                                                    id="precio"
                                                    value="{{ old('precio', $servicio->precio) }}"
                                                    placeholder="Introduzca precio del servicio">
                                                    @foreach ($errors->get('precio') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="iva">% IVA</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="iva"
                                                    id="iva"
                                                    value="{{ old('iva', $servicio->iva) }}"
                                                    placeholder="Introduzca porcentaje de IVA del servicio">
                                                    @foreach ($errors->get('iva') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('servicio.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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