@extends('adminlte::page')
@section('title', 'Roles')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Rol</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('rol.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control"
                                            type="text"
                                            name="nombre"
                                            id="nombre"
                                            value="{{ old('nombre') }}"
                                            placeholder="Introduzca nombre del rol">
                                            @foreach ($errors->get('nombre') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <input class="form-control"
                                            type="text"
                                            name="descripcion"
                                            id="descripcion"
                                            value="{{ old('descripcion') }}"
                                            placeholder="Introduzca descripción del rol">
                                            @foreach ($errors->get('descripcion') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <hr>
                                    <div class="form-group text-center">
                                        <h4>Accesos</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="tabla-acceso">
                                                <thead>
                                                    <tr>
                                                        <th style="display:none;">Acceso</td>
                                                        <th>
                                                            <div class="input-group ">
                                                                <select class="form-control" name="acceso" id="acceso">
                                                                    <option value=null>Seleccione un Acceso</option>
                                                                    @foreach($accesos as $key => $acceso)
                                                                        <option value="{{ $acceso }}"
                                                                            @if($acceso->id == old('acceso')) selected @endif
                                                                            >{{ $acceso->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @foreach ($errors->get('acceso') as $error)
                                                                    <span class="text text-danger">{{ $error }}</span>
                                                                @endforeach
                                                            </div>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="crear">Crear</label>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="modificar">Modificar</label>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="eliminar">Eliminar</label>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="visualizar">Visualizar</label>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="imprimir">Imprimir</label>
                                                        </th>
                                                        <th class="text-center" valign="center">
                                                            <label class="form-check-label" for="anular">Anular</label>
                                                        </th>
                                                        <th style="horizontal-align: middle; display: block; margin: auto;">
                                                            <a class="btn btn-info addAcceso" data-toggle="tooltip" title="Agregar Acceso">
                                                                <i class="fas fa-plus"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('rol.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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