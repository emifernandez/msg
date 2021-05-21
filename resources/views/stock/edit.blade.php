@extends('adminlte::page')
@section('title', 'Stock')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Stock</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('stock.update', $stock->id) }}" autocomplete="off">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="lote">Lote</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="lote"
                                                    id="lote"
                                                    value="{{ old('lote', $stock->lote) }}"
                                                    placeholder="Introduzca lote del stock">
                                                    @foreach ($errors->get('lote') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Producto</label>
                                        <select class="form-control select" name="producto_id" id="producto_id" style="width: 100%">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $key => $producto)
                                                <option value="{{ $producto->id }}"
                                                    @if($producto->id == old('producto_id', $stock->producto_id)) selected @endif
                                                    >{{ $producto->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('producto_id') as $error)
                                            <span class="text text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cantidad_actual">Cantidad Actual</label>
                                                <input type="text" class="form-control"
                                                    name="cantidad_actual"
                                                    id="cantidad_actual"
                                                    value="{{ old('cantidad_actual', $stock->cantidad_actual) }}"
                                                    placeholder="">
                                                    @foreach ($errors->get('cantidad_actual') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cantidad_minima">Cantidad Mínima</label>
                                                <input type="text" class="form-control"
                                                    name="cantidad_minima"
                                                    id="cantidad_minima"
                                                    value="{{ old('cantidad_minima', $stock->cantidad_minima) }}"
                                                    placeholder="">
                                                    @foreach ($errors->get('cantidad_minima') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cantidad_maxima">Cantidad Máxima</label>
                                                <input type="text" class="form-control"
                                                    name="cantidad_maxima"
                                                    id="cantidad_maxima"
                                                    value="{{ old('cantidad_maxima', $stock->cantidad_maxima) }}"
                                                    placeholder="">
                                                    @foreach ($errors->get('cantidad_maxima') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="precio_compra">Precio Compra</label>
                                                <input type="text" class="form-control"
                                                    name="precio_compra"
                                                    id="precio_compra"
                                                    value="{{ old('precio_compra', $stock->precio_compra) }}"
                                                    placeholder="">
                                                    @foreach ($errors->get('precio_compra') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="precio_venta">Precio Venta</label>
                                                <input type="text" class="form-control"
                                                    name="precio_venta"
                                                    id="precio_venta"
                                                    value="{{ old('precio_venta', $stock->precio_venta) }}"
                                                    placeholder="">
                                                    @foreach ($errors->get('precio_venta') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                    <a href="{{ route('stock.index') }}" class="btn btn-secondary btn-close">Cancelar</a>
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