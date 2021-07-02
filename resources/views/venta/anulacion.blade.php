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
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Anulación de Venta</h3>
                            </div>
                            <form role="form" id="form" method="POST" action="{{ route('venta.destroy', 'test')}}" autocomplete="off">
                                @csrf
                                @method('DELETE')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="venta_id">Cod. Venta</label>
                                                <input class="form-control"
                                                    type="text"
                                                    name="venta_id"
                                                    id="venta_id"
                                                    value="{{ old('venta_id') }}"
                                                    placeholder="Código de Venta">
                                                    @foreach ($errors->get('venta_id') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="numero_documento">Nro. Documento</label>
                                                <input class="form-control" readonly
                                                    type="text"
                                                    name="numero_documento"
                                                    id="numero_documento"
                                                    value="{{ old('numero_documento') }}">
                                                    @foreach ($errors->get('numero_documento') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="total">Total</label>
                                                <input class="form-control" readonly
                                                    type="text"
                                                    name="total"
                                                    id="total"
                                                    value="{{ old('total') }}">
                                                    @foreach ($errors->get('total') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="tipo_comprobante">Tipo Comprobante</label>
                                                <input class="form-control" readonly
                                                    type="text"
                                                    name="tipo_comprobante"
                                                    id="tipo_comprobante"
                                                    value="{{ old('tipo_comprobante') }}">
                                                    @foreach ($errors->get('tipo_comprobante') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cliente">Cliente</label>
                                                <input class="form-control" readonly
                                                    type="text"
                                                    name="cliente"
                                                    id="cliente"
                                                    value="{{ old('cliente') }}">
                                                    @foreach ($errors->get('cliente') as $error)
                                                        <span class="text text-danger">{{ $error }}</span>
                                                    @endforeach
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                <div class="card-footer">
                                    <button type="submit" id="submit" class="btn btn-danger">Anular</button>
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
<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {
    $(document).on("keydown", "form", function(event) { 
        
        if(event.key == "Enter") {
            document.getElementById("numero_documento").focus();
            return false;
        } else {
            return true;
        }
    });
    $("#venta_id").blur(function () {
        var id = $('#venta_id').val();
        if (id.length >= 1) {
            console.log(id);
            $.ajax({
            url: '/getVenta',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                venta_id: id
            },
            success: function (response) {
                if (response['venta']) {
                    let venta = response['venta'];
                    if(venta.estado == '2') {
                        Swal.fire({
                            text: 'La venta ya se encuentra anulada',
                            toast: true,
                            icon: 'warning',
                            position: 'top-right',
                            timer: 5000,
                            showConfirmButton: false,
                        });
                        limpiarCampos();
                    } else {
                        $('#total').val(formatMiles(venta.total));
                        $('#tipo_comprobante').val(venta.tipo_comprobante);
                        $('#cliente').val(venta.cliente.razon_social);
                        $('#numero_documento').val(venta.prefijo_factura);
                    }
                    
                } else {
                    Swal.fire({
                        text: 'La venta no existe',
                        toast: true,
                        icon: 'warning',
                        position: 'top-right',
                        timer: 5000,
                        showConfirmButton: false,
                    });
                    limpiarCampos();
                    return null;
                }
            }
        })
        }
    });

    function limpiarCampos() {
        $('#venta_id').val(null);
        $('#total').val(null);
        $('#tipo_comprobante').val(null);
        $('#cliente').val(null);
        $('#numero_documento').val(null);
    }

    function formatMiles(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});
</script>
@endsection