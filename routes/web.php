<?php

use App\Http\Controllers\Actividad\ActividadController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Empleado\EmpleadoController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Ficha\FichaController;
use App\Http\Controllers\Grupo\GrupoController;
use App\Http\Controllers\Marca\MarcaController;
use App\Http\Controllers\Producto\ProductoController;
use App\Http\Controllers\Proveedor\ProveedorController;
use App\Http\Controllers\Reserva\ReservaController;
use App\Http\Controllers\Rol\RolController;
use App\Http\Controllers\Salon\SalonController;
use App\Http\Controllers\Servicio\ServicioController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\TipoCredito\TipoCreditoController;
use App\Http\Controllers\UnidadMedida\UnidadMedidaController;
use App\Http\Controllers\Facturacion\VentaController;
use App\Http\Controllers\General\DatosGeneralesController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth', 'roles']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('actividad', ActividadController::class);
    Route::resource('cliente', ClienteController::class);
    Route::resource('empleado', EmpleadoController::class);
    Route::resource('evento', EventoController::class);
    Route::resource('ficha', FichaController::class);
    Route::resource('general', DatosGeneralesController::class);
    Route::resource('grupo', GrupoController::class);
    Route::resource('marca', MarcaController::class);
    Route::resource('producto', ProductoController::class);
    Route::resource('proveedor', ProveedorController::class);
    Route::resource('reserva', ReservaController::class);
    Route::resource('rol', RolController::class);
    Route::resource('salon', SalonController::class);
    Route::resource('servicio', ServicioController::class);
    Route::resource('stock', StockController::class);
    Route::resource('tipo-credito', TipoCreditoController::class);
    Route::resource('unidad', UnidadMedidaController::class);
    Route::resource('venta', VentaController::class);
    Route::resource('usuario', UsuarioController::class);

    Route::post('/getEventos', [App\Http\Controllers\Reserva\ReservaController::class, 'getEventos'])->name('getEventos');
    Route::post('/getCliente', [App\Http\Controllers\Facturacion\VentaController::class, 'getCliente'])->name('getCliente');
    Route::post('/getStock', [App\Http\Controllers\Facturacion\VentaController::class, 'getStock'])->name('getStock');

    Route::get('print-ficha/{id}', [App\Http\Controllers\Ficha\FichaController::class, 'printFicha'])->name('printFicha');
});
