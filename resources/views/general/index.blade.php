@extends('adminlte::page')
@section('title', 'Datos Generales')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos Generales</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('general.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="ruc">Ruc</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="ruc"
                                                    id="ruc"
                                                    value="{{ old('ruc', $aux->ruc) }}"
                                                    placeholder="Introduzca RUC del negocio">
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
                                            value="{{ old('nombre', $aux->nombre) }}"
                                            placeholder="Introduzca nombre del negocio">
                                            @foreach ($errors->get('nombre') as $error)
                                                <span class="text text-danger">{{ $error }}</span>
                                            @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input class="form-control"
                                            type="text"
                                            name="direccion"
                                            id="direccion"
                                            value="{{ old('direccion', $aux->direccion) }}"
                                            placeholder="Introduzca dirección del negocio">
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
                                            value="{{ old('email', $aux->email) }}"
                                            placeholder="Introduzca email del negocio">
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
                                                    value="{{ old('telefono', $aux->telefono) }}"
                                                    placeholder="Introduzca teléfono del negocio">
                                                    @foreach ($errors->get('telefono') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="timbrado">Nro. Timbrado</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="timbrado"
                                                    id="timbrado"
                                                    value="{{ old('timbrado', $aux->timbrado) }}"
                                                    placeholder="Introduzca número de timbrado">
                                                    @foreach ($errors->get('timbrado') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inicio_vigencia_timbrado">Inicio Vigencia Timbrado</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker"
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="inicio_vigencia_timbrado"
                                                    id="inicio_vigencia_timbrado"
                                                    value="{{ old('inicio_vigencia_timbrado', $aux->inicio_vigencia_timbrado->forForm()) }}">
                                                </div>
                                                @foreach ($errors->get('inicio_vigencia_timbrado') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="fin_vigencia_timbrado">Fin Vigencia Timbrado</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker"
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="fin_vigencia_timbrado"
                                                    id="fin_vigencia_timbrado"
                                                    value="{{ old('fin_vigencia_timbrado', $aux->fin_vigencia_timbrado->forForm()) }}">
                                                </div>
                                                @foreach ($errors->get('fin_vigencia_timbrado') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="prefijo_factura">Prefijo Factura</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="prefijo_factura"
                                                    id="prefijo_factura"
                                                    value="{{ old('prefijo_factura', $aux->prefijo_factura) }}"
                                                    placeholder="Ej: 001-001">
                                                    @foreach ($errors->get('prefijo_factura') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="nro_factura_desde">Nro. Inicio Talonario</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="nro_factura_desde"
                                                    id="nro_factura_desde"
                                                    value="{{ old('nro_factura_desde', $aux->nro_factura_desde) }}"
                                                    placeholder="Introduzca número de inicio">
                                                    @foreach ($errors->get('nro_factura_desde') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="nro_factura_hasta">Nro. Fin Talonario</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="nro_factura_hasta"
                                                    id="nro_factura_hasta"
                                                    value="{{ old('nro_factura_hasta', $aux->nro_factura_hasta) }}"
                                                    placeholder="Introduzca número de fin">
                                                    @foreach ($errors->get('nro_factura_hasta') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="ultima_factura_impresa">Última Factura Impresa</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="ultima_factura_impresa"
                                                    id="ultima_factura_impresa"
                                                    value="{{ old('ultima_factura_impresa', $aux->ultima_factura_impresa) }}"
                                                    placeholder="Ej: 0">
                                                    @foreach ($errors->get('ultima_factura_impresa') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
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