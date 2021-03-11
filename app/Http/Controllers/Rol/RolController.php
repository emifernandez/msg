<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rol\StoreRolRequest;
use App\Http\Requests\Rol\UpdateRolRequest;
use App\Models\Acceso;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Rol();
        $this->authorize('view', $aux);
        $roles = Rol::orderBy('descripcion', 'asc')->get();
        return view('rol.index')
            ->with('roles', $roles)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Rol());
        $accesos = Acceso::where('nivel', '>', 1)
            ->orderBy('modulo', 'asc')
            ->orderBy('descripcion', 'asc')->get();
        return view('rol.create')
            ->with('accesos', $accesos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolRequest $request)
    {
        $rol = new Rol();
        $rol->nombre = $request->get('nombre');
        $rol->descripcion = $request->get('descripcion');
        $accesos = $request->input('acceso', []);
        $crear = $request->input('crear', []);
        $modificar = $request->input('modificar', []);
        $eliminar = $request->input('eliminar', []);
        $visualizar = $request->input('visualizar', []);
        $imprimir = $request->input('imprimir', []);
        $anular = $request->input('anular', []);
        if ($accesos != 'null') {
            DB::transaction(function () use ($rol, $accesos, $crear, $modificar, $eliminar, $visualizar, $imprimir, $anular) {
                $rol->save();
                if ($accesos != 'null') {
                    foreach ($accesos as $i => $acceso) {
                        $rol->accesos()->attach($rol, [
                            'acceso_id' => $acceso,
                            'crear' => in_array($acceso, $crear),
                            'modificar' => in_array($acceso, $modificar),
                            'eliminar' => in_array($acceso, $eliminar),
                            'visualizar' => in_array($acceso, $visualizar),
                            'imprimir' => in_array($acceso, $imprimir),
                            'anular' => in_array($acceso, $anular),
                        ]);
                    }
                }
            });
            toast('Rol grabado correctamente', 'success');
            return redirect()->route('rol.index');
        } else {
            toast('Debe ingresar al menos un acceso para grabar el permiso', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit(Rol $rol)
    {
        $this->authorize('update', $rol);
        $accesos = Acceso::where('nivel', '>', 1)
            ->orderBy('modulo', 'asc')
            ->orderBy('descripcion', 'asc')->get();
        $permisos = $rol->accesos()->get();
        return view('rol.edit')
            ->with('rol', $rol)
            ->with('accesos', $accesos)
            ->with('permisos', $permisos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolRequest $request, Rol $rol)
    {
        $rol->nombre = $request->get('nombre');
        $rol->descripcion = $request->get('descripcion');
        $accesos = $request->input('acceso', []);
        $crear = $request->input('crear', []);
        $modificar = $request->input('modificar', []);
        $eliminar = $request->input('eliminar', []);
        $visualizar = $request->input('visualizar', []);
        $imprimir = $request->input('imprimir', []);
        $anular = $request->input('anular', []);
        if ($accesos != 'null') {
            DB::transaction(function () use ($rol, $accesos, $crear, $modificar, $eliminar, $visualizar, $imprimir, $anular) {
                if ($accesos != 'null') {
                    $rol->accesos()->detach();
                    foreach ($accesos as $i => $acceso) {
                        $rol->accesos()->attach($rol, [
                            'acceso_id' => $acceso,
                            'crear' => in_array($acceso, $crear),
                            'modificar' => in_array($acceso, $modificar),
                            'eliminar' => in_array($acceso, $eliminar),
                            'visualizar' => in_array($acceso, $visualizar),
                            'imprimir' => in_array($acceso, $imprimir),
                            'anular' => in_array($acceso, $anular),
                        ]);
                    }
                }
                $rol->update();
            });
            toast('Rol actualizado correctamente', 'success');
            return redirect()->route('rol.index');
        } else {
            toast('Debe ingresar al menos un acceso para grabar el permiso', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Rol());
        $rol = Rol::findOrFail($request->id);
        $accesos = $rol->accesos()->get();
        foreach ($accesos as $acceso) {
            $acceso->permisos->delete();
        }
        $rol->delete();
        toast('Rol eliminado correctamente', 'success');
        return redirect()->route('rol.index');
    }
}
