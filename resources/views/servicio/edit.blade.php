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
                                    <hr>
                                    <div class="form-group text-center">
                                        <h4>Detalle</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla-servicio">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input class="form-control"
                                                                type="text"
                                                                name="cantidad"
                                                                id="cantidad"
                                                                value="{{ old('cantidad') }}"
                                                                placeholder="Cantidad">
                                                        </th>
                                                        <th>
                                                            <input class="form-control"
                                                                type="text"
                                                                name="precio"
                                                                id="precio"
                                                                value="{{ old('precio') }}"
                                                                placeholder="Precio">
                                                        </th>
                                                        <th>
                                                            <input class="form-control"
                                                                type="number"
                                                                min="0"
                                                                max="100"
                                                                oninput="validity.valid||(value='');"
                                                                name="iva"
                                                                id="iva"
                                                                value="{{ old('iva') }}"
                                                                placeholder="% IVA">
                                                        </th>
                                                        <th style="horizontal-align: middle; display: block; margin: auto;">
                                                            <a class="btn btn-info addServicio" data-toggle="tooltip" title="Agregar Acceso">
                                                                <i class="fas fa-plus"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($servicio->detalle as $key => $item)
                                                        <tr>
                                                            <td><input type="text" class="form-control item" name="cantidades[]" readonly value="{{ $item->cantidad }}"></td>
                                                            <td><input type="text" class="form-control" name="precios[]" readonly value="{{ $item->precio }}"></td>
                                                            <td><input type="text" class="form-control" name="ivas[]" readonly value="{{ $item->iva }}"></td>
                                                            <td>
                                                                <a class="btn btn-danger eliminar" data-toggle="tooltip" title="Eliminar detalle">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
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
@section('js')
<script type="text/javascript" src="{!! asset('js/util.js') !!}"></script>
@endsection