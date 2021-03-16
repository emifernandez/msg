@extends('adminlte::page')
@section('title', 'Productos')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Producto</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('producto.update', $producto->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="estado" id="estado">
                                                    @foreach($estados as $key => $estado)
                                                        <option value="{{ $key }}"
                                                            @if($key == old('estado', $producto->estado)) selected @endif
                                                            >{{ $estado }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('estado') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control"
                                            type="text"
                                            name="nombre"
                                            id="nombre"
                                            value="{{ old('nombre', $producto->nombre) }}"
                                            placeholder="Introduzca nombre del producto">
                                            @foreach ($errors->get('nombre') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control"
                                            rows="3"
                                            type="text"
                                            name="descripcion"
                                            id="descripcion"
                                            value="{{ old('descripcion', $producto->descripcion) }}"
                                            placeholder="Introduzca descripción del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                            @foreach ($errors->get('descripcion') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="codigo_barra">Código de Barras</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="codigo_barra"
                                                    id="codigo_barra"
                                                    value="{{ old('codigo_barra', $producto->codigo_barra) }}"
                                                    placeholder="Introduzca código de barras del producto">
                                                    @foreach ($errors->get('codigo_barra') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="iva">% IVA</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="iva"
                                                    id="iva"
                                                    value="{{ old('iva', $producto->iva) }}"
                                                    placeholder="Introduzca porcentaje de IVA del producto">
                                                    @foreach ($errors->get('iva') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <select class="form-control" name="tipo" id="tipo">
                                                    @foreach($tipos as $key => $tipo)
                                                        <option value="{{ $key }}"
                                                            @if($key == old('tipo', $producto->tipo)) selected @endif
                                                            >{{ $tipo }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('tipo') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Marca</label>
                                                <select class="form-control" name="marca_id" id="marca_id">
                                                    <option value="">Seleccione una marca</option>
                                                    @foreach($marcas as $key => $marca)
                                                        <option value="{{ $marca->id }}"
                                                            @if($marca->id == old('marca_id', $producto->marca_id)) selected @endif
                                                            >{{ $marca->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('marca_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Unidad de Medida</label>
                                                <select class="form-control" name="unidad_id" id="unidad_id">
                                                    <option value="">Seleccione una unidad de medida</option>
                                                    @foreach($unidades as $key => $unidad)
                                                        <option value="{{ $unidad->id }}"
                                                            @if($unidad->id == old('unidad_id', $producto->unidad_id)) selected @endif
                                                            >{{ $unidad->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('unidad_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('producto.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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