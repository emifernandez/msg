@extends('adminlte::page')
@section('title', 'Clientes')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Crear Cliente</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('cliente.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tipo Cliente</label>
                                                <select class="form-control" name="tipo_cliente" id="tipo_cliente">
                                                    @foreach($tipos_clientes as $key => $tipo_cliente)
                                                        <option value="{{ $key }}"
                                                            @if ($key == old('tipo_cliente')) 
                                                                selected 
                                                            @elseif ($key == 1)
                                                                selected 
                                                            @endif
                                                            >{{ $tipo_cliente }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('tipo_cliente') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Categoría</label>
                                                <select class="form-control" name="calificacion" id="calificacion">
                                                    @foreach($calificaciones as $key => $calificacion)
                                                    <option value="{{ $key }}"
                                                        @if ($key == old('calificacion')) 
                                                            selected 
                                                        @elseif ($key == 3)
                                                            selected 
                                                        @endif
                                                        >{{ $calificacion }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('calificacion') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
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
                                        <div class="col-sm-3">
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
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="ruc">RUC</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="ruc"
                                                    id="ruc"
                                                    value="{{ old('ruc') }}"
                                                    placeholder="Introduzca RUC del cliente">
                                                    @foreach ($errors->get('ruc') as $error)
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
                                            placeholder="Introduzca nombre del cliente">
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
                                            placeholder="Introduzca apellido del cliente">
                                            @foreach ($errors->get('apellido') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="razon_social">Razón Social</label>
                                        <input class="form-control"
                                            type="text"
                                            name="razon_social"
                                            id="razon_social"
                                            value="{{ old('razon_social') }}"
                                            placeholder="Introduzca razón social del cliente">
                                            @foreach ($errors->get('razon_social') as $error)
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
                                            placeholder="Introduzca dirección del cliente">
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
                                            placeholder="Introduzca email del cliente">
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
                                                    placeholder="Introduzca teléfono del cliente">
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
                                                    <input type="text" class="form-control datepicker"
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
                                    <button type="submit" formnovalidate class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('cliente.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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
<script type="text/javascript" src="{!! asset('js/validacion-cliente.js') !!}"></script>
@endsection