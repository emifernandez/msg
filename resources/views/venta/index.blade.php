@extends('adminlte::page')
@section('title', 'Ventas')
@section('meta_tags')
<meta name="csrf-token" content="{{ csrf_token() }}"
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
                                <h3 class="card-title">Cargar Venta</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('venta.store') }}" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha_ingreso">Fecha</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    readonly
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
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tipo Comprbante</label>
                                                <select class="form-control" name="tipo_comprobante" id="tipo_comprobante">
                                                    @foreach($tipo_comprobantes as $key => $tipo_comprobante)
                                                        <option value="{{ $key }}"
                                                            @if ($key == old('tipo_comprobante')) 
                                                                selected 
                                                            @elseif ($key == 1)
                                                                selected 
                                                            @endif
                                                            >{{ $tipo_comprobante }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('tipo_comprobante') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Forma Pago</label>
                                                <select class="form-control" name="forma_pago" id="forma_pago">
                                                    @foreach($forma_pagos as $key => $forma_pago)
                                                        <option value="{{ $key }}"
                                                            @if ($key == old('forma_pago')) 
                                                                selected 
                                                            @elseif ($key == 1)
                                                                selected 
                                                            @endif
                                                            >{{ $forma_pago }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('forma_pago') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Medio Pago</label>
                                                <select class="form-control" name="medio_pago" id="medio_pago">
                                                    @foreach($medio_pagos as $key => $medio_pago)
                                                        <option value="{{ $key }}"
                                                            @if ($key == old('medio_pago')) 
                                                                selected 
                                                            @elseif ($key == 1)
                                                                selected 
                                                            @endif
                                                            >{{ $medio_pago }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('medio_pago') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="numero_documento">Nro. Documento</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="numero_documento"
                                                    id="numero_documento"
                                                    value="{{ old('numero_documento') }}"
                                                    placeholder="Nro. Documento">
                                                    @foreach ($errors->get('numero_documento') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="ruc">RUC</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="ruc"
                                                    id="ruc"
                                                    value="{{ old('ruc') }}"
                                                    placeholder="RUC">
                                                    @foreach ($errors->get('ruc') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control select" name="cliente_id" id="cliente_id" style="width: 100%">
                                                    <option value="">Seleccione un cliente</option>
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
                                        </div>
                                    </div>

                                    <div class="row no-print">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-info float-right"><i class="fa fa-box"></i> Agregar Productos
                                            </button>
                                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                                <i class="fas fa-calendar-check"></i> Agregar Servicios
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 1rem">
                                        <div class="col-12 table-responsive">
                                          <table id="detalle" class="table table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 10%">Cant.</th>
                                                    <th class="text-center" style="width: 10%">Código</th>
                                                    <th class="text-center" style="width: 50%">Descripción</th>
                                                    <th style="width: 10%">Precio Unitario</th>
                                                    <th class="text-center" style="width: 10%">Subtotal</th>
                                                    <th class="text-center" style="width: 1%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-8">
                                          
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4">
                                          <div class="table-responsive">
                                            <table class="table table-sm">
                                              <tr>
                                                <th>IVA (10%)</th>
                                                <td id="total-iva-10">Gs. 0</td>
                                              </tr>
                                              <tr>
                                                <th>IVA (5%)</th>
                                                <td id="total-iva-5">Gs. 0</td>
                                              </tr>
                                              <tr>
                                                <th>Total:</th>
                                                <td id="total">Gs. 0</td>
                                              </tr>
                                            </table>
                                          </div>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                <div class="card-footer">
                                    <button type="submit" formnovalidate class="btn btn-success"><i class="fas fa-file-invoice-dollar"></i> Grabar e Imprimir</button>
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
@section('js')
<script type="text/javascript" src="{!! asset('js/venta.js') !!}"></script>
@endsection