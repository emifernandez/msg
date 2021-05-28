<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Reserva;
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
        $aux = new Venta();
        $tipo_comprobantes = Venta::TIPO_COMPROBANTE;
        $forma_pagos = Venta::FORMA_PAGO;
        $medio_pagos = Venta::MEDIO_PAGO;
        $clientes = Cliente::where('estado', '1')->orderBy('nombre', 'asc')->get();
        $this->authorize('view', $aux);
        return view('venta.index')
            ->with('tipo_comprobantes', $tipo_comprobantes)
            ->with('forma_pagos', $forma_pagos)
            ->with('medio_pagos', $medio_pagos)
            ->with('clientes', $clientes);
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
    public function store(Request $request)
    {
        //
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
}
