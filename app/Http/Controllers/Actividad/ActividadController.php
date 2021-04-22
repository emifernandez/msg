<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Actividad\StoreActividadRequest;
use App\Models\Actividad;
use App\Models\Empleado;
use App\Models\Salon;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Actividad();
        $this->authorize('view', $aux);
        $actividades = Actividad::orderBy('nombre', 'asc')->get();
        $estados = Actividad::ESTADO;
        return view('actividad.index')
            ->with('actividades', $actividades)
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
        $this->authorize('create', new Actividad());
        $estados = Actividad::ESTADO;
        $generos = Actividad::GENERO_HABILITADO;
        $servicios = Servicio::orderBy('descripcion', 'ASC')->get();
        $salones = Salon::orderBy('nombre', 'ASC')->get();
        $empleados = Empleado::where('estado', '1')
            ->orderBy('nombre', 'ASC')
            ->get();
        return view('actividad.create')
            ->with('estados', $estados)
            ->with('servicios', $servicios)
            ->with('salones', $salones)
            ->with('empleados', $empleados)
            ->with('generos', $generos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActividadRequest $request)
    {
        $actividad = new Actividad($request->all());
        $actividad->estado = '1'; //activo
        $this->setDias($actividad, $request);
        $actividad->save();
        toast('Actividad grabada correctamente', 'success');
        return redirect()->route('actividad.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividad $actividad)
    {
        $this->authorize('update', $actividad);
        $estados = Actividad::ESTADO;
        $generos = Actividad::GENERO_HABILITADO;
        $servicios = Servicio::orderBy('descripcion', 'ASC')->get();
        $salones = Salon::orderBy('nombre', 'ASC')->get();
        $empleados = Empleado::where('estado', '1')
            ->orderBy('nombre', 'ASC')
            ->get();
        $dias = str_split($actividad->dias);
        return view('actividad.edit')
            ->with('estados', $estados)
            ->with('servicios', $servicios)
            ->with('salones', $salones)
            ->with('empleados', $empleados)
            ->with('generos', $generos)
            ->with('dias', $dias)
            ->with('actividad', $actividad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividad $actividad)
    {
        $actividad->fill($request->all());
        $this->setDias($actividad, $request);
        $actividad->save();
        toast('Actividad actualizada correctamente', 'success');
        return redirect()->route('actividad.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Actividad());
        $actividad = Actividad::findOrFail($request->id);
        $actividad->delete();
        toast('Actividad eliminada correctamente', 'success');
        return redirect()->route('actividad.index');
    }

    private function setDias($actividad, $request)
    {
        $domingo = $request->domingo != null ? '1' : '0';
        $lunes = $request->lunes != null ? '1' : '0';
        $martes = $request->martes != null ? '1' : '0';
        $miercoles = $request->miercoles != null ? '1' : '0';
        $jueves = $request->jueves != null ? '1' : '0';
        $viernes = $request->viernes != null ? '1' : '0';
        $sabado = $request->sabado != null ? '1' : '0';
        return $actividad->dias = $domingo . $lunes . $martes . $miercoles . $jueves . $viernes . $sabado;
    }
}
