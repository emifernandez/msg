@extends('adminlte::page')
@section('title', 'Reservas')
@section('meta_tags')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Reserva</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('reserva.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control select" style="width: 100%" name="cliente_id" id="cliente_id">
                                            <option value="">Seleccione un Cliente</option>
                                            @foreach($clientes as $key => $cliente)
                                                <option value="{{ $cliente->id }}"
                                                    @if($cliente->id == old('cliente_id')) selected @endif
                                                    >{{ $cliente->nombre . ' ' . $cliente->apellido }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('cliente_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label>Actividad</label>
                                        <select class="form-control select" style="width: 100%" name="actividad_id" id="actividad_id">
                                            <option value="">Seleccione una Actividad</option>
                                            @foreach($actividades as $key => $actividad)
                                                <option value="{{ $actividad->id . '|' .$actividad->fecha_fin->forForm() }}"
                                                    @if($actividad->id == old('actividad_id')) selected @endif
                                                    >{{ $actividad->hora_inicio->forFormHour() . '-' . $actividad->hora_fin->forFormHour() . ' ' .$actividad->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('actividad_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha Desde</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    onkeydown="return false"
                                                    name="fecha_inicio"
                                                    id="fecha_inicio"
                                                    value="{{ old('fecha_inicio') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_inicio') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_fin">Fecha Hasta</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    onkeydown="return false"
                                                    name="fecha_fin"
                                                    id="fecha_fin"
                                                    value="{{ old('fecha_fin') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_fin') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="btn_buscar" disabled><i class="fas fa-search" aria-hidden="true"></i>
                                                 Buscar Eventos</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <hr>
                                        <div class="form-group text-center">
                                            <h4>Eventos Disponibles</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="tabla-reserva">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 2%"><input type="checkbox" id="select-evento" value='false'></th>
                                                            <th style="width: 15%">Fecha</th>
                                                            <th style="width: 15%">Horario</th>
                                                            <th>Actividad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body"> </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('reserva.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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
<script type="text/javascript" src="{!! asset('js/reserva.js') !!}"></script>
@endsection