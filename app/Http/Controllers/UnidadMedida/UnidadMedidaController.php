<?php

namespace App\Http\Controllers\UnidadMedida;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadMedida\StoreUnidadMedidaRequest;
use App\Http\Requests\UnidadMedida\UpdateUnidadMedidaRequest;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new UnidadMedida();
        $this->authorize('view', $aux);
        $unidades = UnidadMedida::orderBy('nombre', 'asc')->get();
        return view('unidad.index')
            ->with('unidades', $unidades)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new UnidadMedida());
        return view('unidad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnidadMedidaRequest $request)
    {
        $unidad = new UnidadMedida($request->all());
        $unidad->save();
        toast('Unidad de Medida grabada correctamente', 'success');
        return redirect()->route('unidad.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnidadMedida  $unidadMedida
     * @return \Illuminate\Http\Response
     */
    public function show(UnidadMedida $unidadMedida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnidadMedida  $unidadMedida
     * @return \Illuminate\Http\Response
     */
    public function edit(UnidadMedida $unidad)
    {
        $this->authorize('update', $unidad);
        return view('unidad.edit')
            ->with('unidad', $unidad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnidadMedida  $unidadMedida
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnidadMedidaRequest $request, UnidadMedida $unidad)
    {
        $unidad->fill($request->all());
        $unidad->save();
        toast('Unidad de Medida actualizada correctamente', 'success');
        return redirect()->route('unidad.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnidadMedida  $unidadMedida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new UnidadMedida());
        $unidad = UnidadMedida::findOrFail($request->id);
        $unidad->delete();
        toast('Unidad de Medida eliminada correctamente', 'success');
        return redirect()->route('unidad.index');
    }
}
