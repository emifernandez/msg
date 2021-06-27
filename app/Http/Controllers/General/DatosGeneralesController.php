<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\StoreDatosGeneralesRequest;
use App\Models\DatosGenerales;
use Illuminate\Http\Request;

class DatosGeneralesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $general = DatosGenerales::all();
        if ($general->count() > 0) {
            $aux = $general->first();
            $this->authorize('create', $aux);
            return view('general.index')
                ->with('aux', $aux);
        } else {
            $aux = new DatosGenerales();
            $this->authorize('create', $aux);
            return view('general.index')
                ->with('aux', $aux);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDatosGeneralesRequest $request)
    {
        $data = DatosGenerales::all();
        if ($data->count() > 0) {
            $general = $data->first();
            $general->fill($request->all());
            $general->save();
        } else {
            $general = new DatosGenerales($request->all());
            $general->save();
        }
        toast('Datos Generales grabados correctamente', 'success');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DatosGenerales  $datosGenerales
     * @return \Illuminate\Http\Response
     */
    public function show(DatosGenerales $datosGenerales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DatosGenerales  $datosGenerales
     * @return \Illuminate\Http\Response
     */
    public function edit(DatosGenerales $datosGenerales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DatosGenerales  $datosGenerales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DatosGenerales $datosGenerales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DatosGenerales  $datosGenerales
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatosGenerales $datosGenerales)
    {
        //
    }
}
