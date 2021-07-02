<?php

namespace App\Http\Controllers\Facturacion;

use App\Formatters\DateFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Venta\AnularVentaRequest;
use App\Http\Requests\Venta\ReporteVentaRequest;
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
use App\Traits\Helpers;

class VentaController extends Controller
{
    private $venta_id = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('venta.anulacion');
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
        $codigos = $request->input('codigos', []);
        $descripciones = $request->input('descripciones', []);
        if (count($ids) > 0) {
            DB::transaction(function () use ($request, $ids, $cantidades, $precios, $ivas, $tipos, $codigos, $descripciones) {
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
                $this->venta_id = $venta->id;
                //SE GRABA DETALLE VENTA
                foreach ($ids as $i => $id) {
                    $precio = (int)str_replace('.', '', explode('-', $precios[$i])[2]);
                    $iva = (float)explode('-', $ivas[$i])[0];
                    $monto_iva = (int)explode('-', $ivas[$i])[1];
                    $cantidad = (int)$cantidades[$i];
                    $descripcion = $descripciones[$i];
                    $codigo_barra = $codigos[$i];
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
                                    'descripcion' => $descripcion,
                                    'codigo_barra' => $codigo_barra
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
                            'descripcion' => $descripcion,
                            'codigo_barra' => $codigo_barra
                        ]);
                        //SE ACTUALIZA EL STOCK
                        $stock = Stock::find($stock_id);
                        $stock->cantidad_actual -= $cantidad;
                        $stock->save();
                    }
                }
            });
            toast('Venta grabada correctamente', 'success');
            echo "<script>window.open('" . route('printFactura', $this->venta_id) . "', '_blank');</script>";
            echo "<script>window.location.assign('" . route('venta.index') . "');</script>";
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
    public function destroy(AnularVentaRequest $request)
    {
        $venta = Venta::find($request->venta_id);
        DB::transaction(function () use ($venta) {
            $venta->estado = '2'; //anulado;
            $venta->save();
            foreach ($venta->productos as $producto) {
                $stock = Stock::where('producto_id', $producto->id)->get()->first();
                $stock->cantidad_actual += $producto->pivot->cantidad;
                $stock->save();
            }
            foreach ($venta->reservas as $reserva) {
                $reserva->estado = '1'; //reservado
                $reserva->save();
            }
        });
        toast('Venta anulada correctamente', 'success');
        return redirect()->route('home');
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
            $v = explode('-', $request->valor);
            $val = count($v) > 1 ? $v[1] : $v[0];
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

    public function getVenta(Request $request)
    {
        if (isset($request->venta_id)) {
            $venta = Venta::find($request->venta_id);
            if (isset($venta)) {
                $tipos_comprobantes = Venta::TIPO_COMPROBANTE;
                $venta->tipo_comprobante = $tipos_comprobantes[$venta->tipo_comprobante];
                $venta->cliente = Cliente::find($venta->cliente_id);
            }
            $data['venta'] = $venta;
            echo json_encode($data);
        }
        exit;
    }

    public function printFactura($id)
    {
        $venta = array_values(DB::select(DB::raw(
            'select
            ventas.id,
            fecha,
            prefijo_factura,
            total,
            total_iva0,
            total_iva5,
            total_iva10,
            tipo_comprobante,
            forma_pago,
            medio_pago,
            clientes.razon_social,
            clientes.ruc,
            clientes.numero_documento,
            clientes.direccion,
			clientes.telefono
        from ventas
            inner join clientes on ventas.cliente_id = clientes.id
        where ventas.id = ' . $id . ' limit 1'
        )))[0];

        $detalle = DB::select(DB::raw(
            'select 
            cantidad,
            codigo_barra,
            descripcion,
            precio,
            iva
        from ventas_detalles_productos
        where venta_id = ' . $id . '
        union all
        select 
            count(id) as cantidad,
            codigo_barra,
            descripcion,
            precio,
            iva
        from ventas_detalles_reservas
        where venta_id = ' . $id . '
        group by descripcion, codigo_barra, precio, iva'
        ));
        $general = DatosGenerales::all()->first();
        $medio_pago = Venta::MEDIO_PAGO;
        $forma_pago = Venta::FORMA_PAGO;
        $total_letras = Helpers::convertir($venta->total, 'guaraníes');
        $fecha = new DateFormatter($venta->fecha);
        return view('venta.reporte.factura')
            ->with('general', $general)
            ->with('venta', $venta)
            ->with('detalle', $detalle)
            ->with('forma_pago', $forma_pago)
            ->with('medio_pago', $medio_pago)
            ->with('total_letras', $total_letras)
            ->with('fecha', $fecha);
    }

    public function reporteVenta()
    {
        $estados = Venta::ESTADO;
        $tipos_comprobantes = Venta::TIPO_COMPROBANTE;
        return view('venta.reporte-venta')
            ->with('estados', $estados)
            ->with('tipos_comprobantes', $tipos_comprobantes);
    }

    public function reporteVentaProducto()
    {
        return view('producto.reporte-producto');
    }

    public function reporteVentaServicio()
    {
        return view('servicio.reporte-servicio');
    }

    public function reporteVentaReserva()
    {
        return view('reserva.reporte-reserva');
    }

    public function getReporteVenta(ReporteVentaRequest $request)
    {
        $fecha_inicio = new DateFormatter($request->fecha_inicio);
        $fecha_fin = new DateFormatter($request->fecha_fin);
        $general = DatosGenerales::all()->first();
        $estados = Venta::ESTADO;
        $tipos = Venta::TIPO_COMPROBANTE;
        $estado = $request->estado == '0' ? 'Todos' : $estados[$request->estado];
        $tipo_comprobante = $request->tipo_comprobante == '0' ? 'Todos' : $tipos[$request->tipo_comprobante];
        $data = DB::select(DB::raw(
            'select ventas.id,
                fecha,
                prefijo_factura,
                total,
                tipo_comprobante,
                ventas.estado,
                forma_pago,
                medio_pago,
                clientes.razon_social,
                clientes.ruc,
                clientes.numero_documento
            from ventas
                inner join clientes on ventas.cliente_id = clientes.id
            where fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and (ventas.estado = \'' . $request->estado . '\' or \'0\' = \'' . $request->estado . '\')
            and (tipo_comprobante = \'' . $request->tipo_comprobante . '\' or \'0\' = \'' . $request->tipo_comprobante . '\')'
        ));
        $total_general = 0;
        foreach ($data as $key => $item) {
            $total_general += $item->total;
        }
        return view('venta.reporte.ventas')
            ->with('general', $general)
            ->with('data', $data)
            ->with('estados', $estados)
            ->with('tipos', $tipos)
            ->with('fecha_inicio', $fecha_inicio)
            ->with('fecha_fin', $fecha_fin)
            ->with('estado', $estado)
            ->with('tipo_comprobante', $tipo_comprobante)
            ->with('total_general', $total_general);
    }

    public function getReporteVentaProducto(ReporteVentaRequest $request)
    {
        $fecha_inicio = new DateFormatter($request->fecha_inicio);
        $fecha_fin = new DateFormatter($request->fecha_fin);
        $general = DatosGenerales::all()->first();
        $fechas = DB::select(DB::raw(
            'select
                ventas.fecha::date,
                sum(subtotal) as total
            from ventas_detalles_productos
                inner join ventas on ventas.id = ventas_detalles_productos.venta_id
            where ventas.fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and ventas.estado = \'1\'
            group by ventas.fecha::date
            order by fecha::date'
        ));
        $ventas = DB::select(DB::raw(
            'select
                ventas.fecha::date,
                producto_id,
                descripcion,
                precio,
                codigo_barra,
                sum(cantidad) as cantidad,
                sum(subtotal) as total
            from ventas_detalles_productos
                inner join ventas on ventas.id = ventas_detalles_productos.venta_id
            where ventas.fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and ventas.estado = \'1\'
            group by ventas.fecha::date,
                producto_id,
                descripcion,
                precio,
                codigo_barra
            order by fecha,descripcion'
        ));
        $data['ventas'] = $ventas;
        $data['fechas'] = $fechas;
        $total_general = 0;
        foreach ($data['ventas'] as $key => $item) {
            $total_general += $item->total;
        }
        return view('venta.reporte.producto')
            ->with('general', $general)
            ->with('data', $data)
            ->with('fecha_inicio', $fecha_inicio)
            ->with('fecha_fin', $fecha_fin)
            ->with('total_general', $total_general);
    }

    public function getReporteVentaServicio(ReporteVentaRequest $request)
    {
        $fecha_inicio = new DateFormatter($request->fecha_inicio);
        $fecha_fin = new DateFormatter($request->fecha_fin);
        $general = DatosGenerales::all()->first();
        $data = DB::select(DB::raw(
            'select 
                ventas.fecha::date,
                servicios.id as codigo_barra,
                initcap(servicios.descripcion) as descripcion,
                precio,
                sum(cantidad) as cantidad,
                sum(subtotal) as total
            from ventas_detalles_reservas
                inner join ventas on ventas.id = ventas_detalles_reservas.venta_id
                inner join reservas on reservas.id = ventas_detalles_reservas.reserva_id
                inner join eventos on eventos.id = reservas.evento_id
                inner join actividades on actividades.id = eventos.actividad_id
                inner join servicios on servicios.id = actividades.servicio_id
            where ventas.fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and ventas.estado = \'1\'
            group by ventas.fecha::date,
                servicios.id,
                initcap(servicios.descripcion),
                precio
            order by ventas.fecha::date, initcap(servicios.descripcion)'
        ));
        $total_general = 0;
        foreach ($data as $key => $item) {
            $total_general += $item->total;
        }
        return view('venta.reporte.servicio')
            ->with('general', $general)
            ->with('data', $data)
            ->with('fecha_inicio', $fecha_inicio)
            ->with('fecha_fin', $fecha_fin)
            ->with('total_general', $total_general);
    }

    public function getReporteVentaReserva(ReporteVentaRequest $request)
    {
        $fecha_inicio = new DateFormatter($request->fecha_inicio);
        $fecha_fin = new DateFormatter($request->fecha_fin);
        $general = DatosGenerales::all()->first();
        $data = DB::select(DB::raw(
            'select 
                ventas.fecha::date,
                codigo_barra,
                initcap(actividades.nombre) as descripcion,
                precio,
                sum(cantidad) as cantidad,
                sum(subtotal) as total
            from ventas_detalles_reservas
                inner join ventas on ventas.id = ventas_detalles_reservas.venta_id
                inner join reservas on reservas.id = ventas_detalles_reservas.reserva_id
                inner join eventos on eventos.id = reservas.evento_id
                inner join actividades on actividades.id = eventos.actividad_id
            where ventas.fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and ventas.estado = \'1\'
            group by ventas.fecha::date,
                codigo_barra,
                initcap(actividades.nombre),
                precio
            order by ventas.fecha::date, initcap(actividades.nombre)'
        ));
        $total_general = 0;
        foreach ($data as $key => $item) {
            $total_general += $item->total;
        }
        return view('venta.reporte.reserva')
            ->with('general', $general)
            ->with('data', $data)
            ->with('fecha_inicio', $fecha_inicio)
            ->with('fecha_fin', $fecha_fin)
            ->with('total_general', $total_general);
    }
}
