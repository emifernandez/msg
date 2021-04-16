<?php

namespace App\Http\Controllers\Ficha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ficha\StoreFichaRequest;
use App\Http\Requests\Ficha\UpdateFichaRequest;
use App\Models\Cliente;
use App\Models\Ficha;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Ficha();
        $this->authorize('view', $aux);
        $fichas = Ficha::all();
        return view('ficha.index')
            ->with('fichas', $fichas)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Ficha());
        $clientes = Cliente::where('estado', '1')
            ->where('tipo_cliente', '1')
            ->orderBy('nombre', 'asc')->get();;
        return view('ficha.create')
            ->with('clientes', $clientes)
            ->with('selected', false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFichaRequest $request)
    {
        $ficha = new Ficha($request->all());
        $ficha->save();
        toast('Ficha grabada correctamente', 'success');
        return redirect()->route('ficha.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function show($cliente_id)
    {
        $aux = new Ficha();
        $this->authorize('view', $aux);
        $fichas = Ficha::where('cliente_id', $cliente_id)->get();
        return view('ficha.index')
            ->with('fichas', $fichas)
            ->with('aux', $aux);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function edit(Ficha $ficha)
    {
        $this->authorize('update', new Ficha());
        $clientes = Cliente::where('estado', '1')
            ->where('tipo_cliente', '1')
            ->orderBy('nombre', 'asc')->get();
        return view('ficha.edit')
            ->with('clientes', $clientes)
            ->with('ficha', $ficha);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFichaRequest $request, Ficha $ficha)
    {
        $ficha->fill($request->all());
        $ficha->save();
        toast('Ficha actualizada correctamente', 'success');
        return redirect()->route('ficha.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Ficha());
        $ficha = Ficha::findOrFail($request->id);
        $ficha->delete();
        toast('Ficha eliminada correctamente', 'success');
        return redirect()->route('ficha.index');
    }
}
