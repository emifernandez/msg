<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

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
        return view('cliente.create')
            ->with('estados', $estados)
            ->with('calificaciones', $calificaciones)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('tipos_clientes', $tipos_clientes)
            ->with('generos', $generos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = new Cliente($request->all());
        $cliente->fecha_ingreso = now();
        $cliente->estado = 1; //activo
        $cliente->save();
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
        return view('cliente.edit')
            ->with('estados', $estados)
            ->with('calificaciones', $calificaciones)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('tipos_clientes', $tipos_clientes)
            ->with('generos', $generos)
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
}
