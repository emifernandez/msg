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
                            <h3 class="text-center">FICHA DEL CLIENTE</h3>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <address style="padding: 10px">
                                        <strong>Nombre: </strong>{{$cliente->nombre . ' ' . $cliente->apellido}}<br>
                                        <strong>Razon Social: </strong>{{$cliente->razon_social}}<br>
                                        
                                        <strong>Dirección: </strong>{{$cliente->direccion}}<br>
                                        <strong>Teléfono: </strong>{{$cliente->teléfono}}<br>
                                        <strong>Email: </strong>{{$cliente->email}}<br>
                                    </address>
                                </div>
                                <div class="col-6 text-left">
                                    <address>
                                        <strong>Documento: </strong>{{$cliente->numero_documento}}<br>
                                        <strong>Ruc: </strong>{{$cliente->ruc}}<br>
                                        <strong>Fecha Nacimiento: </strong>{{$cliente->fecha_nacimiento->forForm()}}<br>
                                    </address>
                                </div>
                            </div>
                            
                            <table class="table table-striped">
                                <thead>
                                    <tr class="line">
                                        <td class="text-center"><strong>Altura</strong></td>
                                        <td class="text-center"><strong>Peso</strong></td>
                                        <td class="text-center"><strong>Alergias</strong></td>
                                        <td class="text-center"><strong>Antecedentes Médicos</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fichas as $i => $ficha)
                                    <tr>
                                        <td class="text-center">{{$ficha->altura}}</td>
                                        <td class="text-center">{{$ficha->peso}}</td>
                                        <td class="text-left">{{$ficha->alegia}}</td>
                                        <td class="text-left">{{$ficha->antecedente_medico}}</td>
                                    </tr>
                                    @endforeach
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
        <!-- END INVOICE -->
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