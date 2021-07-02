@extends('adminlte::page')
@section('title', 'Reportes')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Estado de Cuenta de Cliente</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('getReporteEstadoCuenta') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control select" name="cliente_id" id="cliente_id">
                                                    @foreach($clientes as $key => $cliente)
                                                        <option value="{{ $cliente->id }}"
                                                            @if($key == old('cliente_id')) selected @endif
                                                            >{{ $cliente->nombre . ' ' . $cliente->apellido }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('cliente_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="estado" id="estado">
                                                    <option value="0">Todos</option>
                                                    @foreach($estados as $key => $estado)
                                                        <option value="{{ $key }}"
                                                            @if($key == old('estado')) selected @endif
                                                            >{{ $estado }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('estado') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tipo Comprobante</label>
                                                <select class="form-control" name="tipo_comprobante" id="tipo_comprobante">
                                                    <option value="0">Todos</option>
                                                    @foreach($tipos_comprobantes as $key => $tipo_comprobante)
                                                        <option value="{{ $key }}"
                                                            @if($key == old('tipo_comprobante')) selected @endif
                                                            >{{ $tipo_comprobante }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('tipo_comprobante') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha Desde</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker"
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
                                                    <input type="text" class="form-control datepicker"
                                                    name="fecha_fin"
                                                    id="fecha_fin"
                                                    value="{{ old('fecha_fin') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_fin') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary btn-close">Cancelar</a>
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