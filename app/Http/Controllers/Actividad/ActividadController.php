<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Actividad\StoreActividadRequest;
use App\Http\Requests\Actividad\UpdateActividadRequest;
use App\Models\Actividad;
use App\Models\Empleado;
use App\Models\Salon;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($this->checkDuplicados($actividad)) {
            $actividad->save();
            toast('Actividad grabada correctamente', 'success');
            return redirect()->route('actividad.index');
        } else {
            alert('Actividad Duplicada', 'El salón y/o empleado seleccionado ya se encuentra ocupado para el rango de fechas seleccionado', 'warning');
            return redirect()->back();
        }
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
    public function update(UpdateActividadRequest $request, Actividad $actividad)
    {
        $actividad->fill($request->all());
        $this->setDias($actividad, $request);
        if ($this->checkDuplicados($actividad)) {
            $actividad->save();
            toast('Actividad actualizada correctamente', 'success');
            return redirect()->route('actividad.index');
        } else {
            alert('Actividad Duplicada', 'El salón y/o empleado seleccionado ya se encuentra ocupado para el rango de fechas seleccionado', 'warning');
            return redirect()->back();
        }
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

    private function checkDuplicados($actividad)
    {
        $duplicados = DB::table('actividades')
            ->select(DB::raw('count(*) as duplicados'))
            ->whereRaw('(salon_id = ' . $actividad->salon_id . ' OR empleado_id = ' . $actividad->empleado_id . ')
                AND ((fecha_fin IS NULL AND fecha_inicio' . (!empty($actividad->fecha_fin->forString()) ? (' BETWEEN \'' . $actividad->fecha_inicio->forString() . '\' and \'' . $actividad->fecha_fin->forString() . '\'') : (' <= \'' . $actividad->fecha_inicio->forString() . '\' ')) . ')
                    OR (\'' . $actividad->fecha_inicio->forString() . '\' BETWEEN fecha_inicio and fecha_fin' . (!empty($actividad->fecha_fin->forString()) ? (' OR \'' . $actividad->fecha_fin->forString() . '\' BETWEEN fecha_inicio and fecha_fin))') : ')) ') . '
                AND ((\'' . $actividad->hora_inicio->forStringHour() . '\' BETWEEN hora_inicio and hora_fin) OR (\'' . $actividad->hora_fin->forStringHour() . '\' BETWEEN hora_inicio and hora_fin))
                AND (substr(\'' . $actividad->dias . '\', 1, 1) = substr(dias, 1, 1)
                    OR substr(\'' . $actividad->dias . '\', 2, 1) = substr(dias, 2, 1)
                    OR substr(\'' . $actividad->dias . '\', 3, 1) = substr(dias, 3, 1)
                    OR substr(\'' . $actividad->dias . '\', 4, 1) = substr(dias, 4, 1)
                    OR substr(\'' . $actividad->dias . '\', 5, 1) = substr(dias, 5, 1)
                    OR substr(\'' . $actividad->dias . '\', 6, 1) = substr(dias, 6, 1)
                    OR substr(\'' . $actividad->dias . '\', 7, 1) = substr(dias, 7, 1)) ' . (isset($actividad->id) ? (' AND id <> ' . $actividad->id) : ''))
            ->get();
        return 0 == (isset($duplicados) ? $duplicados[0]->duplicados : 0);
    }
}
