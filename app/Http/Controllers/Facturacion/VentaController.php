<?php

namespace App\Http\Controllers\Facturacion;

use App\Formatters\DateFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Venta\StoreVentaRequest;
use App\Models\Actividad;
use App\Models\Cliente;
use App\Models\DatosGenerales;
use App\Models\Evento;
use App\Models\Reserva;
use App\Models\Stock;
use App\Models\ServicioDetalle;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $general = DatosGenerales::all()->first();
        // $fecha = new DateFormatter(now());
        // return view('venta.reporte.factura')
        //     ->with('general', $general)
        //     ->with('fecha', $fecha);
        $aux = new Venta();
        $this->authorize('create', $aux);
        $datos_generales = DatosGenerales::all();
        if ($datos_generales->count() > 0) {
            $general = $datos_generales->first();
            $nro_factura = $general->ultima_factura_impresa + 1;
            if ($nro_factura < $general->nro_factura_desde || $nro_factura > $general->nro_factura_hasta) {
                alert('Facturación', 'Talonario completado. Para asignar nuevos valores al talonario ingrese al menú Parámetros/Datos Generales', 'warning');
                return redirect()->back();
            } else {
                if ($general->nro_factura_hasta >= $nro_factura && ($general->nro_factura_hasta - $nro_factura) < 10) {
                    alert('Facturación', 'Sólo quedan ' . ($general->nro_factura_hasta - $nro_factura) . ' facturas en el talonario', 'warning');
                }
                $tipo_comprobantes = Venta::TIPO_COMPROBANTE;
                $forma_pagos = Venta::FORMA_PAGO;
                $medio_pagos = Venta::MEDIO_PAGO;
                $clientes = Cliente::where('estado', '1')->orderBy('nombre', 'asc')->get();
                $stock = Stock::where('cantidad_actual', '>', '0')->get();
                $actividades = Actividad::whereRaw('now()::date BETWEEN fecha_inicio AND fecha_fin
                    OR (fecha_fin IS null AND fecha_inicio <= now()::date)')->get();

                return view('venta.index')
                    ->with('tipo_comprobantes', $tipo_comprobantes)
                    ->with('forma_pagos', $forma_pagos)
                    ->with('medio_pagos', $medio_pagos)
                    ->with('clientes', $clientes)
                    ->with('stock', $stock)
                    ->with('actividades', $actividades)
                    ->with('general', $general)
                    ->with('nro_factura', $nro_factura);
            }
        } else {
            alert('Facturación', 'Para poder acceder a las facturaciones primero debe completar los datos generales en el menú Parametros/Datos Generales', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVentaRequest $request)
    {

        $ids = $request->input('ids', []);
        $cantidades = $request->input('cantidad', []);
        $precios = $request->input('precio', []);
        $ivas = $request->input('iva', []);
        $tipos = $request->input('tipo', []);
        if (count($ids) > 0) {
            DB::transaction(function () use ($request, $ids, $cantidades, $precios, $ivas, $tipos) {
                //SE GRABA CABECERA VENTA
                $venta = new Venta();
                $venta->fecha = now();
                $venta->cliente_id = $request->cliente_id;
                $venta->tipo_comprobante = $request->tipo_comprobante;
                //EN CASO DE SER FACTURA SE CARGAN LOS DATOS Y SE ACTUALIZA LA NUMERACIÓN EN datos_generales
                if ($request->tipo_comprobante == '1') {
                    $venta->nro_factura = $request->numero_factura;
                    $venta->prefijo_factura = $request->prefijo_factura;
                    $general = DatosGenerales::all()->first();
                    $general->ultima_factura_impresa = $request->numero_factura;
                    $general->save();
                }
                $venta->total = str_replace('.', '', $request->total);
                $venta->total_iva10 = str_replace('.', '', $request->total_iva10);
                $venta->total_iva5 = str_replace('.', '', $request->total_iva5);
                $venta->total_iva0 = str_replace('.', '', $request->total_iva0);
                $venta->descuento = 0;
                $venta->estado = '1'; //activo
                $venta->forma_pago = $request->forma_pago;
                $venta->medio_pago = $request->medio_pago;
                $venta->user_id = auth()->user()->id;
                $venta->save();

                //SE GRABA DETALLE VENTA
                foreach ($ids as $i => $id) {
                    $precio = (int)str_replace('.', '', explode('-', $precios[$i])[2]);
                    $iva = (float)explode('-', $ivas[$i])[0];
                    $monto_iva = (int)explode('-', $ivas[$i])[1];
                    $cantidad = (int)$cantidades[$i];
                    //DETALLE VENTA DE TIPO RESERVAS
                    if ($tipos[$i] == 'reserva') {
                        $reservas = DB::select(DB::raw(
                            'select reservas.*
                            from actividades
                                inner join eventos on actividades.id = eventos.actividad_id
                                inner join reservas on eventos.id = reservas.evento_id
                            where actividades.id = ' . $id . '
                            and reservas.cliente_id = ' . $request->cliente_id . '
                            and reservas.estado = \'1\''
                        ));
                        foreach ($reservas as $j => $reserva) {
                            if ($j < $cantidad) {
                                $venta->reservas()->attach($venta, [
                                    'reserva_id' => $reserva->id,
                                    'cantidad' => 1,
                                    'precio' => $precio,
                                    'descuento' => 0,
                                    'monto_iva' => round($iva == 10 ? $precio / 11 : ($iva == 5 ? $precio / 22 : 0)),
                                    'iva' => $iva,
                                    'subtotal' => ($precio),
                                ]);
                                //SE ACTUALIZA ESTADO DE RESERVAS A PAGADO
                                $r = Reserva::find($reserva->id);
                                $r->estado = '2';
                                $r->save();
                            } else {
                                break;
                            }
                        }
                    } else { //DETALLE VENTA DE TIPO PRODUCTOS
                        $stock_id = explode('-', $id)[0];
                        $producto_id = explode('-', $id)[1];
                        $venta->productos()->attach($venta, [
                            'producto_id' => $producto_id,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'descuento' => 0,
                            'monto_iva' => $monto_iva,
                            'iva' => $iva,
                            'subtotal' => ($cantidad * $precio),
                        ]);
                        //SE ACTUALIZA EL STOCK
                        $stock = Stock::find($stock_id);
                        $stock->cantidad_actual -= $cantidad;
                        $stock->save();
                    }
                }
            });
            toast('Venta grabada correctamente', 'success');
            return redirect()->route('venta.index');
        } else {
            toast('Debe ingresar al menos un detalle para grabar la venta', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }

    public function getCliente(Request $request)
    {
        if (isset($request->campo) && isset($request->valor)) {
            $cliente = Cliente::where($request->campo, $request->valor)->get();
            $reservas = collect([]);
            if ($cliente->first() != null) {
                $cli = $cliente->first();

                $reservas = DB::select(DB::raw(
                    'select count(reservas.cliente_id) as cantidad
                        , actividades.id as codigo
                        , actividades.servicio_id as servicio_id
                        , initcap(actividades.nombre) as descripcion
                        , coalesce((select precio from servicio_detalle where servicio_id = actividades.servicio_id and cantidad = 1), 0) as precio_unitario
                    from reservas
                        inner join eventos on eventos.id = reservas.evento_id
                        inner join actividades on actividades.id = eventos.actividad_id
                    where reservas.cliente_id = ' . $cli->id . ' and reservas.estado = \'1\'
                    group by actividades.id, actividades.nombre'
                ));
                foreach ($reservas as $reserva) {
                    $precios = ServicioDetalle::where('servicio_id', $reserva->servicio_id)->orderBy('cantidad', 'asc')->get();
                    $reserva->precios = $precios;
                }
            }

            $data['cliente'] = $cliente;
            $data['reservas'] = $reservas;
            echo json_encode($data);
        }
        exit;
    }

    public function getStock(Request $request)
    {
        if (isset($request->campo) && isset($request->valor)) {
            $val = explode('-', $request->valor)[1];
            $valor = $request->campo == 'id' ? $val : '\'' . $val . '\'';
            $stock = DB::select(DB::raw(
                'select 
                    stock.id as "stock_id",
                    productos.id as "producto_id",
                    cantidad_actual,
                    cantidad_minima,
                    coalesce(cantidad_maxima),
                    precio_venta,
                    precio_compra,
                    productos.codigo_barra,
                    initcap(productos.nombre) as nombre,
                    productos.iva
                from stock
                    inner join productos on productos.id = stock.producto_id
                where productos.' . $request->campo . ' = ' . $valor
            ));

            $data['stock'] = $stock;
            echo json_encode($data);
        }
        exit;
    }
}
