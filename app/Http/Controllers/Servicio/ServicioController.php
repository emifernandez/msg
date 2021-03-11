<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Servicio\StoreServicioRequest;
use App\Http\Requests\Servicio\UpdateServicioRequest;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Servicio();
        $this->authorize('view', $aux);
        $servicios = Servicio::orderBy('descripcion', 'asc')->get();
        return view('servicio.index')
            ->with('servicios', $servicios)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $servicio = new Servicio();
        $this->authorize('create', $servicio);
        return view('servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicioRequest $request)
    {
        $servicio = new Servicio($request->all());
        $servicio->save();
        toast('Servicio grabado correctamente', 'success');
        return redirect()->route('servicio.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        $this->authorize('update', new Servicio());
        return view('servicio.edit')->with('servicio', $servicio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicioRequest $request, Servicio $servicio)
    {
        $servicio->fill($request->all());
        $servicio->save();
        toast('Servicio actualizado correctamente', 'success');
        return redirect()->route('servicio.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Servicio());
        $servicio = Servicio::findOrFail($request->id);
        $servicio->delete();
        toast('Servicio eliminado correctamente', 'success');
        return redirect()->route('servicio.index');
    }
}
