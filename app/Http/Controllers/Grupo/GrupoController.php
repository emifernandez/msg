<?php

namespace App\Http\Controllers\Grupo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grupo\StoreGrupoRequest;
use App\Http\Requests\Grupo\UpdateGrupoRequest;
use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Grupo();
        $this->authorize('view', $aux);
        $grupos = Grupo::orderBy('nombre', 'asc')->get();
        return view('grupo.index')
            ->with('grupos', $grupos)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Grupo());
        return view('grupo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoRequest $request)
    {
        $grupo = new Grupo($request->all());
        $grupo->save();
        toast('Grupo grabado correctamente', 'success');
        return redirect()->route('grupo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        $this->authorize('update', $grupo);
        return view('grupo.edit')
            ->with('grupo', $grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        $grupo->fill($request->all());
        $grupo->save();
        toast('Grupo actualizado correctamente', 'success');
        return redirect()->route('grupo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Grupo());
        $grupo = Grupo::findOrFail($request->id);
        $grupo->delete();
        toast('Grupo eliminado correctamente', 'success');
        return redirect()->route('grupo.index');
    }
}
