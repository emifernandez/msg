<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empleado\StoreEmpleadoRequest;
use App\Http\Requests\Empleado\UpdateEmpleadoRequest;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Empleado();
        $this->authorize('view', $aux);
        $empleados = Empleado::orderBy('nombre', 'asc')->get();
        $estados = Empleado::ESTADO;
        return view('empleado.index')
            ->with('empleados', $empleados)
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
        $this->authorize('create', new Empleado());
        $estados = Empleado::ESTADO;
        $tipos_documentos = Empleado::TIPO_DOCUMENTO;
        $generos = Empleado::GENERO;
        return view('empleado.create')
            ->with('estados', $estados)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('generos', $generos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmpleadoRequest $request)
    {
        $empleado = new Empleado($request->all());
        $empleado->fecha_ingreso = now();
        $empleado->estado = 1; //activo
        $empleado->save();
        toast('Empleado grabado correctamente', 'success');
        return redirect()->route('empleado.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $this->authorize('update', $empleado);
        $estados = Empleado::ESTADO;
        $tipos_documentos = Empleado::TIPO_DOCUMENTO;
        $generos = Empleado::GENERO;
        return view('empleado.edit')
            ->with('estados', $estados)
            ->with('tipos_documentos', $tipos_documentos)
            ->with('generos', $generos)
            ->with('empleado', $empleado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpleadoRequest $request, Empleado $empleado)
    {
        $empleado->fill($request->all());
        $empleado->save();
        toast('Empleado actualizado correctamente', 'success');
        return redirect()->route('empleado.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Empleado());
        $empleado = Empleado::findOrFail($request->id);
        $empleado->delete();
        toast('Empleado eliminado correctamente', 'success');
        return redirect()->route('empleado.index');
    }
}
