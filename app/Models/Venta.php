<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Anulado',
    ];

    const TIPO_COMPROBANTE = [
        '1' => 'Factura',
        '2' => 'Ticket',
    ];

    const FORMA_PAGO = [
        '1' => 'Contado',
        '2' => 'Crédito',
    ];

    const MEDIO_PAGO = [
        '1' => 'Efectivo',
        '2' => 'Tarjeta Crédito',
        '3' => 'Tarjeta Débito',
        '4' => 'Cheque',
        '5' => 'Otro'
    ];

    protected $table = 'ventas';
    protected $fillable = [
        'fecha',
        'nro_factura',
        'prefijo_factura',
        'total',
        'total_iva10',
        'total_iva5',
        'total_iva0',
        'descuento',
        'estado',
        'tipo_comprobante',
        'forma_pago',
        'medio_pago',
        'cliente_id',
        'user_id',
    ];

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'ventas_detalles_reservas')->using(VentaDetalleReserva::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'ventas_detalles_productos')->using(VentaDetalleProducto::class);
    }
}
