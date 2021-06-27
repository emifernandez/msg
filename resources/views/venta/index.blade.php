@extends('adminlte::page')
@section('title', 'Ventas')
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
                                <h3 class="card-title">Cargar Venta</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('venta.store') }}" autocomplete="off"  onSubmit="return checkform()">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                    readonly
                                                    data-inputmask-alias="datetime"
                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                    data-mask
                                                    name="fecha"
                                                    id="fecha"
                                                    value="{{ old('fecha_ingreso', $todayDate = date("d-m-Y")) }}">
                                                </div>
                                                @foreach ($errors->get('fecha') as $error)
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

                                        <div class="col-sm-6" id="content-factura">
                                            <div class="form-group inline">
                                                <label for="numero_factura">Factura</label>
                                                <input class="form-control col-sm-6" readonly
                                                    type="text"
                                                    name="prefijo_factura"
                                                    id="prefijo_factura"
                                                    value="{{ $general->prefijo_factura . '-' . $nro_factura }}">
                                                <input type="hidden"
                                                    name="numero_factura"
                                                    id="numero_factura"
                                                    value="{{ $nro_factura }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        
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
                                            <button type="button" class="btn btn-info float-right" id="showProducto"> Agregar Productos <i class="fas fa-fw fa-angle-right"></i>
                                            </button>
                                            <a href="{{ route('reserva.create') }}" target="_blank" class= "btn btn-primary float-right" style="margin-right: 5px;">Agregar Reservas <i class="fas fa-fw fa-calendar-plus"></i></a>
                                        </div>
                                    </div>

                                    <div class="row" id="content-productos" style="display: none">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="codigo_barra">Codigo</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="codigo_barra"
                                                    id="codigo_barra"
                                                    value="{{ old('codigo_barra') }}"
                                                    placeholder="Cod. Barra">
                                            </div>
                                        </div>
                                        <div class="col-sm-5" >
                                            <div class="form-group">
                                                <label>Producto</label>
                                                <select class="form-control select" name="producto_id" id="producto_id" style="width: 100%">
                                                    <option value="">Seleccione un producto</option>
                                                    @foreach($stock as $key => $producto)
                                                        <option value="{{ $producto->id . '-' . $producto->producto_id }}"
                                                            @if($producto->producto->id == old('producto_id')) selected @endif
                                                            >{{ $producto->producto->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                @foreach ($errors->get('producto_id') as $error)
                                                    <span class="text text-danger">{{ $error }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="producto_cantidad">Cantidad</label>
                                                <input class="form-control"
                                                    type="number"
                                                    min="1"
                                                    oninput="validity.valid||(value='');"
                                                    name="producto_cantidad"
                                                    id="producto_cantidad"
                                                    value="{{ old('producto_cantidad') }}"
                                                    placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <a style="margin-top: 40%; width:40px" class="form-control btn btn-info" id="addProducto" data-toggle="tooltip" title="Agregar Producto">
                                                <i class="fas fa-plus"></i>
                                            </a>
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
                                            <tbody id="body">
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
                                                <th>IVA Gs. (10%)</th>
                                                <td><input type="text" id="total-iva-10" name="total_iva10" readonly class="form-control" value="0"></td>
                                              </tr>
                                              <tr>
                                                <th>IVA Gs. (5%)</th>
                                                <td><input type="text" id="total-iva-5" name="total_iva5" readonly class="form-control" value="0"></td>
                                              </tr>
                                              <tr>
                                                <th>IVA Gs. (0%)</th>
                                                <td><input type="text" id="total-iva-0" name="total_iva0" readonly class="form-control" value="0"></td>
                                              </tr>
                                              <tr>
                                              <tr>
                                                <th>Total Gs.:</th>
                                                <td><input type="text" id="total" name="total" readonly class="form-control" value="0"></td>
                                              </tr>
                                            </table>
                                          </div>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                <div class="card-footer">
                                    <button type="submit" formnovalidate class="btn btn-success" id="grabar"><i class="fas fa-file-invoice-dollar"></i> Grabar e Imprimir</button>
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