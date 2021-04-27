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
                                <h3 class="card-title">Crear Servicio</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('servicio.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <input class="form-control"
                                            type="text"
                                            name="descripcion"
                                            id="descripcion"
                                            value="{{ old('descripcion') }}"
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
                                                            <input type="text" class="form-control"
                                                                name="cantidad"
                                                                id="cantidad"
                                                                value="{{ old('cantidad') }}"
                                                                placeholder="Cantidad">
                                                        </th>
                                                        <th>
                                                            <input type="text" class="form-control"
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
                                                                id="iva"
                                                                value="{{ old('iva') }}"
                                                                placeholder="% IVA">
                                                        </th>
                                                        <th>
                                                            <a style="horizontal-align: middle; margin: auto;" class="btn btn-info addServicio" data-toggle="tooltip" title="Agregar Acceso">
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