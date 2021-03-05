<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', new User());
        $usuarios = User::orderBy('name', 'asc')->get();
        return view('usuario.index')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new User());
        $roles = Rol::orderBy('descripcion', 'asc')->get();
        return view('usuario.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsuarioRequest $request)
    {
        $usuario = new User($request->all());
        $usuario->password = Hash::make($request->get('password'));
        DB::transaction(function () use ($usuario, $request) {
            $usuario->save();
            $usuario->roles()->attach(Rol::where('id', $request->get('rol'))->first());
        });
        toast('Usuario grabado correctamente', 'success');
        return redirect()->route('usuario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $this->authorize('update', new User());
        $roles = Rol::orderBy('descripcion', 'asc')->get();
        return view('usuario.edit')
            ->with('usuario', $usuario)
            ->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $usuario->fill($request->all());
        DB::transaction(function () use ($usuario, $request) {
            $usuario->roles()->detach();
            $usuario->roles()->attach(Rol::where('id', $request->get('rol'))->first());
            $usuario->save();
        });
        toast('Usuario actualizado correctamente', 'success');
        return redirect()->route('usuario.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new User());
        $usuario = User::findOrFail($request->id);
        $roles = $usuario->roles()->get();
        foreach ($roles as $rol) {
            $rol->pivot->delete();
        }
        $usuario->delete();
        toast('Usurio eliminado correctamente', 'success');
        return redirect()->route('usuario.index');
    }
}
