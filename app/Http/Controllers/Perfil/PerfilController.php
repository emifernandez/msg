<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perfil\StorePerfilRequest;
use App\Http\Requests\Perfil\UpdatePerfilRequest;
use App\Models\Perfil;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Perfil::all();
        return view('perfil.index')->with('perfiles', $perfiles);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perfil.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerfilRequest $request)
    {
        $perfil = new Perfil([
            'perfil' => $request->get('perfil')
        ]);
        $perfil->save();
        return redirect('/perfil')->with('success', 'Perfil grabado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        return view('perfil.edit')->with('perfil',$perfil);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        $perfil->fill($request->all());
        $perfil->save();
    	return redirect('perfil')->with('success', 'Perfil editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $perfil = Perfil::findOrFail($request->id);
        $perfil->delete();
        return redirect()->route('perfil.index')->with('success', 'Perfil eliminado correctamente');
    }
}
