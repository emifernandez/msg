@extends('adminlte::page')
@section('title', 'Eventos')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Evento</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('evento.update', $evento->id) }}" autocomplete="off">
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
                                                            @if($key == old('estado', $evento->estado)) selected @endif
                                                            >{{ $estado }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('estado') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker"
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="fecha"
                                                    id="fecha"
                                                    value="{{ old('fecha', $evento->fecha) }}">
                                                </div>
                                                @foreach ($errors->get('fecha') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Actividad</label>
                                        <select class="form-control" name="actividad_id" id="actividad_id">
                                            <option value="">Seleccione un Actividad</option>
                                            @foreach($actividades as $key => $actividad)
                                                <option value="{{ $actividad->id }}"
                                                    @if($actividad->id == old('actividad_id', $evento->actividad_id)) selected @endif
                                                    >{{ $actividad->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('actividad_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="lugares_disponibles">Lugares Disponibles</label>
                                                <input class="form-control"
                                                    type="number"
                                                    min="1"
                                                    oninput="validity.valid||(value='');"
                                                    name="lugares_disponibles"
                                                    id="lugares_disponibles"
                                                    value="{{ old('lugares_disponibles', $evento->lugares_disponibles) }}">
                                                    @foreach ($errors->get('lugares_disponibles') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('evento.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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