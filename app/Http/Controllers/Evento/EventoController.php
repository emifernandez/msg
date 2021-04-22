<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evento\StoreEventoRequest;
use App\Http\Requests\Evento\UpdateEventoRequest;
use App\Models\Actividad;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Evento();
        $this->authorize('view', $aux);
        $eventos = Evento::orderBy('fecha', 'desc')->get();
        $estados = Evento::ESTADO;
        return view('evento.index')
            ->with('eventos', $eventos)
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
        $this->authorize('create', new Evento());
        $estados = Evento::ESTADO;
        $actividades = Actividad::where('estado', '1')->orderBy('nombre', 'asc')->get();
        return view('evento.create')
            ->with('estados', $estados)
            ->with('actividades', $actividades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventoRequest $request)
    {
        $evento = new Evento($request->all());
        $evento->estado = '1'; //activo
        $evento->save();
        toast('Evento grabado correctamente', 'success');
        return redirect()->route('evento.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        $this->authorize('update', $evento);
        $actividades = Actividad::where('estado', '1')->orderBy('nombre', 'asc')->get();
        $estados = Evento::ESTADO;
        return view('evento.edit')
            ->with('estados', $estados)
            ->with('evento', $evento)
            ->with('actividades', $actividades);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        $evento->fill($request->all());
        $evento->save();
        toast('Evento actualizado correctamente', 'success');
        return redirect()->route('evento.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Evento());
        $evento = Evento::findOrFail($request->id);
        $evento->delete();
        toast('Evento eliminado correctamente', 'success');
        return redirect()->route('evento.index');
    }
}
