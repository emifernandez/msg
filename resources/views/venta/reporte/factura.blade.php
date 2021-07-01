@extends('layouts.header')
@section('content')
<div class="wrapper">
  <table class="table table-bordered" style="width: 800px; padding:0; margin:0;">
        <tr>
            <td class ="text-center" style ="width: 70%">
                <img src="{!! asset('img/msg-logo.png') !!}" alt="" height="60">
                <h2 class="page-header">{{$general->nombre}} </h2>
                Dirección: {{$general->direccion}}<br>
                Teléfono: {{$general->telefono}}<br>
                Email: {{$general->email}}
            </td>
            <td class ="text-center" style ="width: 30%">
                @if($venta->tipo_comprobante == '1')
                    <h2 class="page-header"><strong>FACTURA <br> {{$venta->prefijo_factura}}</strong> </h2>
                    <strong>Timbrado:</strong> {{$general->timbrado}}<br>
                    <strong>Inicio Vigencia:</strong> {{$general->inicio_vigencia_timbrado->forForm()}}<br>
                    <strong>Inicio Vigencia:</strong> {{$general->fin_vigencia_timbrado->forForm()}}<br>
                    <strong>RUC:</strong> {{$general->ruc}}<br>
                @else
                    <h2 class="page-header"><strong>TICKET <br> {{$venta->id}}</strong> </h2>
                @endif
            </td>
        </tr>
  </table>
  <table class="table table-bordered" style="width:800px;padding:0; margin:0;">
    <tr>
        <td class ="text-center" style ="width: 50%;">
            <strong>Fecha de Emision:</strong> {{$fecha->forForm()}}
        </td>
        <td class ="text-center" style ="width: 50%">
            <strong>Condición de Venta:</strong> {{$forma_pago[$venta->forma_pago]}}
        </td>
    </tr>
  </table>
  <table class="table table-bordered" style="width:800px;padding:0; margin:0;">
    <tr>
        <td style ="width: 60%;">
            <strong>RUC:</strong> {{$venta->ruc}} <br>
            <strong>Nombre o Razón Social:</strong> {{$venta->razon_social}}<br>
            <strong>Dirección:</strong> {{$venta->direccion}}
        </td>
        <td style ="width: 40%;border-left-style: hidden;">
            <strong>Teléfono:</strong> {{$venta->telefono}} <br>
            <strong>Forma de Pago:</strong> {{$medio_pago[$venta->medio_pago]}}
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
    @foreach ($detalle as $item)
    <tr>
    <td style="width:5%">{{$item->cantidad}}</td>
        <td style="width:10%">{{$item->codigo_barra}}</td>
        <td style="width:45%">{{$item->descripcion}}</td>
        <td class="text-center" style="width:10%">{{number_format($item->precio,0,',','.')}}</td>
        <td class="text-center" style="width:10%">{{number_format(($item->iva == 0 ? ($item->precio * $item->cantidad) : 0),0,',','.')}}</td>
        <td class="text-center" style="width:10%">{{number_format(($item->iva == 5 ? ($item->precio * $item->cantidad) : 0),0,',','.')}}</td>
        <td class="text-center num" style="width:10%">{{number_format(($item->iva == 10 ? ($item->precio * $item->cantidad) : 0),0,',','.')}}</td>
    </tr>
    @endforeach
    <tr>
        <td class="text-left" colspan=2>Total A Pagar</td>
        <td class="text-left" colspan=4>{{$total_letras}}.</td>
        <td class="text-center" style="width:10%">{{number_format($venta->total,0,',','.')}}</td>
    </tr>
    <tr style="font-size: 12px">
        <td colspan="4">Liquidación del IVA </td>
        <td style="width:10%">(%5)<br> {{number_format($venta->total_iva5,0,',','.')}}</td>
        <td class="text-center" style="width:10%">(%10) <br>{{number_format($venta->total_iva10,0,',','.')}}</td>
        <td class="text-center" style="width:10%">Total IVA<br> {{number_format($venta->total_iva5 + $venta->total_iva10,0,',','.')}}</td>
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