<?php

namespace App\Http\Controllers\Reserva;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reserva\StoreReservaRequest;
use App\Models\Actividad;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Reserva();
        $this->authorize('view', $aux);
        $reservas = Reserva::orderBy('created_at', 'asc')->get();
        $estados = Reserva::ESTADO;
        return view('reserva.index')
            ->with('reservas', $reservas)
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
        $this->authorize('create', new Reserva());
        $estados = Reserva::ESTADO;

        $clientes = Cliente::where('estado', '1')
            ->orderBy('nombre', 'ASC')
            ->get();
        $actividades = Actividad::whereRaw('now()::date BETWEEN fecha_inicio AND fecha_fin
            OR (fecha_fin IS null AND fecha_inicio <= now()::date)')->get();
        return view('reserva.create')
            ->with('estados', $estados)
            ->with('clientes', $clientes)
            ->with('actividades', $actividades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservaRequest $request)
    {
        $eventos = $request->input('eventos', []);
        if ($eventos != 'null') {
            DB::transaction(function () use ($eventos, $request) {
                foreach ($eventos as $i => $e) {
                    $evento = Evento::find($e);
                    $evento->lugares_disponibles = $evento->lugares_disponibles - 1;
                    $evento->save();

                    $reserva = new Reserva();
                    $reserva->estado = '1'; //reservado
                    $reserva->cliente_id = $request->cliente_id;
                    $reserva->evento_id = $evento->id;
                    $reserva->save();
                }
            });
            toast('Reserva registrada correctamente', 'success');
            return redirect()->route('reserva.index');
        } else {
            toast('Debe seleccionar por lo menos un evento para realizar la reserva', 'warning');
            return redirect()->back();
        }
        $reserva = new Reserva($request->all());
        dd($reserva);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $reserva = Reserva::findOrFail($request->id);

            $evento = Evento::findOrFail($reserva->evento_id);
            $evento->lugares_disponibles = $evento->lugares_disponibles + 1;
            $evento->save();

            $reserva->estado = '3'; //cancelado
            $reserva->save();
        });
        toast('Reserva cancelada correctamente', 'success');
        return redirect()->route('reserva.index');
    }

    public function getEventos(Request $request)
    {
        if (isset($request->fecha_inicio) && isset($request->fecha_fin) && isset($request->actividad_id)) {

            $eventos = Evento::whereRaw('fecha between \'' . $request->fecha_inicio . '\' and \'' . $request->fecha_fin . '\'
            and actividad_id = ' . $request->actividad_id . '
            and estado = \'1\'
            and lugares_disponibles > 0
            and id not in (select evento_id from reservas where cliente_id = ' . $request->cliente_id . ' and (estado = \'1\' or estado = \'2\'))')->get();
            $data['data'] = $eventos;
            echo json_encode($data);
        }
        exit;
    }
}
