<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Servicio\StoreServicioRequest;
use App\Http\Requests\Servicio\UpdateServicioRequest;
use App\Models\Servicio;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Servicio();
        $this->authorize('view', $aux);
        $servicios = Servicio::orderBy('descripcion', 'asc')->get();
        return view('servicio.index')
            ->with('servicios', $servicios)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $servicio = new Servicio();
        $this->authorize('create', $servicio);
        return view('servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicioRequest $request)
    {
        $cantidades = $request->input('cantidades', []);
        $precios = $request->input('precios', []);
        $ivas = $request->input('ivas', []);
        if (count($cantidades) > 0) {
            DB::transaction(function () use ($request, $cantidades, $precios, $ivas) {
                $servicio = Servicio::create([
                    'descripcion' => $request->get('descripcion'),
                ]);
                if ($cantidades != 'null') {
                    foreach ($cantidades as $i => $cantidad) {
                        $detalle = new ServicioDetalle();
                        $detalle->servicio_id = $servicio->id;
                        $detalle->cantidad = $cantidad;
                        $detalle->precio = $precios[$i];
                        $detalle->iva = $ivas[$i];
                        $detalle->save();
                    }
                }
            });
            toast('Servicio grabado correctamente', 'success');
            return redirect()->route('servicio.index');
        } else {
            toast('Debe ingresar al menos un detalle para grabar el servicio', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        $this->authorize('update', new Servicio());
        return view('servicio.edit')->with('servicio', $servicio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicioRequest $request, Servicio $servicio)
    {
        $servicio->fill($request->all());
        $cantidades = $request->input('cantidades', []);
        $precios = $request->input('precios', []);
        $ivas = $request->input('ivas', []);
        if (count($cantidades) > 0) {
            DB::transaction(function () use ($servicio, $cantidades, $precios, $ivas) {
                $detalle = $servicio->detalle()->get();
                foreach ($detalle as $item) {
                    $item->delete();
                }
                $servicio->save();
                if ($cantidades != 'null') {
                    foreach ($cantidades as $i => $cantidad) {
                        $detalle = new ServicioDetalle();
                        $detalle->servicio_id = $servicio->id;
                        $detalle->cantidad = $cantidad;
                        $detalle->precio = $precios[$i];
                        $detalle->iva = $ivas[$i];
                        $detalle->save();
                    }
                }
            });
            toast('Servicio grabado correctamente', 'success');
            return redirect()->route('servicio.index');
        } else {
            toast('Debe ingresar al menos un detalle para grabar el servicio', 'warning');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Servicio());
        $servicio = Servicio::findOrFail($request->id);
        $detalle = $servicio->detalle()->get();
        foreach ($detalle as $item) {
            $item->delete();
        }
        $servicio->delete();
        toast('Servicio eliminado correctamente', 'success');
        return redirect()->route('servicio.index');
    }
}
