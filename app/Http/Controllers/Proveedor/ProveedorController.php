<?php

namespace App\Http\Controllers\Proveedor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proveedor\StoreProveedorRequest;
use App\Http\Requests\Proveedor\UpdateProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Proveedor();
        $this->authorize('view', $aux);
        $proveedores = Proveedor::orderBy('razon_social', 'asc')->get();
        $estados = Proveedor::ESTADO;
        return view('proveedor.index')
            ->with('proveedores', $proveedores)
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
        $this->authorize('create', new Proveedor());
        $estados = Proveedor::ESTADO;
        return view('proveedor.create')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProveedorRequest $request)
    {
        $proveedor = new Proveedor($request->all());
        $proveedor->estado = 1; //activo
        $proveedor->save();
        toast('Proveedor grabado correctamente', 'success');
        return redirect()->route('proveedor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        $this->authorize('update', $proveedor);
        $estados = Proveedor::ESTADO;
        return view('proveedor.edit')
            ->with('estados', $estados)
            ->with('proveedor', $proveedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProveedorRequest $request, Proveedor $proveedor)
    {
        $proveedor->fill($request->all());
        $proveedor->save();
        toast('Proveedor actualizado correctamente', 'success');
        return redirect()->route('proveedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Proveedor());
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->delete();
        toast('Proveedor eliminado correctamente', 'success');
        return redirect()->route('proveedor.index');
    }
}
