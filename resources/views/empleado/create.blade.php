@extends('adminlte::page')
@section('title', 'Empleados')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Empleado</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('empleado.store') }}">
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
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="fecha_ingreso">Fecha Ingreso</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" readonly
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="fecha_ingreso"
                                                    id="fecha_ingreso"
                                                    value="{{ old('fecha_ingreso', $todayDate = date("d-m-Y")) }}">
                                                </div>
                                                @foreach ($errors->get('fecha_ingreso') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tipo Documento</label>
                                                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                                    @foreach($tipos_documentos as $key => $tipo_documento)
                                                        <option value="{{ $key }}"
                                                            @if ($key == old('tipo_documento')) 
                                                                selected 
                                                            @elseif ($key == 1)
                                                                selected 
                                                            @endif
                                                            >{{ $tipo_documento }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('tipo_documento') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="numero_documento">Nro. Documento</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="numero_documento"
                                                    id="numero_documento"
                                                    value="{{ old('numero_documento') }}"
                                                    placeholder="Introduzca número de documento">
                                                    @foreach ($errors->get('numero_documento') as $error)
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
                                            placeholder="Introduzca nombre del empleado">
                                            @foreach ($errors->get('nombre') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input class="form-control"
                                            type="text"
                                            name="apellido"
                                            id="apellido"
                                            value="{{ old('apellido') }}"
                                            placeholder="Introduzca apellido del empleado">
                                            @foreach ($errors->get('apellido') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input class="form-control"
                                            type="text"
                                            name="direccion"
                                            id="direccion"
                                            value="{{ old('direccion') }}"
                                            placeholder="Introduzca dirección del empleado">
                                            @foreach ($errors->get('direccion') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control"
                                            type="text"
                                            name="email"
                                            id="email"
                                            value="{{ old('email') }}"
                                            placeholder="Introduzca email del empleado">
                                            @foreach ($errors->get('email') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="telefono"
                                                    id="telefono"
                                                    value="{{ old('telefono') }}"
                                                    placeholder="Introduzca teléfono del empleado">
                                                    @foreach ($errors->get('telefono') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="fecha_nacimiento">Fecha Nacimiento</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datemask"
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="fecha_nacimiento"
                                                    id="fecha_nacimiento"
                                                    value="{{ old('fecha_nacimiento') }}">
                                                </div>
                                                @foreach ($errors->get('fecha_nacimiento') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Genero</label>
                                                <select class="form-control" name="genero" id="genero">
                                                    @foreach($generos as $key => $genero)
                                                        <option value="{{ $key }}"
                                                                @if($key == old('genero')) selected @endif
                                                                >{{ $genero }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('genero') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('empleado.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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