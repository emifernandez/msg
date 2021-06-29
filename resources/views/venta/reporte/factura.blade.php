@extends('layouts.header')
@section('content')
<div class="wrapper">
  <table class="table table-bordered" style="width: 800px; padding:0; margin:0;">
        <tr>
            <td class ="text-center" style ="width: 70%">
                <h2 class="page-header">{{$general->nombre}} </h2>
                Dirección: {{$general->direccion}}<br>
                Teléfono: {{$general->telefono}}<br>
                Email: {{$general->email}}
            </td>
            <td class ="text-center" style ="width: 30%">
                <h2 class="page-header"><strong>FACTURA <br> {{'001-001-10000'}}</strong> </h2>
                <strong>Timbrado:</strong> {{$general->timbrado}}<br>
                <strong>Inicio Vigencia:</strong> {{$general->inicio_vigencia_timbrado->forForm()}}<br>
                <strong>Inicio Vigencia:</strong> {{$general->fin_vigencia_timbrado->forForm()}}<br>
                <strong>RUC:</strong> {{$general->ruc}}<br>
            </td>
        </tr>
  </table>
  <table class="table table-bordered" style="width:800px;padding:0; margin:0;">
    <tr>
        <td class ="text-center" style ="width: 50%;">
            <strong>Fecha de Emision:</strong> {{$fecha->forForm()}}
        </td>
        <td class ="text-center" style ="width: 50%">
            <strong>Condición de Venta:</strong> {{'CONTADO'}}
        </td>
    </tr>
  </table>
  <table class="table table-bordered" style="width:800px;padding:0; margin:0;">
    <tr>
        <td style ="width: 60%;">
            <strong>RUC:</strong> {{'4593675-7'}} <br>
            <strong>Nombre o Razón Social:</strong> {{'Emilce Fernandez'}}<br>
            <strong>Dirección:</strong> {{'Calle 000'}}
        </td>
        <td style ="width: 40%;border-left-style: hidden;">
            <strong>Teléfono:</strong> {{'0961508376'}} <br>
            <strong>Forma de Pago:</strong> {{'Efectivo'}}
        </td>
    </tr>
  </table>
  <table class="table table-bordered" style="width:800px;padding:0; margin:0;">
    <tr>
        <th style="width:5%">Cant.</th>
        <th style="width:10%">Código</th>
        <th style="width:45%">Descripción</th>
        <th class="text-center" style="width:10%">Precio Unitario</th>
        <th class="text-center" style="width:10%">Exentas</th>
        <th class="text-center" style="width:10%">5%</th>
        <th class="text-center" style="width:10%">10%</th>
    </tr>
    <tr>
        <td style="width:5%">999</td>
        <td style="width:10%">Código</td>
        <td style="width:45%">Descripción</td>
        <td class="text-center" style="width:10%">999,999,999</td>
        <td class="text-center" style="width:10%">999,999,999</td>
        <td class="text-center" style="width:10%">999,999,999</td>
        <td class="text-center" style="width:10%">999,999,999</td>
    </tr>
    <tr>
        <td class="text-right" colspan=4>Subtotal</td>
        <td class="text-center" style="width:10%">999,999,999</td>
        <td class="text-center" style="width:10%">999,999,999</td>
        <td class="text-center" style="width:10%">999,999,999</td>
    </tr>
  </table>
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