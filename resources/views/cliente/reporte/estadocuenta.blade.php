@extends('layouts.header')
@section('content')
<style>
body{
    margin-top:20px;
    background:#eee;
}

.invoice {
    padding: 10px;
}

.invoice h2 {
	margin-top: 0px;
	line-height: 0.8em;
}
.invoice .small {
	font-weight: 1;
}

.invoice hr {
	margin-top: 10px;
	border-color: #ddd;
}
.invoice .table {
	width: 100%;
}

.invoice .table tr.line {
	border-bottom: 1px solid #ccc;
}

.invoice .table td {
	border: none;
}

.invoice .identity {
	margin-top: 10px;
	font-size: 1.1em;
	font-weight: 300;
}

.invoice .identity strong {
	font-weight: 600;
}


.grid {
    position: relative;
	width: 100%;
	background: #fff;
	color: #666666;
	border-radius: 2px;
	margin-bottom: 25px;
	box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
}
</style>
<div class="container">
    <section class="invoice">
    <div class="row">
        <div class="col-12">
            <div class="grid invoice">
                <div class="grid-body">
                    <div class="invoice-title">
                        <div class="row">
                            <div class="col-8">
                                <img src="{!! asset('img/msg-logo.png') !!}" alt="" height="60">
                                <h2>{{$general->nombre}}</h2>
                            </div>
                            <div class="col-4">
                                <br>
                                <address class="text-right relative-bottom">
                                    {{$general->direccion}}<br>
                                    {{$general->telefono}}<br>
                                    {{$general->email}}
                                </address>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">ESTADO DE CUENTA DEL CLIENTE</h3>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <th style="width: 5%">Desde</th>
                                        <td>{{$fecha_inicio->forForm()}}</td>
                                    </td>
                                    <td>
                                        <th style="width: 5%">Hasta</th>
                                        <td>{{$fecha_fin->forForm()}}</td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <th style="width: 5%">Estado</th>
                                        <td>{{$estado}}</td>
                                    </td>
                                    <td>
                                        <th style="width: 15%">Tipo Comprobante</th>
                                        <td>{{$tipo_comprobante}}</td>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <h5 class="text-center">VENTAS REALIZADAS</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="line">
                                        <td style="width: 5%"><strong>#</strong></td>
                                        <td class="text-center" style="width: 20%"><strong>Fecha</strong></td>
                                        <td class="text-center" style="width: 10%"><strong>Tipo</strong></td>
                                        <td class="text-center" style="width: 10%"><strong>Comprobante</strong></td>
                                        <td class="text-center"><strong>Cliente</strong></td>
                                        <td class="text-center" style="width: 10%"><strong>Estado</strong></td>
                                        <td class="text-right" style="width: 15%"><strong>Total</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td class="text-center">{{$item->fecha}}</td>
                                        <td class="text-center">{{$tipos[$item->tipo_comprobante]}}</td>
                                        <td class="text-center">{{($item->tipo_comprobante == '1' ? $item->prefijo_factura : $item->id)}}</td>
                                        <td>{{$item->razon_social}}</td>
                                        <td class="text-center">{{$estados[$item->estado]}}</td>
                                        <td class="text-right">{{number_format($item->total,'0',',','.')}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">
                                        </td><td class="text-right"><strong>Cant. Registros</strong></td>
                                        <td class="text-right"><strong>{{count($data)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                        </td><td class="text-right"><strong>Total</strong></td>
                                        <td class="text-right"><strong>Gs. {{number_format($total_general,'0',',','.')}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5 class="text-center">RESERVAS PENDIENTES</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="line">
                                        <td class="text-center" style="width: 20%"><strong>Fecha</strong></td>
                                        <td class="text-center"><strong>Actividad</strong></td>
                                        <td class="text-center" style="width: 10%"><strong>Hora Inicio</strong></td>
                                        <td class="text-center" style="width: 10%"><strong>Hora Fin</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservas as $reserva)
                                    <tr>
                                        <td class="text-center">{{$reserva->fecha}}</td>
                                        <td>{{$reserva->descripcion}}</td>
                                        <td class="text-center">{{$reserva->hora_inicio}}</td>
                                        <td class="text-center">{{$reserva->hora_fin}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2">
                                        </td><td class="text-right"><strong>Cantidad</strong></td>
                                        <td class="text-right"><strong>{{count($reservas)}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>									
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center identity">
                            <p>Fin del reporte</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript"> 
        $(document).ready(function() {
            $('.print').print({
                addGlobalStyles : true,
                rejectWindow : true,
                noPrintSelector : ".no-print",
                iframe : true,
                append : null,
                prepend : null
            });
        })
    </script>
@endsection