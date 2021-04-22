@extends('adminlte::page')
@section('title', 'Actividades')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Actividad</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('actividad.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="estado" id="estado" disabled>
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
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="hora_inicio">Hora Desde</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control timepicker"
                                                    name="hora_inicio"
                                                    id="hora_inicio"
                                                    value="{{ old('hora_inicio', $time = date("H:i")) }}">
                                                </div>
                                                @foreach ($errors->get('hora_inicio') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="hora_fin">Hora Hasta</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control timepicker"
                                                    name="hora_fin"
                                                    id="hora_fin"
                                                    value="{{ old('hora_fin', $time = date("H:i")) }}">
                                                </div>
                                                @foreach ($errors->get('hora_fin') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Días Disponibles</label>
                                                <table class="table table-borderless" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="lunes" name="lunes">
                                                                    <label for="lunes">Lunes</label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="martes" name="martes">
                                                                    <label for="martes">Martes</label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="miercoles" name="miercoles">
                                                                    <label for="miercoles">Miércoles</label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="jueves" name="jueves">
                                                                    <label for="jueves">Jueves</label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="viernes" name="viernes">
                                                                    <label for="viernes">Viernes</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="domingo" name="domingo">
                                                                    <label for="domingo">Domingo</label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" id="sabado" name="sabado">
                                                                    <label for="sabado">Sábado</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Genero Habilitado</label>
                                                <select class="form-control" name="genero_habilitado" id="genero_habilitado">
                                                    @foreach($generos as $key => $genero)
                                                        <option value="{{ $key }}"
                                                            @if($key == old('genero_habilitado')) selected @endif
                                                            >{{ $genero }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('genero_habilitado') as $error)
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
                                            value="{{ old('nombre') }}"
                                            placeholder="Introduzca nombre de la actividad">
                                            @foreach ($errors->get('nombre') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label>Empleado</label>
                                        <select class="form-control" name="empleado_id" id="empleado_id">
                                            <option value="">Seleccione un Empleado</option>
                                            @foreach($empleados as $key => $empleado)
                                                <option value="{{ $empleado->id }}"
                                                    @if($empleado->id == old('empleado_id')) selected @endif
                                                    >{{ $empleado->nombre . ' ' . $empleado->apellido }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('empleado_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Servicio</label>
                                                <select class="form-control" name="servicio_id" id="servicio_id">
                                                    <option value="">Seleccione un servicio</option>
                                                    @foreach($servicios as $key => $servicio)
                                                        <option value="{{ $servicio->id }}"
                                                            @if($servicio->id == old('servicio_id')) selected @endif
                                                            >{{ $servicio->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('servicio_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Salón</label>
                                                <select class="form-control" name="salon_id" id="salon_id">
                                                    <option value="">Seleccione un salón</option>
                                                    @foreach($salones as $key => $salon)
                                                        <option value="{{ $salon->id }}"
                                                            @if($salon->id == old('salon_id')) selected @endif
                                                            >{{ $salon->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('salon_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('actividad.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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