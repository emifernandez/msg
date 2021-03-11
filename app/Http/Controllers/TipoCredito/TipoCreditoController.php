<?php

namespace App\Http\Controllers\TipoCredito;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoCredito\StoreTipoCreditoRequest;
use App\Http\Requests\TipoCredito\UpdateTipoCreditoRequest;
use App\Models\TipoCredito;
use Illuminate\Http\Request;

class TipoCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new TipoCredito();
        $this->authorize('view', $aux);
        $tipos = TipoCredito::orderBy('descripcion', 'asc')->get();
        return view('tipo-credito.index')
            ->with('tipos', $tipos)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new TipoCredito());
        return view('tipo-credito.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoCreditoRequest $request)
    {
        $tipo = new TipoCredito($request->all());
        $tipo->save();
        toast('Tipo grabado correctamente', 'success');
        return redirect()->route('tipo-credito.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoCredito  $tipoCredito
     * @return \Illuminate\Http\Response
     */
    public function show(TipoCredito $tipoCredito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoCredito  $tipoCredito
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoCredito $tipoCredito)
    {
        $this->authorize('update', new TipoCredito());
        return view('tipo-credito.edit')->with('tipoCredito', $tipoCredito);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoCredito  $tipoCredito
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoCreditoRequest $request, TipoCredito $tipoCredito)
    {
        $tipoCredito->fill($request->all());
        $tipoCredito->save();
        toast('Tipo actualizado correctamente', 'success');
        return redirect()->route('tipo-credito.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoCredito  $tipoCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new TipoCredito());
        $tipo = TipoCredito::findOrFail($request->id);
        $tipo->delete();
        toast('Tipo eliminado correctamente', 'success');
        return redirect()->route('tipo-credito.index');
    }
}
