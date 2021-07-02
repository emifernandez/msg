<?php

namespace App\Http\Controllers\Cliente;

use App\Formatters\DateFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\DatosGenerales;
use App\Models\Rol;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Cliente();
        $this->authorize('view', $aux);
        $clientes = Cliente::orderBy('nombre', 'asc')->get();
        $estados = Cliente::ESTADO;
        return view('cliente.index')
            ->with('clientes', $clientes)
            ->with('estados', $estados)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Cliente());
        $estados = Cliente::ESTADO;
        $calificaciones = Cliente::CALIFICACION;
        $tipos_documentos = Cliente::TIPO_DOCUMENTO;
        $tipos_clientes = Cliente::TIPO_CLIENTE;
        $generos = Cliente::GENERO;
        $organizaciones = Cliente::where('tipo_cliente', '2')
            ->orderBy('razon_social', 'ASC')
            ->get();
        return view('cliente.create')
            ->with('estados', $estados)
            ->with('calificaciones', $calificaciones)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('tipos_clientes', $tipos_clientes)
            ->with('generos', $generos)
            ->with('organizaciones', $organizaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $cliente = new Cliente($request->all());
            $cliente->fecha_ingreso = now();
            $cliente->estado = 1; //activo
            $cliente->save();
            if ($cliente->tipo_cliente == '1') {
                $usuario = new User();
                $usuario->name = $cliente->nombre;
                $usuario->lastname = $cliente->apellido;
                $usuario->email = $cliente->email;
                $usuario->password = Hash::make($usuario->generatePassword());
                $usuario->save();
                $usuario->roles()->attach(Rol::where('nombre', 'usuario')->first());
                $usuario->sendEmailVerificationNotification();
            }
        });
        toast('Cliente grabado correctamente', 'success');
        return redirect()->route('cliente.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $this->authorize('update', $cliente);
        $estados = Cliente::ESTADO;
        $calificaciones = Cliente::CALIFICACION;
        $tipos_documentos = Cliente::TIPO_DOCUMENTO;
        $tipos_clientes = Cliente::TIPO_CLIENTE;
        $generos = Cliente::GENERO;
        $organizaciones = Cliente::where('tipo_cliente', '2')
            ->orderBy('razon_social', 'ASC')
            ->get();
        return view('cliente.edit')
            ->with('estados', $estados)
            ->with('calificaciones', $calificaciones)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('tipos_clientes', $tipos_clientes)
            ->with('generos', $generos)
            ->with('organizaciones', $organizaciones)
            ->with('cliente', $cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->fill($request->all());
        $cliente->save();
        toast('Cliente actualizado correctamente', 'success');
        return redirect()->route('cliente.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Cliente());
        $cliente = Cliente::findOrFail($request->id);
        $cliente->delete();
        toast('Cliente eliminado correctamente', 'success');
        return redirect()->route('cliente.index');
    }

    public function reporteEstadoCuenta()
    {
        $estados = Venta::ESTADO;
        $tipos_comprobantes = Venta::TIPO_COMPROBANTE;
        $clientes = Cliente::orderBy('nombre', 'asc')->get();
        return view('cliente.reporte-estado-cuenta')
            ->with('estados', $estados)
            ->with('clientes', $clientes)
            ->with('tipos_comprobantes', $tipos_comprobantes);
    }


    public function getReporteEstadoCuenta(Request $request)
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
            where (cliente_id = ' . $request->cliente_id . ' or 0 = ' . $request->cliente_id . ') 
            and fecha::date between \'' . $fecha_inicio->forString() . '\' and \'' . $fecha_fin->forString() . '\'
            and (ventas.estado = \'' . $request->estado . '\' or \'0\' = \'' . $request->estado . '\')
            and (tipo_comprobante = \'' . $request->tipo_comprobante . '\' or \'0\' = \'' . $request->tipo_comprobante . '\')'
        ));
        $reservas = DB::select(DB::raw(
            'select
                eventos.fecha,
                initcap(actividades.nombre) as descripcion,
                to_char(actividades.hora_inicio, \'HH:MM\') as hora_inicio,
                to_char(actividades.hora_fin, \'HH:MM\') as hora_fin
            from reservas
                inner join eventos on eventos.id = reservas.evento_id
                inner join actividades on actividades.id = eventos.actividad_id
            where cliente_id = ' . $request->cliente_id . '
            and reservas.estado = \'1\'
            order by eventos.fecha, actividades.hora_inicio'
        ));
        $total_general = 0;
        foreach ($data as $key => $item) {
            $total_general += $item->total;
        }
        return view('cliente.reporte.estadocuenta')
            ->with('general', $general)
            ->with('data', $data)
            ->with('estados', $estados)
            ->with('tipos', $tipos)
            ->with('fecha_inicio', $fecha_inicio)
            ->with('fecha_fin', $fecha_fin)
            ->with('estado', $estado)
            ->with('tipo_comprobante', $tipo_comprobante)
            ->with('total_general', $total_general)
            ->with('reservas', $reservas);
    }
}
