<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producto\StoreProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Models\Grupo;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Producto();
        $this->authorize('view', $aux);
        $productos = Producto::orderBy('nombre', 'asc')->get();
        $estados = Producto::ESTADO;
        return view('producto.index')
            ->with('productos', $productos)
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
        $this->authorize('create', new Producto());
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $unidades = UnidadMedida::orderBy('nombre', 'asc')->get();
        $grupos = Grupo::orderBy('nombre', 'asc')->get();
        $estados = Producto::ESTADO;
        return view('producto.create')
            ->with('estados', $estados)
            ->with('marcas', $marcas)
            ->with('grupos', $grupos)
            ->with('unidades', $unidades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoRequest $request)
    {

        $producto = new Producto($request->all());
        $producto->estado = 1; //activo
        $producto->save();
        toast('Producto grabado correctamente', 'success');
        return redirect()->route('producto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $this->authorize('update', new Producto());
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $unidades = UnidadMedida::orderBy('nombre', 'asc')->get();
        $grupos = Grupo::orderBy('nombre', 'asc')->get();
        $estados = Producto::ESTADO;
        return view('producto.edit')
            ->with('estados', $estados)
            ->with('marcas', $marcas)
            ->with('unidades', $unidades)
            ->with('grupos', $grupos)
            ->with('producto', $producto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto->fill($request->all());
        $producto->save();
        toast('Producto actualizado correctamente', 'success');
        return redirect()->route('producto.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Producto());
        $producto = Producto::findOrFail($request->id);
        $producto->delete();
        toast('Producto eliminado correctamente', 'success');
        return redirect()->route('producto.index');
    }
}
