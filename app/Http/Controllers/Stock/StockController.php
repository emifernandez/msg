<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Models\Stock;
use App\Models\Producto;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aux = new Stock();
        $this->authorize('view', $aux);
        $stocks = Stock::orderBy('created_at', 'desc')->get();
        return view('stock.index')
            ->with('stocks', $stocks)
            ->with('aux', $aux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', new Stock());
        $productos = Producto::where('estado', '1')->orderBy('nombre', 'asc')->get();
        return view('stock.create')
            ->with('productos', $productos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {
        $stock = new Stock($request->all());
        $stock->save();
        toast('Stock grabado correctamente', 'success');
        return redirect()->route('stock.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $this->authorize('update', new Stock());
        $productos = Producto::where('estado', '1')->orderBy('nombre', 'asc')->get();
        return view('stock.edit')
            ->with('productos', $productos)
            ->with('stock', $stock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $stock->fill($request->all());
        $stock->save();
        toast('Stock actualizado correctamente', 'success');
        return redirect()->route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', new Stock());
        $stock = Stock::findOrFail($request->id);
        $stock->delete();
        toast('Stock eliminado correctamente', 'success');
        return redirect()->route('stock.index');
    }
}
