<?php

namespace App\Http\Controllers\Salon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\StoreSalonRequest;
use App\Http\Requests\Salon\UpdateSalonRequest;
use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Salon();
        $this->authorize('view', $aux);
        $salones = Salon::orderBy('nombre', 'asc')->get();
        return view('salon.index')
            ->with('salones', $salones)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Salon());
        return view('salon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalonRequest $request)
    {
        $salon = new Salon($request->all());
        $salon->save();
        toast('Salón grabado correctamente', 'success');
        return redirect()->route('salon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function show(Salon $salon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function edit(Salon $salon)
    {
        $this->authorize('update', new Salon());
        return view('salon.edit')->with('salon', $salon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalonRequest $request, Salon $salon)
    {
        $salon->fill($request->all());
        $salon->save();
        toast('Salón actualizado correctamente', 'success');
        return redirect()->route('salon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Salon());
        $salon = Salon::findOrFail($request->id);
        $salon->delete();
        toast('Salón eliminado correctamente', 'success');
        return redirect()->route('salon.index');
    }
}
